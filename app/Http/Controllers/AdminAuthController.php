<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    public function register(Request $request) {
        $val = Validator::make($request->all(), [
            "name" => "required|unique:users,name",
            "password" => "required",
        ]);
        if ($val->fails()) {
            return response()->json([
                "message" => "Invalid field",
                "body" => $val->errors(),
            ], 403);
        }
        $user = new User();
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            "message" => "Berhasil menambahkan user",
            "body" => null,
        ]);
    }

    public function login(Request $request) {
        $val = Validator::make($request->all(), [
            "name" => "required",
            "password" => "required",
        ]);
        if ($val->fails()) {
            return response()->json([
                "message" => "Invalid field",
                "body" => $val->errors(),
            ], 403);
        }
        $user = User::where('name', $request->name)->first();
        if ($user) {
            if (password_verify($request->password, $user->password)) {
                if (is_null($user->login_token)) {
                    $token = hash('md5', time().$user->name);
                    $user->login_token = $token;
                    $user->save();
    
                    return response()->json([
                        "message" => "Login berhasil",
                        "body" => [
                            "name" => $user->name,
                            "token" => $token,
                            "expired_at" => time() + (60*10), // 10 menit
                        ]
                    ]);
                }
                return response()->json([
                    "message" => "Akun anda sedang aktif.",
                    "body" => null,
                ], 403);
            }
        }
        return response()->json([
            "message" => "Username atau password salah",
            "body" => null,
        ], 401);
    }
    
    public function logout(Request $request) {
        $user = $request->attributes->get('user');
        $user->login_token = null;
        $user->save();
        return response()->json([
            "message" => "Berhasil logout.",
            "body" => null
        ]);
    }
    
    public function destroy($name) {
        $user = User::where('name', $name)->first();
        if ($user) {
            $user->delete();
            return response()->json([
                "message" => "Berhasil menghapus user.",
                "body" => null
            ]);
        }
        return response()->json([
            "message" => "User tidak ditemukan",
            "body" => null,
        ], 404);
    }
}
