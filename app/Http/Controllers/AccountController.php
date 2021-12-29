<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\Rules;

class AccountController extends Controller
{
    public function index()
    {
        return view('account');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:150',
            'email' => 'required|email|max:150',
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect('/account')
            ->with('status', 'Your account has been updated!');
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'new_password' => ['required', 'confirmed', Rules\Password::defaults()],
            'new_password_confirmation' => 'required',
        ]);

        $request->user()->fill([
            'password' => Hash::make($request->newPassword)
        ])->save();

        return redirect('/account')
            ->with('status', 'Your password has been updated!');
    }
}
