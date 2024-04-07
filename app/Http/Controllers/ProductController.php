<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sanpham;
use Illuminate\Support\Facades\Validator;
// use Intervention\Image\ImageManagerStatic as Image;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\Menu; // Import model Menu

class ProductController extends Controller
{
    public function index()
    {
        // Xem chỗ này
        //Dạng 1
        // $products = \DB::table('sanphams')
        // ->join('menus', 'sanphams.idmenu', '=', 'menus.id')
        // ->select('sanphams.id', 'menus.tenloai as idmenu', 'sanphams.idcolor', 'sanphams.idGB', 'sanphams.tensp', 'sanphams.mota', 'sanphams.img', 'sanphams.img1', 'sanphams.img2', 'sanphams.img3', 'sanphams.dongia', 'sanphams.giamgia', 'sanphams.slton', 'sanphams.created_at', 'sanphams.updated_at')
        // ->get();

        // Dạng 2
        $products = sanpham::select(
            'sanphams.id',
            'menus.tenloai as idmenu',
            'colors.mausac as idcolor',
            'dungluongs.GB as idGB',
            'sanphams.tensp',
            'sanphams.mota',
            'sanphams.img',
            'sanphams.img1',
            'sanphams.img2',
            'sanphams.img3',
            'sanphams.dongia',
            'sanphams.giamgia',
            'sanphams.slton',
            'sanphams.created_at',
            'sanphams.updated_at'
            ) 
            ->join('menus', 'sanphams.idmenu', '=', 'menus.id')
            ->join('colors', 'sanphams.idcolor', '=', 'colors.id')
            ->join('dungluongs', 'sanphams.idGB', '=', 'dungluongs.id')
            ->get();


        foreach($products as $product) {    
            $product->img = asset($product->img);
            $product->img1 = asset($product->img1);
            $product->img2 = asset($product->img2);
            $product->img3 = asset($product->img3);

        }
        return response()->json($products, 200);
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
            'idmenu' => "required",
            'idcolor' => "required",
            'idGB' => "required",
            'tensp' => "required",
            'mota' => "required",
            'img' => "required|image",
            'img1' => "required|image",
            'img2' => "required|image",
            'img3' => "required|image",
            'dongia' => "required|numeric",
            'giamgia' => "required|numeric",
            'slton' => "required|numeric",
        ], [
            'idmenu.required' => "Tên loại không được để trống",
            'idcolor.required' => "Màu sắckhông được để trống",
            'idGB.required' => "Dung lượng không được để trống",
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
            'img.image' => 'Hình ảnh phải là một tệp hình ảnh',
            'img1.image' => 'Hình ảnh phải là một tệp hình ảnh',
            'img2.image' => 'Hình ảnh phải là một tệp hình ảnh',
            'img3.image' => 'Hình ảnh phải là một tệp hình ảnh',
        ]);

        if($ValidateData->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $ValidateData->errors()],422);
        }

        // Tạo thư mục lưu trữ nếu chưa tồn tại
        // Nó sẽ tự động tạo trong public
        $uploadPath = public_path('upload/product');
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        if($request->hasFile('img')) {
            //Nghiên cứu tài liệu: https://image.intervention.io/v3
            $manager = new ImageManager(new Driver());
            // Hàm uniquid sẽ tạo ra một chuỗi số thập phân theo thời gian
            // Hàm hexdec sẽ chuyển đổi số thập phân thành số nguyên
            //$request->file($imgField)->getClientOriginalExtension() chỉ trả về phần mở rộng của tệp
            $name_gen = hexdec(uniqid()).'.'.$request->file('img')->getClientOriginalExtension();
            // Nó sẽ đọc file và trả về
            $img = $manager->read($request->file('img'));
            // Thay đổi kích thước của hình ảnh
            $img = $img->resize(370, 246);
            // base_path dùng để lấy đường dẫn tuyệt đối đến thư mục gốc của ứng dụng laravel
            $img->toJpeg(80)->save(base_path('public/upload/product/'. $name_gen));
            $save_url = 'upload/product/'.$name_gen;
        }else {
            return response()->json('Chua vao file', 404);
        }

          // Xử lý các hình ảnh phụ
          $img1 = null;
          $img2 = null;
          $img3 = null;

        foreach (['img1', 'img2', 'img3'] as $imgField) {
            if ($request->hasFile($imgField)) {
                $manager = new ImageManager(new Driver());
                $name_gen = hexdec(uniqid()).'.'.$request->file($imgField)->getClientOriginalExtension();

                $img = $manager->read($request->file($imgField));
                $img = $img->resize(370, 246);
                $img->toJpeg(80)->save(base_path('public/upload/product/' . $name_gen));
                ${$imgField} = 'upload/product/' . $name_gen;
            } else {
                return response()->json('Hình ảnh ' . str_replace('img', '', $imgField) . ' không được trống', 404);
            }
        }

        $product = sanpham::create([
            'idmenu' => $request->input('idmenu'),
            'idcolor' => $request->input('idcolor'),
            'idGB' => $request->input('idGB'),
            'tensp' => $request->input('tensp'),
            'mota' => $request->input('mota'),
            'img' => $save_url,
            'img1' => $img1,
            'img2' => $img2,
            'img3' => $img3,
            'dongia' => $request->input('dongia'),
            'giamgia' => $request->input('giamgia'),
            'slton' => $request->input('slton'),
        ]);
        return response()->json($product, 200);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pro = sanpham::find($id);

        // muốn dùng được $pro->color->mausac phải có belongTo đến bảng khác 
        $pro->idmenu = $pro->menu->tenloai; // Chuyển idmenu thành tên menu
        $pro->idcolor = $pro->color->mausac;
        $pro->idGB = $pro->dungluong->GB;

        $pro->img = asset($pro->img);
        $pro->img1 = asset($pro->img1);
        $pro->img2 = asset($pro->img2);    
        $pro->img3 = asset($pro->img3);          
        return response()->json($pro, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ValidateData = Validator::make($request->all(),[
            'idmenu' => "required",
            'idcolor' => "required",
            'idGB' => "required",
            'tensp' => "required",
            'mota' => "required",
            'img' => "required|image",
            'img1' => "required|image",
            'img2' => "required|image",
            'img3' => "required|image",
            'dongia' => "required|numeric",
            'giamgia' => "required|numeric",
            'slton' => "required|numeric",
        ], [
            'idmenu.required' => "Tên loại không được để trống",
            'idcolor.required' => "Màu sắckhông được để trống",
            'idGB.required' => "Dung lượng không được để trống",
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
            'img.image' => 'Hình ảnh phải là một tệp hình ảnh',
            'img1.image' => 'Hình ảnh phải là một tệp hình ảnh',
            'img2.image' => 'Hình ảnh phải là một tệp hình ảnh',
            'img3.image' => 'Hình ảnh phải là một tệp hình ảnh',
        ]);

        if($ValidateData->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $ValidateData->errors()],422);
        }

        $product = sanpham::find($id);
        if($product) {
            $product->update();
            return $product->json($product, 200);
        }else {
            return response()->json(
                ['message' => "Product not found"],
                404
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pro = sanpham::find($id);
        if($pro) {
            $pro->delete();
            return response()->json('Đã xóa thành công', 201);
        }
    }
}
