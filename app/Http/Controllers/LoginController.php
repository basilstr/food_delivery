<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $formField = $request->only('login', 'password', 'remember');
        //dd(Hash::make($formField['password']) );

        if (Auth::attempt(['login' => $formField['login'], 'password' => $formField['password'], 'status' => User::ACTIVE], $formField['remember'])) {
            $request->session()->regenerate();
            return redirect()->intended('/admin');
        }

        return redirect(route('login'))->withErrors([
            'password' => 'Error login or password',
        ]);
    }
}
