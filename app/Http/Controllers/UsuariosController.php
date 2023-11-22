<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\usuarios;
use App\Models\tipo_usuario;
use App\Models\presentaciones;
use App\Models\fechas;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexAdmin()
    {
        $tipos_usuario = tipo_usuario::get();
        $usuarios = usuarios::with('tipo_usuario')->get();

        return view('admin.usuarios.index', ['usuarios' => $usuarios, 'tipos_usuario' => $tipos_usuario]);
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
            'nombre' => ['required', 'string'],
            'matricula' => ['nullable', 'integer', 'unique:usuarios'],
            'correo' => ['required', 'string', 'email', 'unique:usuarios'],
            'password' => ['required', 'string', Password::defaults()],
            'tipo_usuario' => ['required', 'integer']
        ]);

        $usuario = new usuarios();
        $usuario->nombre = $data['nombre'];
        $usuario->matricula = isset($data['matricula']) ? $data['matricula'] : null;
        $usuario->correo = $data['correo'];
        $usuario->password = Hash::make($data['password']);
        $usuario->id_tipo_usuario = $data['tipo_usuario'];
        $usuario->save();

        session()->flash('status', 'Usuario añadido');
        session()->flash('icon', 'success');

        return to_route('admin.usuarios');
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
    public function edit(usuarios $usuario)
    {
        $tipos_usuario = tipo_usuario::get();

        if (auth()->user()->id == $usuario->id)
        {
            // return view('admin.configuracion', ['usuario' => $usuario, 'tipos_usuario' => $tipos_usuario]);
            return to_route('configuracion', ['usuario' => $usuario, 'tipos_usuario' => $tipos_usuario]);
        }

        return view('admin.usuarios.edit', ['usuario' => $usuario, 'tipos_usuario' => $tipos_usuario]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, usuarios $usuario)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
            'matricula' => ['nullable', 'integer', 'unique:usuarios,matricula,' . $usuario->id],
            'correo' => ['required', 'string', 'email', 'unique:usuarios,correo,' . $usuario->id],
            'tipo_usuario' => ['required', 'integer']
        ]);

        $usuario->update([
            'nombre' => $data['nombre'],
            'matricula' => isset($data['matricula']) ? $data['matricula'] : null,
            'correo' => $data['correo'],
            'id_tipo_usuario' => $data['tipo_usuario'],
        ]);

        session()->flash('status', 'Usuario actualizado');
        session()->flash('icon', 'success');

        return to_route('admin.usuarios');
    }

    public function viewConf()
    {
        $tipos_usuario = tipo_usuario::get();
        $usuario = auth()->user();
        $presentaciones = presentaciones::where('id_usuario', $usuario->id)->get();
        
        return view('admin.configuracion', ['usuario' => $usuario, 'tipos_usuario' => $tipos_usuario, 'presentaciones' => $presentaciones]);
    }

    public function updateConf(Request $request, usuarios $usuario)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
            'matricula' => ['nullable', 'integer', 'unique:usuarios,matricula,' . $usuario->id],
            'correo' => ['required', 'string', 'email', 'unique:usuarios,correo,' . $usuario->id],
            'password' => ['nullable', 'string', Password::defaults()],
            // 'tipo_usuario' => ['required', 'integer']
        ]);

        $usuario->update([
            'nombre' => $data['nombre'],
            'matricula' => isset($data['matricula']) ? $data['matricula'] : null,
            'correo' => $data['correo'],
            'password' => isset($data['password']) ? Hash::make($data['password']) : $usuario->password,
            // 'id_tipo_usuario' => $data['tipo_usuario'],
        ]);

        session()->flash('status', 'Usuario actualizado');
        session()->flash('icon', 'success');

        return to_route('configuracion');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(usuarios $usuario)
    {
        if (auth()->user()->id == $usuario->id)
        {
            // return view('admin.configuracion', ['usuario' => $usuario, 'tipos_usuario' => $tipos_usuario]);
            return to_route('admin.usuarios');
        }

        $presentaciones = presentaciones::where('id_usuario', $usuario->id)->get();
        foreach ($presentaciones as $presentacion) {
            $fechas = fechas::where('id_presentacion', $presentacion->id)->get();
            foreach ($fechas as $fecha) {
                $fecha->delete($fecha);
            }

            $presentacion->delete($presentacion);
        }

        $usuario->delete($usuario);

        session()->flash('status', 'Usuario eliminado');
        session()->flash('icon', 'info');
        return to_route('admin.usuarios');
    }
}
