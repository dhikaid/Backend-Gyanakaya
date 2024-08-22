<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
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
        return new GetResource(200, 'Sukses mengambil data', $kategori->load('materi'));
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
