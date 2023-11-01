<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    //
    public function sendResetLink(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email'
        ]);

        $status = Password::sendResetLink(
            $validatedData
        );

        $outcome = $status === Password::RESET_LINK_SENT;

        if (!$outcome) {
            return response([
                "data" => "Link not sent"
            ]);
        }

        // ? back()->with(['status' => __($status)]) : back()->withErrors(['email' => __($status)])

        return response([
            "data" => $outcome,
            "message" => "Password reset link sent"
        ]);
    }

    public function passwordLink()
    {
        return response('reset password');
    }

    public function resetPassword(Request $request)
    {
        // request()->merge(['token' => $request->query('token')]);

        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed'
        ]);


        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        $outcome = $status === Password::PASSWORD_RESET;

        if (!$outcome) {
            return response([
                "data" => "something went wrong"
            ]);
        }

        return response([
            "message" => "Password reset successfully"
        ]);
    }
}
