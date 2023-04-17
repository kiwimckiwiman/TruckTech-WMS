<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\workshopOwner;
use Illuminate\Http\Request;

class WorkshopOwnerController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store()
    {
        $attributes = request()->validate([
            'username' => 'required|max:255|min:2',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:5|max:255',
            'terms' => 'required'
        ]);
        $workshopOwner = User::create($attributes);
        auth()->login($workshopOwner);

        return redirect('/dashboard');
    }
}
