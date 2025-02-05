<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('grupo.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('grupo.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('grupo.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('grupo.edit');
    }
}
