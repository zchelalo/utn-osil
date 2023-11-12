<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\usuarios;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

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
        $data = $request->validate([
            'loginCorreo' => ['required', 'string', 'email'],
            'loginPassword' => ['required', 'string'],
        ]);

        if(!Auth::attempt(['correo' => $data['loginCorreo'], 'password' => $data['loginPassword']], false))
        {
            // session()->flash('status', 'Las credenciales ingresadas no coinciden con nuestros registros');
            // session()->flash('icon', 'error');
            session()->flash('login', 'open');
            throw ValidationException::withMessages([
                'loginCorreo' => __('auth.failed')
            ]);
        }
        
        $usuario = usuarios::with('tipo_usuario')->where('correo', $data['loginCorreo'])->first();

        // $token = $usuario->createToken('UTN-Osil')->plainTextToken;

        session(['id' => $usuario->id, 'nombre' => $usuario->nombre, 'correo' => $usuario->correo, 'tipo_usuario' => $usuario->tipo_usuario->nombre]);

        $request->session()->regenerate();

        // 'token' => $token
        return redirect()->intended('/')->with(['status' => 'Ha iniciado sesión correctamente', 'icon' => 'success']);
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

        return redirect()->intended('/')->with(['status' => 'Verifique su usuario mediante el correo electrónico. Si no encuentra el correo revise la sección de spam o correo no deseado', 'icon' => 'info']);
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
    public function destroy(Request $request)
    {
        Auth::logout(); // Cierra la sesión

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('inicio')->with(['status' => 'La sesión ha finalizado', 'icon' => 'info']);
    }
}
