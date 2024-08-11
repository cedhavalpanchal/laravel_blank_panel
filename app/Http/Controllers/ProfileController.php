<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;


class ProfileController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user();
        return view('profile.show', compact('user'));
    }

    public function editProfile()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Pass the user data to the view for editing
        return view('profile.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')
                    ->ignore(auth()->id()), // Exclude the current user
            ],
        ], [
            'name.required' => 'Please enter the supplier name.',
            'name.string' => 'The supplier name must be a string.',
            'email_address.required' => 'Please enter a valid email address.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Update basic profile information
        auth()->user()->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully.',
            'redirect' => route('profile.show'),
        ]);
    }
}
