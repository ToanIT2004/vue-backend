<?php

namespace App\Http\Controllers;

use App\Models\donhang;
use App\Models\cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DonHangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(donhang::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ten' => 'required',
            'sdt' => 'required|digits_between:10,11',
            'diachi' => 'required'
        ],[
            'ten.required' => 'Tên không được để trống',
            'sdt.required' => 'Số điện thoại không được để trống',
            'sdt.digits_between' => 'Số điện thoại phải 10 hoặc 11 số',
            'diachi.required' => 'Địa chỉ không được để trống',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Lỗi Validator', $validator->errors()], 400);
        }

        $dh = donhang::create($request->all());
        return response()->json($dh, 201);
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
        $dh = donhang::find($id);
        $cart = \DB::table('carts')->where('iddh', $id)->get(); // Thêm phương thức get() để lấy kết quả truy vấn
        if($dh) {
            $dh->delete();
            // Xóa các bản ghi trong bảng carts
            if($cart) {
                \DB::table('carts')->where('iddh', $id)->delete();
            }
            return response()->json('Đã xóa thành công', 200);
        }
    }
}
