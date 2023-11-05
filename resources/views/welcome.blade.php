@extends('layouts.app')
@section('title', "UTN Osil")

@section('recursos')
@vite([
  "resources/css/form.css",
  "resources/js/form.js"
])
@endsection

@section('body')
<section class="container-fluid">

  <div class="d-flex justify-content-center align-items-center">
    <div class="mb-3 mt-2">
      <span class="p-3">
        Login
      </span>
      <label class="switch">
        <input type="checkbox" class="input" id="switchFlip">
        <span class="slider"></span>
      </label>
      <span class="p-3">
        Sign Up
      </span>
    </div>
  </div>

  <div class="d-flex justify-content-center align-items-center flip-card">
    <div class="flip-card-inner col-lg-6">
      <form id="formLogin" action="" class="bgColor formHome">
        <div class="mb-3 w-100 secBgColor p-2 tituloForm d-flex justify-content-center align-items-center">
          <h2>
            Login
          </h2>
        </div>
        <div class="p-3">
          <div class="mb-3">
            <label for="correo" class="form-label">Correo electronico</label>
            <input type="email" class="form-control" id="correo" name="correo" placeholder="nombre@example.com">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" aria-describedby="passwordHelpBlock">
          </div>
          <button type="submit" class="btn secBgColor">
            Enviar
          </button>
        </div>
      </form>
  
      <form id="formRegister" action="" class="bgColor formHome">
        <div class="mb-3 w-100 secBgColor p-2 tituloForm d-flex justify-content-center align-items-center">
          <h2>
            Sign Up
          </h2>
        </div>
        <div class="p-3">
          <div class="mb-3">
            <label for="matricula" class="form-label">Matrícula</label>
            <input type="text" class="form-control" id="matricula" name="matricula">
          </div>
          <div class="mb-3">
            <label for="correo" class="form-label">Correo electronico</label>
            <input type="email" class="form-control" id="correo" name="correo" placeholder="nombre@example.com">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" class="form-control" aria-describedby="passwordHelpBlock">
          </div>
          <button type="submit" class="btn secBgColor">
            Enviar
          </button>
        </div>
      </form>
    </div>
  </div>

</section>
@endsection