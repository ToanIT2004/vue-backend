<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\cart;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cart = cart::create($request->all());
        return response()->json($cart, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $cart = \DB::table('carts')
        ->where('iddh', $id)
        ->get();
        return response()->json($cart, 200);

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
