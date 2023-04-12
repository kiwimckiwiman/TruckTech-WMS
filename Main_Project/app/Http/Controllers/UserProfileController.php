<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    public function show()
    {
        return view('pages.user-profile');
    }

    public function update(Request $request)
    {
        $attributes = $request->validate([
            'username' => ['required','max:255', 'min:2'],
            'email' => ['required', 'email', 'max:255',  Rule::unique('users')->ignore(auth()->user()->user_id),],
        ]);

        auth()->user()->update([
            'username' => $request->get('username'),
            'email' => $request->get('email') ,
        ]);
        return back()->with('succes', 'Profile succesfully updated');
    }
}
