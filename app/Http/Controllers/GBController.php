<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\dungluong;
use Illuminate\Support\Facades\Validator;


class GBController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(dungluong::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $ValidatorData = Validator::make($request->all(), [
            'GB' => 'required|numeric|unique:dungluongs'
        ], [
            'GB.required' => 'Dung lượng không được để trống',
            'GB.unique' => 'Đã tồn tại',
            'GB.numeric' => 'Dung lượng phải nhập số'

        ]); 

        if($ValidatorData->fails()) {
            return response()->json($ValidatorData->errors(), 400);
        }

        $products = dungluong::create([
            'GB' => $request->input('GB')
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
        $GB = dungluong::find($id);
        if($GB) {
            $GB->delete();
            return response()->json('Đã xóa thành công', 201);
        }
    }
}
