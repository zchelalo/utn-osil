<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\usuarios;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeUsuario(Request $request)
    {
        $data = $request->validate([
            'nombre' => ['required', 'string'],
            'matricula' => ['nullable', 'integer'],
            'correo' => ['required', 'string', 'email', 'unique:usuarios'],
            'password' => ['required', 'string', Password::defaults()],
        ]);

        // 'id_tipo_usuario' => ['required', 'integer']

        $usuario = new usuarios();
        $usuario->nombre = $data['nombre'];
        $usuario->matricula = $data['matricula'];
        $usuario->correo = $data['correo'];
        $usuario->password = Hash::make($data['password']);
        $usuario->id_tipo_usuario = 1;
        $usuario->save();

        session()->flash('status', 'Verifique su usuario mediante el correo electrónico. Si no encuentra el correo revise la sección de "spam" o correo no deseado');

        return redirect()->intended('/');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
