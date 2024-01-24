<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRaportRequest;
use App\Http\Requests\UpdateRaportRequest;
use App\Models\Raport;

class RaportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRaportRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRaportRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Raport  $raport
     * @return \Illuminate\Http\Response
     */
    public function show(Raport $raport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Raport  $raport
     * @return \Illuminate\Http\Response
     */
    public function edit(Raport $raport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRaportRequest  $request
     * @param  \App\Models\Raport  $raport
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRaportRequest $request, Raport $raport)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Raport  $raport
     * @return \Illuminate\Http\Response
     */
    public function destroy(Raport $raport)
    {
        //
    }
}
