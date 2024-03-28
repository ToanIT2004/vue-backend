<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\color;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(color::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $ValidatorData = Validator::make($request->all(), [
            'mausac' => 'required|unique:colors'
        ], [
            'mausac.required' => 'Tên màu không được để trống',
            'mausac.unique' => 'Màu sắc này đã tồn tại'
        ]); 

        if($ValidatorData->fails()) {
            return response()->json($ValidatorData->errors(), 400);
        }

        $products = color::create([
            'mausac' => $request->input('mausac')
        ]);

        return response()->json($products, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
        $color = color::find($id);

        if($color) {
            $color->delete();
            return response()->json('Xóa màu thành công', 201);
        }
    }
}
