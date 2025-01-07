<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use App\Http\Controllers\Controller;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function redirectTo()
    {
        session()->flash('success', 'You are logged in!');
        return $this->redirectTo;
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $loginField = $this->username();
        $userExists = User::where($loginField, $request->username)->exists();

        if (!$userExists) {
            throw ValidationException::withMessages([
                $loginField => ['Akun dengan username atau email ini tidak ditemukan.'],
            ]);
        }

        throw ValidationException::withMessages([
            'password' => ['Password yang dimasukkan salah.'],
        ]);
    }

    public function username()
    {
        $login = request()->input('username');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$field => $login]);
        return $field;
    }

    protected function authenticated(Request $request, $user)
    {
        // Ambil nama branch melalui relasi
        $branchDB = $user->employe->branch->database ?? null;

        // Simpan nama branch ke dalam session
        session()->put('company_db', $branchDB);
    }
}
