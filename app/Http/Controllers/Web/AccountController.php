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
        return view('account.index');
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

        return redirect(route('account'))
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

        return redirect(route('account'))
            ->with('message_type', 'success')
            ->with('message', 'Your password has been updated!');
    }

     /**
     * Show create access token page.
     *
     * @return \Illuminate\View\View
     */
    public function showAccessTokens()
    {
        $accessTokens = Auth::user()->tokens->all();

        return view('account.access-tokens', [
            'accessTokens' => $accessTokens,
        ]);
    }

    /**
     * Create an access token for the account.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createAccessToken(Request $request)
    {
        $token = $request->user()->createToken('lp_access_token')->plainTextToken;

        return redirect(route('account'))
            ->with('access_token', $token)
            ->with('message_type', 'success')
            ->with('message', 'A new access token has been created. Make sure to copy your now as you will not be able to see it again.');
    }
}
