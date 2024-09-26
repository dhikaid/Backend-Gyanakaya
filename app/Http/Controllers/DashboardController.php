<?php

namespace App\Http\Controllers;


use App\Models\Role;
use App\Models\User;
use App\Models\Modul;
use App\Models\Materi;
use App\Models\ModulUser;
use App\Models\MateriUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\GetResource;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    // USER GET ALL
    public function getUserAll(Request $request)
    {
        Gate::authorize('isAdmin', $request->user());
        return new GetResource(200, 'Sukses mendapatkan data', User::with('role')->get());
    }

    // USER GET DETAIL
    public function getUserDetail(string $id, Request $request)
    {
        Gate::authorize('isAdmin', $request->user());
        $user = User::where('uuid', $id)->with('role')->first();
        if ($user) {
            return new GetResource(200, 'Sukses mendapatkan data', $user);
        }
        return new GetResource(404, 'User dengan UUID ini tidak ditemukan');
    }

    // USER EDIT BY UUID
    public function editUser(string $id, Request $request)
    {
        Gate::authorize('isAdmin', $request->user());


        $user = User::where('uuid', $id)->first();
        if ($user) {
            // AMBIL REQUEST DATA BARU LALU UPDATE
            $rules = [
                'username' => 'required|string|max:30',
                'firstname' => 'required|string|max:150',
                'lastname' => 'required|string|max:150',
                'email' => 'required|email:rfc,dns|string',
                'role_id' => 'required|integer|exists:roles,id',
            ];

            if ($request->file('image')) {
                $rules['image'] = 'required|image|max:5000';
            }

            $validatedData = $request->validate($rules);

            // JIKA ADA IMAGE BARU, VALIDASI MAX 10MB LALU  UPDATE
            if ($request->file('image')) {
                $validatedData['image'] = $request->file('image')->store('avatar');
            }

            // JIKA AMAN SEMUA MAKA LAKUKAN SQL TRANSACTION
            DB::transaction(function () use ($user, $validatedData) {
                $user->update($validatedData);
            });

            return new GetResource(200, 'Sukses mengubah data', $user);
        }
        return new GetResource(404, 'User dengan UUID ini tidak ditemukan');
    }


    // GET TAMPILKAN SEMUA ROLE YANG ADA
    public function getRoleAll(Request $request)
    {
        Gate::authorize('isAdmin', $request->user());
        return new GetResource(200, 'Sukses mendapatkan data', Role::all());
    }

    // GET TAMPILKAN SEMUA MATERI YANG ADA
    public function getMateriAll(Request $request)
    {
        Gate::authorize('isAdmin', $request->user());
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

    // POST VIEW MATERI DETAIL BY UUID
    public function getMateriDetail(Materi $materi, Request $request)
    {
        Gate::authorize('isAdmin', $request->user());
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
}
