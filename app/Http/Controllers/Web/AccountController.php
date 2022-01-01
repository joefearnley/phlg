<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{    
    /**
     * Get the main view for the account section.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('account');
    }

    /**
     * Update the account information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
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
            ->with('message_type', 'success')
            ->with('message', 'Your account has been updated!');
    }
    
    /**
     * Update the account/user password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'new_password' => ['required', 'confirmed', Rules\Password::defaults()],
            'new_password_confirmation' => 'required',
        ]);

        $request->user()->fill([
            'password' => Hash::make($request->new_password)
        ])->save();

        return redirect('/account')
            ->with('message_type', 'success')
            ->with('message', 'Your password has been updated!');
    }
}
