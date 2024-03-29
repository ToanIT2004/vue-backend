<?php

namespace App\Http\Controllers;

use App\Models\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserConTroller extends Controller
{
    public function index()
    {
        return response()->json(users::all(), 200);
    }

    public function changePass(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'newpass' => 'required|min:6|confirmed',
        ], [
            'newpass.required' => 'Mật khẩu mới không được để trống', 
            'newpass.min' => 'Mật khẩu mới phải trên 6 ký tự', 
            'newpass.confirmed' => 'Mật khẩu không khớp'
        ]);
        $email = $request->input('email');
        $password = $request->input('password');
        $newpass = $request->input('newpass');
        $user = Users::where('email', $email)->first();

        if (!Hash::check($password, $user->password)) {
            return response()->json(['error' => 'Mật khẩu cũ không đúng'], 404);
        }

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Update the user's password
        $user->update(['password' => Hash::make($newpass)]);
        return response()->json('Đổi mật khẩu thành công', 200);
    }

    public function indexUser()
    {
        $user = \DB::table('users')
            ->where('is_admin', '=', 0)
            ->whereNull('deleted_at') // Kiểm tra deleteted có null không
            ->get();

        if ($user) {
            return response()->json($user, 200);
        }
    }

    public function indexEmploy()
    {
        $user = \DB::table('users')
            ->where('is_admin', '=', 1)
            ->whereNull('deleted_at') // Kiểm tra deleteted có null không
            ->get();

        if ($user) {
            return response()->json($user, 200);
        }
    }

    public function addEmploy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lastname' => 'required',
            'firstname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ], [
            'lastname.required' => 'Họ không được để trống',
            'firstname.required' => 'Tên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không phù hợp',
            'email.unique' => 'Email này đã tồn tại',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải 6 ký tự trở lên',
        ]);

        if ($validator->fails()) {
            return response()->json(
                ['message' => 'Validation failed', 'errors' => $validator->errors()],
                422
            );
        }

        $hashedPassword = Hash::make($request->input('password'));

        $users = $users = users::create([
            'lastname' => $request->input('lastname'),
            'firstname' => $request->input('firstname'),
            'email' => $request->input('email'),
            'password' => $hashedPassword,
            'is_admin' => 1,
        ]);
        
        return response()->json($users, 201);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lastname' => 'required',
            'firstname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed' 
        ], [
            'lastname.required' => 'Họ không được để trống',
            'firstname.required' => 'Tên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không phù hợp',
            'email.unique' => 'Email này đã tồn tại',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải 6 ký tự trở lên',
            'password.confirmed' => 'Mật khẩu không hợp lệ'
        ]);

        if ($validator->fails()) {
            return response()->json(
                ['message' => 'Validation failed', 'errors' => $validator->errors()],
                422
            );
        }

        // Hash the password before storing
        $data = $request->all();
        $data['password'] = \Hash::make($request->password);

        $users = Users::create($data);
        return response()->json($users, 201);

        // $users = users::create($request->all());
        // return response()->json($users, 201);
    }


    // login User
    function getUser(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $user = \DB::table('users')
            ->where('email', $email)
            // ->where('password', $password)
            ->first();

        if ($user) {
            if (Hash::check($password, $user->password)) {
                return response()->json($user, 200);
            }
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    // login Admin
    function getAdmin(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $user = \DB::table('users')
            ->where('email', $email)
            // ->where('password', Hash::check($password, $hashedValue))    
            ->where('is_admin', '>', 0)
            ->first();

        

        if ($user && Hash::check($password, $user->password)) {
            return response()->json($user, 200);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    public function show(string $id)
    {
        $user = users::find($id);
        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6'
        ], [
            'password.min' => 'Mật khẩu phải 6 ký tự trở lên',
        ]);

        if ($validator->fails()) {
            return response()->json(
                ['message' => 'Validation failed', 'errors' => $validator->errors()],
                422
            );
        }
        $user = users::find($id);

        if ($user) {
            // Hashing the password
            $hashedPassword = Hash::make($request->input('password'));

            // Update user's password with hashed password
            $user->update(['password' => $hashedPassword]);
            // $user->update(['password' => $request->input('password')]);
            return response()->json($user, 200);
        } else {
            return response()->json(
                ['message' => "User not found"],
                404
            );
        }
    }

    // Lấy ra tất cả bản ghi đã xóa mềm
    public function archive()
    {
        $users = users::onlyTrashed()->get();
        return response()->json($users, 200);
    }

    // Khôi phục xóa mềm
    public function restore(string $id)
    {
        // Nó chỉ tìm đc thông tin chưa xóa mềm thôi
        // $user = users::find($id);


        // tìm kiếm người dùng chưa hoặc đã xóa mềm
        $user = users::withTrashed()->find($id);
        // Kiểm tra đã bị xóa mềm hay chưa
        if ($user->trashed()) {
            $user->restore(); // hàm restore để khôi phục dữ liệu
            return response()->json($user, 200);
        } else {
            return response()->json(
                ['message' => 'Người dùng không tồn tại hoặc không bị xóa mềm'],
                404
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = users::withTrashed()->find($id);
        //Kiểm tra nếu user đã được xóa mềm thì xóa luôn
        if ($user->trashed()) {
            $user->forceDelete(); // Xóa thông tin khi đã xóa mềm
        } else {
            $user->delete();
        }
        return response()->json($user, 201);
    }
}
