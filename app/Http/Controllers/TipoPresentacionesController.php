<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tipo_presentacion;

class TipoPresentacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function indexAdmin()
    {
        $tipos = tipo_presentacion::get();
        return view('admin.tipos_presentacion.index', ['tipos' => $tipos]);
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
        $data = $request->validate([
            'nombre' => ['required', 'string', 'unique:tipo_presentaciones']
        ]);

        $tipo = new tipo_presentacion();
        $tipo->nombre = $data['nombre'];
        $tipo->save();

        session()->flash('status', 'Tipo de presentación añadida');
        session()->flash('icon', 'success');

        return to_route('admin.tipos');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(tipo_presentacion $tipo)
    {
        return view('admin.tipos_presentacion.edit', ['tipo' => $tipo]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, tipo_presentacion $tipo)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'unique:tipo_presentaciones']
        ]);

        $tipo->update([
            "nombre" => $data['nombre']
        ]);

        session()->flash('status', 'Tipo de presentación actualizada');
        session()->flash('icon', 'success');

        return to_route('admin.tipos');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(tipo_presentacion $tipo)
    {
        $tipo->delete($tipo);

        session()->flash('status', 'Tipo de presentación eliminada');
        session()->flash('icon', 'info');
        return to_route('admin.tipos');
    }
}
