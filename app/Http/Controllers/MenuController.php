<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use app\Models\menu;
use App\Models\menu;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(menu::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $ValidatorData = Validator::make($request->all(), [
            'tenloai' => 'required|unique:menus'
        ], [
            'tenloai.required' => 'Dung lượng không được để trống',
            'tenloai.unique' => 'Đã tồn tại'
        ]); 

        if($ValidatorData->fails()) {
            return response()->json($ValidatorData->errors(), 400);
        }

        $products = menu::create([
            'tenloai' => $request->input('tenloai')
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
        $menu = menu::find($id);
        if($menu) {
            $menu->delete();
            return response()->json('Đã xóa thành công', 201);
        }
    }
}
