<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sanpham;
use Illuminate\Support\Facades\Validator;
// use Intervention\Image\ImageManagerStatic as Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(sanpham::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $ValidateData = Validator::make($request->all(),[
    //         // 'idmenu' => "required|numeric",
    //         // 'idcolor' => "required|numeric",
    //         // 'idGB' => "required|numeric",
    //         'tensp' => "required",
    //         'mota' => "required",
    //         'img' => "required",
    //         'img1' => "required",
    //         'img2' => "required",
    //         'img3' => "required",
    //         'dongia' => "required|numeric",
    //         'giamgia' => "required|numeric",
    //         'slton' => "required|numeric",
    //     ], [
    //         // 'idmenu.required' => "không được để trống",
    //         // 'idcolor.required' => "không được để trống",
    //         // 'idGB.required' => "không được để trống",
    //         'tensp.required' => "Tên sản phẩm không được để trống",
    //         'mota.required' => "Mô tả không được để trống",
    //         'img.required' => "Hình ảnh không được để trống",
    //         'img1.required' => "Hình ảnh không được để trống",
    //         'img2.required' => "Hình ảnh không được để trống",
    //         'img3.required' => "Hình ảnh không được để trống",
    //         'dongia.required' => "Đơn giá không được để trống",
    //         'giamgia.required' => "Giảm giá không được để trống",
    //         'slton.required' => "Số lượng tồn không được để trống",
    //         'dongia.numeric' => "Đơn giá phải là số",
    //         'giamgia.numeric' => "Giảm giá phải là số",
    //         'slton.numeric' => "Số lượng tồn phải là số",
    //     ]);

    //     if($ValidateData->fails()) {
    //         return response()->json(['message' => 'Validation failed', 'errors' => $ValidateData->errors()],422);
    //     }

    //     // Eloquent
    //     $products = sanpham::create($request->all());
    //     return response()->json($products, 200);
    // }

    public function store(Request $request)
    {
        $ValidateData = Validator::make($request->all(),[
            'tensp' => "required",
            'mota' => "required",
            'img' => "required",
            'img1' => "required",
            'img2' => "required",
            'img3' => "required",
            'dongia' => "required|numeric",
            'giamgia' => "required|numeric",
            'slton' => "required|numeric",
        ], [
            'tensp.required' => "Tên sản phẩm không được để trống",
            'mota.required' => "Mô tả không được để trống",
            'img.required' => "Hình ảnh không được để trống",
            'img1.required' => "Hình ảnh không được để trống",
            'img2.required' => "Hình ảnh không được để trống",
            'img3.required' => "Hình ảnh không được để trống",
            'dongia.required' => "Đơn giá không được để trống",
            'giamgia.required' => "Giảm giá không được để trống",
            'slton.required' => "Số lượng tồn không được để trống",
            'dongia.numeric' => "Đơn giá phải là số",
            'giamgia.numeric' => "Giảm giá phải là số",
            'slton.numeric' => "Số lượng tồn phải là số",
        ]);

        if($ValidateData->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $ValidateData->errors()],422);
        }

        if($request->hasFile('img')) {
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$request->file('img')->getClientOriginalExtension();
            $img = $manager->read($request->file('img'));
            $img = $img->resize(370, 246);
            $img->toJpeg(80)->save(base_path('public/upload/product/'. $name_gen));
            $save_url = 'upload/product'.$name_gen;

            $product = sanpham::create([
                'idmenu' => $request->input('idmenu'),
                'idcolor' => $request->input('idcolor'),
                'idGB' => $request->input('idGB'),
                'tensp' => $request->input('tensp'),
                'mota' => $request->input('mota'),
                'img' => $save_url,
                'img1' => $request->input('img1'),
                'img2' => $request->input('img2'),
                'img3' => $request->input('img3'),
                'dongia' => $request->input('dongia'),
                'giamgia' => $request->input('giamgia'),
                'slton' => $request->input('slton'),
            ]); 
            return response()->json($product, 200);
        }else {
            return response()->json('Chua vao file', 404);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pro = sanpham::find($id);
        return response()->json($pro, 200);
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
        $pro = sanpham::find($id);
        if($pro) {
            return response()->json('Đã xóa thành công', 201);
        }
    }
}
