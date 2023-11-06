<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\talleres;
use DateTime;
use Carbon\Carbon;

class TalleresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $talleres = talleres::with('congresos')->get();
        return view('talleres.index', ['talleres' => $talleres]);
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
