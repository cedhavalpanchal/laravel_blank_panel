<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Http\JsonResponse;

class ChangePasswordController extends Controller
{
    public function showChangePasswordForm()
    {
        return view('auth.change_password');
    }

    public function changePassword(Request $request)
    {
        $rules = [
            'current_password' => 'required:change_password,true',
            'new_password' => [
                'required',
                'min:6',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>]).+$/',
            ],
            'confirm_password' => 'required|same:new_password',
        ];

        $messages = [
            'current_password.required' => 'Please enter current/old password.',

            'new_password.required' => 'Please enter new password.',
            'new_password.min' => 'Your New password/Confirm New Password must include at least 6 characters including 1 uppercase, 1 lowercase , 1 number & 1 Special character',
            'new_password.regex' => 'Your New password/Confirm New Password must include at least 6 characters including 1 uppercase, 1 lowercase & 1 number & 1 Special character',

            'confirm_password.required' => 'Please enter confirm password.',
            'confirm_password.same' => 'New password and confirm new password must be same.',
        ];

        $request->validate($rules, $messages);


        // Check if the current password matches
        if (!Hash::check($request->input('current_password'), auth()->user()->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect.',
            ], 401);
        }


        // Check if the new password is different from the current password
        if (Hash::check($request->input('new_password'), auth()->user()->password)) {
            return response()->json([
                'success' => false,
                'message' => 'New password should be different from the current password.',
            ], 401);
        }

        // Update the password
        auth()->user()->update([
            'password' => bcrypt($request->input('new_password')),
        ]);

        // You may also want to logout the user and ask them to log in with the new password


        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully. Please log in with your new password.',
            'redirect' => route('dashboard'),
        ]);
    }
}
