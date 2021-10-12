<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class CustomersController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'unit' => 'required',
            'stock' => 'required|integer',
            'unit_price' => 'required|integer',
            'image' => 'required',
    ];
    $validator = validation_request($request,$rules);
    if(!$validator->success) return response()->json($validator,422);

    $item = Item::create([
        'name'     => $request->input('name'),
        'unit'   => $request->input('unit'),
        'stock'   => $request->input('stock'),
        'unit_price'   => $request->input('unit_price'),
        'images'   => $request->input('image'),
    ]);

    if ($item) {
        return response()->json([
            'success' => true,
            'message' => 'item Berhasil Disimpan!',
            'data' => $item
        ], 201);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'item Gagal Disimpan!',
        ], 400);
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
