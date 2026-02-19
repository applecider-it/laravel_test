<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

use App\Models\User;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        /** @var User */
        $user = $request->user();

        $validated = $request->validateWithBag(
            'updatePassword',
            rules: [
                'current_password' => ['required', 'current_password'],
                'password' => $user->validationPassword(),
            ],
            attributes: [
                'current_password' => __('myapp.columns.current_password'),
                'password' => __('myapp.models.user.columns.password'),
            ]
        );

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    }
}
