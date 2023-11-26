<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\usuarios;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'fb' => ['nullable', 'string', 'regex:/^(https?:\/\/)?(www\.)?facebook\.com\/.+/i'],
            'tw' => ['nullable', 'string', 'regex:/^(https?:\/\/)?(www\.)?twitter\.com\/.+/i'],
            'ig' => ['nullable', 'string', 'regex:/^(https?:\/\/)?(www\.)?instagram\.com\/.+/i'],
            'tk' => ['nullable', 'string', 'regex:/^(https?:\/\/)?(www\.)?tiktok\.com\/.+/i'],
            'img' => ['nullable', 'string', 'regex:/^data:image\/(png|jpeg|jpg|gif);base64,/i'],
        ]);

        // 'id_tipo_usuario' => ['required', 'integer']

        $usuario = new usuarios();

        if (isset($data['img']))
        {
            $urlPublica = null;
            $base64Data = explode(',', $data['img'])[1];
            $decodedData = base64_decode($base64Data);

            $dataImg = getimagesizefromstring($decodedData);

            // Generar un nombre único basado en la fecha actual
            $fechaActual = now();
            $extension = image_type_to_extension($dataImg[2], false); // Obtener la extensión según el tipo de imagen
            $nombreArchivo = $fechaActual->format('YmdHis') . uniqid() . '.' . $extension;
            
            $rutaArchivo = 'public/img/pfp/' . $nombreArchivo;
            // Usando Storage para guardar la imagen en el disco predeterminado
            Storage::put($rutaArchivo, $decodedData);  

            // Obtener la URL pública del archivo
            $urlPublica = Storage::url($rutaArchivo);

            $usuario->foto_perfil = $urlPublica;
        }

        if (isset($data['fb']) || isset($data['tw']) || isset($data['ig']) || isset($data['tk']))
        {
            $redes_sociales = null;
            if (isset($data['fb']))
            {
                $redes_sociales['fb'] = $data['fb'];
            }

            if (isset($data['tw']))
            {
                $redes_sociales['tw'] = $data['tw'];
            }

            if (isset($data['ig']))
            {
                $redes_sociales['ig'] = $data['ig'];
            }

            if (isset($data['tk']))
            {
                $redes_sociales['tk'] = $data['tk'];
            }

            $usuario->redes_sociales = $redes_sociales;
        }

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
