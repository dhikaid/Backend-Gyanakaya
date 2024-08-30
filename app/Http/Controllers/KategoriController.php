<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\MateriUser;
use App\Http\Resources\GetResource;
use App\Http\Requests\StoreKategoriRequest;
use App\Http\Requests\UpdateKategoriRequest;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category =  Kategori::all();
        return new GetResource(200, 'Sukses mengambil data', $category);
    }

    public function front()
    {
        $category = Kategori::all()->take(3);
        return new GetResource(200, 'Sukses mengambil data', $category);
    }

    public function detail(Kategori $kategori)
    {
        // Load materi beserta modulnya menggunakan eager loading
        $kategori->load(['materi.modul']);

        // Loop melalui materi untuk menghitung jumlah modul dan siswa
        $dataMateri = $kategori->materi->map(function ($materi) {
            $jumlahModul = $materi->modul->count();
            $jumlahSiswa = MateriUser::where('id_materi', $materi->id)->count();

            return [
                'uuid' => $materi->uuid,
                'cover' => $materi->cover,
                'materi' => $materi->materi,
                'deskripsi' => $materi->deskripsi,
                'lanjutan' => $materi->lanjutan,
                'jumlah_siswa' => $jumlahSiswa,
                'jumlah_modul' => $jumlahModul,
                'waktu' => $materi->waktu,
            ];
        });

        return new GetResource(200, 'Sukses mengambil data', $dataMateri);
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
    public function store(StoreKategoriRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKategoriRequest $request, Kategori $kategori)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        //
    }
}
