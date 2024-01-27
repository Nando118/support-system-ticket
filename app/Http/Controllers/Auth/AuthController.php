<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserEmailCheckRequest;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserPasswordRequest;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

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

            return redirect()->intended(route("home.index"));
        }

        return redirect()->back()->with('invalid_credentials', 'Kredensial tidak valid!');
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
            return redirect()->route("login.index")->with('success_register', 'Silahkan login di sini!');
        }else{
            return redirect()->back()->with('failed_register', 'Terjadi kesalahan saat proses registrasi akun!');
        }
    }

    public function forgotPasswordRequest() {
        return view("auth.password.form-email", [
            "title_page" => "Support Ticket System | Forget Password Page"
        ]);
    }

    public function forgotPasswordEmail(UserEmailCheckRequest $request) {
        try {
            $request->validated();

            $status = Password::sendResetLink($request->only("email"));

            return $status === Password::RESET_LINK_SENT ? back()->with(["send_reset_link_success" => "Link reset password telah dikirim ke alamat email mu!"]) : back()->with(["send_reset_link_failed" => "Alamat email tidak valid atau belum terdaftar!"]);
        }catch (ModelNotFoundException $exception){
            return redirect()->back()->with('send_reset_link_failed', 'Terjadi kesalah saat mengirim link reset password!');
        }
    }

    public function resetPassword(string $token) {
        if ($token) {
            return view("auth.password.form-reset", [
                "title_page" => "Support Ticket System | Reset Password Page",
                "token" => $token,
                "email" => \request("email")
            ]);
        } else {
            return redirect()->route("login.index")->with('error_reset_password', 'Terjadi kesalahan saat proses reset password!');
        }
    }

    public function resetPasswordUpdate(UserPasswordRequest $request) {
        $validated = $request->validated();

        if ($validated) {
            $status = Password::reset(
                $request->only('email', 'password', 'token'),
                function (User $user, string $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));

                    $user->save();

                    event(new PasswordReset($user));
                }
            );

            return $status === Password::PASSWORD_RESET ? redirect()->route('login.index')->with('success_reset_password', "Silahkan login di sini!") : back()->withErrors(['failed_reset_password' => "Terjadi kesalahan saat proses reset password!"]);
        } else {
            return redirect()->route("password.request")->with('error_reset_password', 'Terjadi kesalahan saat proses reset password!');
        }
    }

    public function logout(Request $request) {
        /**
         * Cek apakah ada autentikasi user yang sedang berlangsung atau tidak
         */
        if (auth()->check()) {
            /**
             * Jika ada hapus sesi autentikasi user yang sedang berlangsun saat ini
             */
            Auth::logout();

            /**
             * Buat invalid session login sebelumnya
             */
            $request->session()->invalidate();

            /**
             * Regenerate token csrf baru
             */
            $request->session()->regenerateToken();
        }

        return redirect(route('login.index'));
    }
}
