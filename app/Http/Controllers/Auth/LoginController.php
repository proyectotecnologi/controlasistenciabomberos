<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{

    use AuthenticatesUsers;


    protected function redirectTo()
    {
        return route('dashboard');
    }


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function attemptLogin($request)
{
    $user = \App\Models\User::where('email', $request->email)->first();

    if ($user) {
        // Si el hash NO es válido → devolver error normal
        if (! Hash::isHashed($user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Credenciales incorrectas.'],
            ]);
        }
    }

    return $this->guard()->attempt(
        $this->credentials($request),
        $request->boolean('remember')
    );
}
}
