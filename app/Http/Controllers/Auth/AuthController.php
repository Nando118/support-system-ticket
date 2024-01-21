<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function loginIndex()
    {
        return view("auth.login", [
            "title_page" => "Support Ticket System | Login Page"
        ]);
    }

    public function loginPost(UserLoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route("welcome"));
        }

        return redirect()->back()->with('error', 'Kredensial tidak valid!');
    }

    public function registerIndex()
    {
        return view("auth.register.form", [
            "title_page" => "Support Ticket System | Register Page"
        ]);
    }

    public function registerPost(UserRegisterRequest $request)
    {
        $validated = $request->validated();

        $user = new User($validated);
        $user->password = Hash::make($validated["password"]);
        $response = $user->save();

        if ($response) {
            return redirect()->route("login.index")->with('success', 'Silahkan login di sini!');
        }else{
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mendaftar!');
        }
    }
}
