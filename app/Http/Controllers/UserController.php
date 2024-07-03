<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin_dashboard');
            } else {
                return redirect()->route('index');
            }

            return redirect()->route('admin_dashboard');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        if ($user->save()) {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                if (Auth::user()->role == 'admin') {
                    return redirect()->route('admin_dashboard');
                } else {
                    return redirect()->route('index');
                }

                return redirect()->route('admin_dashboard');
            }
        }

        return redirect()->route('login');
    }
    function logout()
    {
        Auth::logout();
        return redirect()->route('index');
    }
    
}
