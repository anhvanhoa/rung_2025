<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class C_Auth extends Controller
{
    public function GetLogin()
    {
        return view("pages.auth.login");
    }

    public function PostLogin(Request $request)
    {
        $request->validate([
            "username" => "required|email",
            "password" => "required"
        ], [
            "username.required" => "Vui lòng nhập email",
            "username.email" => "Email không đúng định dạng",
            "password.required" => "Vui lòng nhập mật khẩu"
        ]);

        $user = User::where("email", $request->username)->first();

        if (!$user) {
            return back()->with("err", "Email hoặc mật khẩu không chính xác");
        }

        $credentials = [
            "email" => $request->username,
            "password" => $request->password
        ];

        if (auth()->attempt($credentials)) {
            return redirect()->route("dashboard");
        }

        return back()->with("err", "Email hoặc mật khẩu không chính xác");
    }

    public function Logout()
    {
        auth()->logout();
        return redirect()->route("GetLogin");
    }
}
