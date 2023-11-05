<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\congresos;
use App\Models\organizaciones;

class CongresosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $congresos = congresos::get();
        // $congresos = congresos::with('organizaciones')->get();
        return view('congresos.index', ['congresos' => $congresos]);
    }

    public function indexAdmin()
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $congreso = congresos::find($id)->load('organizaciones');
        return view('congresos.show', ['congreso' => $congreso]);
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
