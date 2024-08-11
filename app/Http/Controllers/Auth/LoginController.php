<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo;

    public function __construct()
    {
        $this->redirectTo = route("dashboard");
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|email',
            'password' => 'required|string',
        ], $this->customValidationMessages());
    }

    protected function customValidationMessages()
    {
        return [
            $this->username() . '.required' => 'Please enter Email id.',
            $this->username() . '.email' => 'Please enter valid Email id.',
            'password.required' => 'Please enter password.',
        ];
    }

    protected function sendFailedLoginResponse(Request $request): JsonResponse
    {
        return new JsonResponse(['error' => 'Invalid Email id or Password.'], 401);
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);
        $userEmail = $credentials['email'];
        $password = $credentials['password'];

        // Check if the user exists and the password matches
        $user = DB::table('users')
            ->where('email',$userEmail)
            ->first();

        if ($user && $user->password != null && Hash::check($password, $user->password)) {
            // Authentication successful
            Auth::loginUsingId($user->id); // Manually log in the user
            return true;
        }

        return false;
    }
}
