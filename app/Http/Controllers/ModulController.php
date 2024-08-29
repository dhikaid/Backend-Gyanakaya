<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreModulRequest;
use App\Http\Requests\UpdateModulRequest;
use App\Http\Resources\PostAuthResource;
use App\Models\MateriUser;
use App\Models\ModulUser;

class ModulController extends Controller
{

    public function checkModul(Modul $modul, Request $request)
    {
        if (!ModulUser::where('id_modul', $modul->id)->where('id_user', $request->user()->id)->first() && MateriUser::where('id_user', $request->user()->id)->where('id_materi', $modul->id_materi)) {
            DB::transaction(function () use (&$moduluser, $request, $modul) {
                $validatedData = [
                    'id_user' => $request->user()->id,
                    'id_modul' => $modul->id,
                    'status' => true,
                ];
                $moduluser =  ModulUser::create($validatedData);
            });
            return new PostAuthResource(200, 'Sukses! Sudah membaca modul', $moduluser->status);
        } elseif (ModulUser::where('id_modul', $modul->id)->where('id_user', $request->user()->id)->first() && MateriUser::where('id_user', $request->user()->id)->where('id_materi', $modul->id_materi)) {
            return new PostAuthResource(200, 'Sukses! Pernah membaca modul');
        }

        return new PostAuthResource(422, 'Terjadi kesalahan');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StoreModulRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Modul $modul)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Modul $modul)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateModulRequest $request, Modul $modul)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Modul $modul)
    {
        //
    }
}
