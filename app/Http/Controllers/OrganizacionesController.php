<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\organizaciones;

class OrganizacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexAdmin()
    {
        $organizaciones = organizaciones::get();
        return view('admin.organizaciones.index', ['organizaciones' => $organizaciones]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string', 'unique:organizaciones'],
            'pais' => ['required', 'string'],
            'estado' => ['required', 'string'],
            'municipio' => ['required', 'string'],
            'colonia' => ['required', 'string'],
            'calle' => ['required', 'string'],
            'numExt' => ['required', 'string'],
            'numInt' => ['nullable', 'string'],
        ]);

        $direccionData = [
            'pais' => $data['pais'],
            'estado' => $data['estado'],
            'municipio' => $data['municipio'],
            'colonia' => $data['colonia'],
            'calle' => $data['calle'],
            'num_ext' => $data['numExt'],
            'num_int' => $data['numInt'],
        ];

        $organizacion = new organizaciones();
        $organizacion->nombre = $data['nombre'];
        $organizacion->direccion = $direccionData;
        $organizacion->save();

        session()->flash('status', 'Organización añadida');
        session()->flash('icon', 'success');

        return to_route('admin.organizaciones');
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
    public function edit(int $id)
    {
        $organizacion = organizaciones::find($id);
        return view('admin.organizaciones.edit', ['organizacion' => $organizacion]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, organizaciones $organizacion)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
            'pais' => ['required', 'string'],
            'estado' => ['required', 'string'],
            'municipio' => ['required', 'string'],
            'colonia' => ['required', 'string'],
            'calle' => ['required', 'string'],
            'numExt' => ['required', 'string'],
            'numInt' => ['nullable', 'string'],
        ]);

        $direccionData = [
            'pais' => $data['pais'],
            'estado' => $data['estado'],
            'municipio' => $data['municipio'],
            'colonia' => $data['colonia'],
            'calle' => $data['calle'],
            'num_ext' => $data['numExt'],
            'num_int' => $data['numInt'],
        ];

        $organizacion->update([
            'nombre' => $data['nombre'],
            'direccion' => $direccionData
        ]);

        session()->flash('status', 'Organización actualizada');
        session()->flash('icon', 'success');

        return to_route('admin.organizaciones');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(organizaciones $organizacion)
    {
        $organizacion->delete($organizacion);

        session()->flash('status', 'Organización eliminada');
        session()->flash('icon', 'info');
        return to_route('admin.organizaciones');
    }
}
