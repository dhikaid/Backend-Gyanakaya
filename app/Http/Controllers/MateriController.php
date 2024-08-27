<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use App\Models\Materi;
use App\Models\MateriUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\GetResource;
use App\Http\Resources\PostAuthResource;
use App\Models\ModulUser;
use Illuminate\Validation\ValidationException;

class MateriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materi = Materi::all();
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
            });
            return new PostAuthResource(200, 'Sukses mendaftar kelas!', $materiuser->status);
        }
        return new PostAuthResource(422, 'Terjadi kesalahan', $materiuser);
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
        // Load materi dengan modul dan user terkait
        $materi->load(['modul' => function ($query) use ($request) {
            $query->select('id_materi', 'id', 'uuid', 'cover', 'modul');
        }, 'modul.user' => function ($query) use ($request) {
            $query->select('id_modul', 'status')->where('id_user', $request->user()->id);
        }]);

        // Transformasi modul dengan mengubah user menjadi boolean
        $materi->modul->transform(function ($modul) {
            // Cek jika ada user dengan status 1, jika ada set user menjadi true, jika tidak set menjadi false
            $hasActiveUser = $modul->user->contains(function ($user) {
                return $user->status == 1;
            });

            // Menyusun kembali array modul dengan user sebagai boolean
            return [
                'uuid' => $modul->uuid,
                'cover' => $modul->cover,
                'modul' => $modul->modul,
                'unlock' => $hasActiveUser
            ];
        });

        return new GetResource(200, 'Sukses mengambil data', $materi);
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
