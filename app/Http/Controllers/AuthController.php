<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $user = new User();
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remenber = $request->input("remember");

        if (Auth::attempt($credentials, $remenber)) {
            $request->session()->regenerate();
            Redis::set('userEmail', $credentials['email']);
            Redis::set('userName', $user->getUserName($credentials['email']));

            Session::put([
                'userEmail' => $credentials['email'],
            ]);
            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ]);
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        return redirect()->route('login');
    }

    // public function reset(Request $request) //TODO:fazer funcionar reset senha
    // {
    //     $request->validate([
    //         'token' => 'required',
    //         'email' => 'required|email',
    //         'password' => 'required|string|min:8|confirmed',
    //     ]);

    //     $user = User::where('email', $request->email)->first();

    //     if (!$user) {
    //         return redirect()->back()->withInput()->withErrors(['email' => 'Email não encontrado']);
    //     }

    //     $user->password = Hash::make($request->password);
    //     dd($request->input(), $user);
    //     $user->save();

    //     return redirect()->route('login');
    // }

    // public function showResetForm(Request $request, $token = null)
    // {
    //     return view('auth.reset-password')->with(
    //         ['token' => $token, 'email' => $request->email]
    //     );
    // }
}
