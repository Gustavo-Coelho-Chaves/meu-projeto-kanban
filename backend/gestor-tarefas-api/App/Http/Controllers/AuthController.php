<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmailVerification;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    public function requestCode(Request $request)
        {
            $request->validate([
                'email' => 'required|email'
            ]);
        
            $code = rand(100000, 999999);
    

        EmailVerification::updateOrCreate(
            ['email' => $request->email],
            ['code' => $code, 'expires_at' => now()->addMinutes(10)]
        );

        Mail::to($request->email)->send(new VerificationCodeMail($code));

        return response()->json(['message' => 'Código enviado.']);
    }

    public function verifyCode(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'code' => 'required'
    ]);

    $verification = EmailVerification::where('email', $request->email)
        ->where('code', $request->code)
        ->where('expires_at', '>', now())
        ->first();

    if (!$verification) {
        return response()->json(['message' => 'Código inválido ou expirado.'], 422);
    }

    // Cria o usuário se não existir
    $user = User::firstOrCreate(
        ['email' => $request->email],
        ['name' => 'Usuário']
    );

    // Deleta verificação usada
    $verification->delete();

    // Gera token Sanctum
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Código verificado com sucesso.',
        'token' => $token,
        'user' => $user
    ]);
}
}
