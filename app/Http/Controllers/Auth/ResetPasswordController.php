<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    protected function rules()
    {
        return [
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ];
    }

    protected function validationErrorMessages()
    {
        return [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password baru wajib diisi.',
            'password.confirmed' => 'Konfirmasi password baru tidak sama.',
            'password.min' => 'Password baru minimal 8 karakter.',
        ];
    }

    protected function sendResetResponse(Request $request, $response)
    {
        $message = 'Password Anda berhasil diperbarui. Silakan login kembali.';

        if ($request->wantsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect($this->redirectPath())->with('status', $message);
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        $message = match ($response) {
            Password::INVALID_TOKEN => 'Tautan reset password tidak valid atau sudah kedaluwarsa.',
            Password::INVALID_USER => 'Kami tidak menemukan akun dengan alamat email tersebut.',
            default => 'Password gagal direset. Silakan coba lagi.',
        };

        if ($request->wantsJson()) {
            throw ValidationException::withMessages([
                'email' => [$message],
            ]);
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => $message]);
    }
}
