<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function showLoginForm()
    {
        $this->ensureDefaultKepalaAccount();

        return view('auth.login2');
    }

    /**
     * Make a fresh local installation usable without manually importing a
     * user record. Existing accounts and passwords are never overwritten.
     */
    private function ensureDefaultKepalaAccount(): void
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        User::firstOrCreate(
            ['email' => 'kepala@perpus.test'],
            [
                'name' => 'Kepala Perpustakaan',
                'role' => 'Kepala Perpustakaan',
                'status' => 'Aktif',
                'password' => Hash::make('Simpus123!'),
            ]
        );
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'email' => ['Email atau password yang kamu masukkan salah.'],
        ]);
    }

    protected function redirectTo()
    {
        $user = auth()->user();

        if ($user?->role === 'Anggota') {
            return '/informasi-buku';
        }

        return '/home';
    }


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
