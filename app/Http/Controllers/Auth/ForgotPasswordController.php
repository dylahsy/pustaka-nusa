<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        try {
            $response = Password::broker()->sendResetLink(
                $request->only('email')
            );
        } catch (\Symfony\Component\Mailer\Exception\TransportExceptionInterface $e) {
            report($e);

            $message = 'Email reset belum bisa dikirim karena server mail belum aktif. Silakan cek konfigurasi SMTP atau gunakan mailer log sementara.';

            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => $message]);
        } catch (\Throwable $e) {
            report($e);

            $message = 'Email reset belum bisa dikirim karena server mail belum aktif. Silakan cek konfigurasi SMTP atau gunakan mailer log sementara.';

            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => $message]);
        }

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($request, $response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }

    protected function validateEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);
    }

    protected function sendResetLinkResponse(Request $request, $response)
    {
        $message = 'Tautan reset password telah dikirim ke email Anda.';

        if ($request->wantsJson()) {
            return response()->json(['message' => $message]);
        }

        return back()->with('status', $message);
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        $message = match ($response) {
            Password::INVALID_USER => 'Kami tidak menemukan akun dengan alamat email tersebut.',
            Password::RESET_THROTTLED => 'Terlalu banyak permintaan reset password. Silakan coba lagi beberapa saat lagi.',
            default => 'Tautan reset password tidak dapat dikirim saat ini.',
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
