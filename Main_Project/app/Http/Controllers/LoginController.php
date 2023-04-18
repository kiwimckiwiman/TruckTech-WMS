<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;

class LoginController extends Controller
{
    /**
     * Display login page.
     *
     * @return Renderable
     */
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'type' => 's'])) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard_sadmin');// change to super admin dashboard view
        }elseif (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'type' => 'c'])) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard_customer');// change to customer dashboard view
        }elseif (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'type' => 'w'])) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard_worker');// change to worker dashboard view
        }elseif (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'type' => 'a'])) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard_admin');// change to workshop owner dashboard view
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
