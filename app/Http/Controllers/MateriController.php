<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use App\Models\Materi;
use setasign\Fpdi\Fpdi;
use App\Models\ModulUser;
use App\Models\MateriUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\GetResource;
use App\Http\Resources\PostAuthResource;
use App\Models\Certificate;
use Illuminate\Validation\ValidationException;

class MateriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materi = Materi::all()->map(function ($item) {
            // Ambil data tambahan sesuai dengan kebutuhan Anda
            $jumlahModul = Modul::where('id_materi', $item->id)->count();
            $jumlahSiswa = MateriUser::where('id_materi', $item->id)->count();

            return [
                'uuid' => $item->uuid,
                'cover' => $item->cover,
                'materi' => $item->materi,
                'deskripsi' => $item->deskripsi,
                'lanjutan' => $item->lanjutan,
                'jumlah_siswa' => $jumlahSiswa, // Tambahkan nama siswa
                'jumlah_modul' => $jumlahModul, // Tambahkan jumlah modul
                'waktu' => $item->waktu
            ];
        });

        return new GetResource(200, 'Sukses mengambil data', $materi);
    }

    public function search(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'query' => 'string|required'
            ]);

            $materi = Materi::search($validatedData['query'])->get();
            // dd($materi);
            return new PostAuthResource(200, 'Sukses mengambil data', $materi);
        } catch (ValidationException $e) {
            new PostAuthResource(422, 'Terjadi kesalahan', $e->errors());
        }
    }


    public function detail(Materi $materi, string $modul, Request $request)
    {
        $modul = Modul::where('uuid', $modul)->first();
        if ($modul->id_materi === $materi->id) {
            if (ModulUser::where('id_user', $request->user()->id)->where('id_modul', $modul->id)->first()) {
                return new GetResource(200, 'Sukses mengambil data', $modul);
            }
        }
        return new GetResource(403, 'Dilarang masuk! Anda tidak terdaftar/belum menyelesaikan materi sebelumnya');
    }

    public function lastest()
    {
        return new GetResource(200, 'Sukses mengambil data', Materi::latest()->get());
    }


    public function checkUser(Materi $materi, Request $request)
    {
        $materi = MateriUser::where('id_user', $request->user()->id)->where('id_materi', $materi->id)->first();
        if (!$materi) {
            $materi = [
                'joined' => false
            ];
        } else {
            $materi = [
                'joined' => true
            ];
        }
        return new GetResource(200, 'Sukses mengambil data', $materi);
    }

    public function registerCourse(Materi $materi, Request $request)
    {
        if (MateriUser::where('id_user', $request->user()->id)->where('id_materi', $materi->id)->first()) {
            $materiuser = [
                'joined' => false
            ];
        } else {
            DB::transaction(function () use ($materi, $request, &$materiuser) {
                $validatedData = [
                    'id_materi' => $materi->id,
                    'id_user' => $request->user()->id,
                    'status' => true
                ];
                $materiuser = MateriUser::create($validatedData);


                $validatedData = [
                    'id_user' => $request->user()->id,
                    'id_modul' => Modul::where('id_materi', $materi->id)->orderBy('created_at', 'asc')->first()->id,
                    'status' => true,
                ];
                ModulUser::create($validatedData);
            });
            return new PostAuthResource(200, 'Sukses mendaftar kelas!', $materiuser->status);
        }
        return new PostAuthResource(422, 'Terjadi kesalahan', $materiuser);
    }


    public function generateCertificate(Materi $materi, Request $request)
    {

        if (
            Modul::where('id_materi', $materi->id)->count() === Modul::where('id_materi', $materi->id)
            ->whereHas('user', function ($query) use ($request) {
                $query->where('id_user', $request->user()->id);
            })
            ->count() && MateriUser::where('id_materi', $materi->id)->where('id_user', $request->user()->id)->first()
        ) {

            $nama1 = $this->abbreviateName($request->user()->firstname . ' ' . $request->user()->lastname, 20);
            $nama2 = Str::upper($materi->materi);
            if (!Certificate::where('id_materi', $materi->id)->where('id_user', $request->user()->id)->first()) {
                $tanggal =  Modul::where('id_materi', $materi->id)
                    ->whereHas('user', function ($query) use ($request) {
                        $query->where('id_user', $request->user()->id);
                    })
                    ->latest()->first();
                $tanggal = Carbon::parse($tanggal->created_at)->locale('id')->translatedFormat('d F Y');

                $sertifikatnama =  $request->user()->uuid . '-' . fake()->uuid();
                $outputFile = storage_path('app/public/cert/' . $sertifikatnama . '.pdf');
                $fpdi = new Fpdi();
                $fpdi->setSourceFile(storage_path('app/public/cert/cert-template-forbidden.pdf'));
                $template = $fpdi->importPage(1);
                $size = $fpdi->getTemplateSize($template);
                $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
                $fpdi->useTemplate($template);

                // Menggunakan font Poppins-Bold sesuai dengan nama yang ada di file PHP
                $fpdi->AddFont('Poppins-SemiBold', '', 'Poppins-SemiBold.php', public_path('fonts'));
                $fpdi->SetFont('Poppins-SemiBold', '', 50);
                $fpdi->SetTextColor(25, 26, 25);
                $fpdi->Text(34, 100, $nama1);

                $fpdi->SetFont('Poppins-SemiBold', '', 35);
                $fpdi->Text(34, 130, $nama2);

                $fpdi->SetFont('Poppins-SemiBold', '', 15);
                $fpdi->Text(34, 167, $tanggal);

                // Simpan file output
                $fpdi->Output($outputFile, 'F');
                DB::transaction(function () use ($request, $sertifikatnama, &$certificate, $materi, $outputFile) {
                    $validatedData = [
                        'uuid' => fake()->uuid(),
                        'id_materi' => $materi->id,
                        'id_user' => $request->user()->id,
                        'sertifikat' => 'cert/' . $sertifikatnama . '.pdf'
                    ];
                    $certificate =  Certificate::create($validatedData);
                });
                $data = [
                    'nama' => $nama1,
                    'materi' => $materi->materi,
                    'terbit' => Carbon::parse($certificate->created_at)->locale('id')->translatedFormat('d F Y'),
                    'sertifikat' => url('/storage/cert/' . $sertifikatnama . '.pdf')
                ];
                return new GetResource(200, 'Sukses mencetak sertifikat', $data);
            } else {
                $certificate = Certificate::where('id_materi', $materi->id)->where('id_user', $request->user()->id)->first();
                $data = [
                    'nama' => $nama1,
                    'materi' => $materi->materi,
                    'terbit' => Carbon::parse($certificate->created_at)->locale('id')->translatedFormat('d F Y'),
                    'sertifikat' => $certificate->sertifikat
                ];
                return new GetResource(200, 'Sukses mencetak sertifikat', $data);
            }
            return new PostAuthResource(422, 'Terjadi kesalahan', $materiuser);
        }
    }

    public function abbreviateName($name, $length = 20)
    {
        // Jika nama lebih dari panjang yang diizinkan
        if (strlen($name) > $length) {
            $words = explode(' ', $name);
            $abbreviation = array_shift($words);
            foreach ($words as $word) {
                $abbreviation .= ' ' . substr($word, 0, 1);
            }

            // Memendekkan hasil singkatan dan menambahkan suffix "A" jika panjang lebih dari 18 karakter
            $result = Str::limit($abbreviation, $length, '');
            if (strlen($result) > 18) {
                $result = substr($result, 0, $length - 2) . 'A';
            }
        } else {
            // Jika nama tidak melebihi panjang yang diizinkan, gunakan nama lengkap
            $result = $name;
        }

        return Str::upper($result);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Materi $materi, Request $request)
    {
        // Load materi dengan modul dan user terkait dalam satu kali query
        $materi->load(['modul' => function ($query) use ($request) {
            $query->select('id_materi', 'id', 'uuid', 'cover', 'modul')->orderBy('created_at', 'asc')
                ->with(['user' => function ($query) use ($request) {
                    $query->select('id_modul', 'status')->where('id_user', $request->user()->id);
                }]);
        }]);

        // Ambil jumlah modul dan jumlah siswa
        $jumlahModul = $materi->modul->count();
        $jumlahSiswa = MateriUser::where('id_materi', $materi->id)->count();

        // Transformasi data materi
        $dataMateri = [
            'uuid' => $materi->uuid,
            'cover' => $materi->cover,
            'materi' => $materi->materi,
            'deskripsi' => $materi->deskripsi,
            'lanjutan' => $materi->lanjutan,
            'jumlah_siswa' => $jumlahSiswa,
            'jumlah_modul' => $jumlahModul,
            'waktu' => $materi->waktu,
            'modul' => $materi->modul->map(function ($modul) {
                $hasActiveUser = $modul->user->contains(function ($user) {
                    return $user->status == 1;
                });

                return [
                    'uuid' => $modul->uuid,
                    'cover' => $modul->cover,
                    'modul' => $modul->modul,
                    'unlock' => $hasActiveUser
                ];
            })
        ];

        return new GetResource(200, 'Sukses mengambil data', $dataMateri);
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Materi $materi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Materi $materi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Materi $materi)
    {
        //
    }
}
