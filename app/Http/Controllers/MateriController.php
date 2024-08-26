<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use Illuminate\Http\Request;
use App\Http\Resources\GetResource;
use App\Http\Resources\PostAuthResource;
use App\Models\Modul;
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


    public function detail(Materi $materi, string $modul)
    {
        $modul = Modul::where('uuid', $modul)->first();
        if ($modul->id_materi === $materi->id) {
            return new GetResource(200, 'Sukses mengambil data', $modul);
        } else {
            return new GetResource(422, 'Terjadi kesalahan');
        }
    }

    public function lastest()
    {
        return new GetResource(200, 'Sukses mengambil data', Materi::latest()->get());
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
    public function show(Materi $materi)
    {
        return new GetResource(200, 'Sukses mengambil data', $materi->load('modul'));
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
