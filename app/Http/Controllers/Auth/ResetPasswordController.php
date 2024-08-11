<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\ResetPasswordLinkMail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;


class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo;


    public function store(Request $request)
    {

        $encryptionKey = config('constant.encryption_key');
        $user = DB::table('users')
            ->selectRaw("*, pgp_sym_decrypt(email::bytea, ?) as decrypted_email", [$encryptionKey])
            ->whereRaw("pgp_sym_decrypt(email::bytea, ?) = ?", [$encryptionKey, $request->email])
            ->where("deleted_at",null)
            ->first();

        // Validate the email
        $validator = Validator::make(['email' => $user->decrypted_email], [
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) use ($user) {
                    if (!$user) {
                        $fail('User does not exist.');
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $decryptedEmail = $user->decrypted_email;
        // Check the status of the user
        if ($user->status == 0) {
            return response()->json(['error' => 'Your account is deactivated.'], 401);
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email' => $decryptedEmail,
            'token' => $token,
            'created_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addMinutes(Config::get('constants.RESET_TOKEN_EXPIRATION_MINUTES')),
        ]);

        $resetPasswordMail = new ResetPasswordLinkMail([
            'token' => $token,
            'name' => $user->name,
            'email' => $decryptedEmail,
            'actionText' => 'Reset',
        ]);

        // Use the send method with the Mailable instance
        $status = Mail::to($decryptedEmail)->send($resetPasswordMail);
            return response()->json([
                'success' => 'Reset password link sent to registered email address!',
                'stay_on_page' => true,
            ]);

    }

    public function showResetPasswordForm(Request $request,$token)
    {
        if (Auth::check()) {
            return redirect()->route('dashboard')->with(['error' => 'User is already logged in.']);
        }

        // Use the email parameter instead of the token
        $resetToken = DB::table('password_reset_tokens')
            ->where('token', $token)
            ->where('used',0)
            ->first();

        if (!empty($resetToken)) {
            $currentTime = now();
            $tokenCreationTime = Carbon::parse($resetToken->created_at);
            $tokenExpirationTime = $tokenCreationTime->addMinutes(config('constant.RESET_TOKEN_EXPIRATION_MINUTES'));

            // Check if the token has expired
            if ($currentTime > $tokenExpirationTime) {
                return redirect()->route('password.forgot')->with(['error' => 'Link has Expired']);
            }

            if ($resetToken->used == 1) {
                return redirect()->route('password.forgot')->with(['error' => 'Link has already been used.']);
            }

            return view('auth.reset_password', ['token' => $token, 'email' => $resetToken->email]);
        } else {
            return redirect()->route('password.forgot')->with(['error' => 'Link has Expired']);
        }
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Check the user's role and redirect accordingly
            if ($user->role_id == 1 || $user->role_id == 2) {
                return response()->json(['redirect' => route('dashboard')]);
            }
        } else {
            $resetToken = DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->where('used', 0)
                ->first();

            if (!$resetToken) {
                return response()->json(['error' => 'Password reset link is invalid or already used.','redirect' => route('login')], 401);
            }

            $encryptionKey = config('constant.encryption_key');

            // Decrypt the email stored in the reset token
            $decryptedEmail = DB::table('users')->whereRaw("pgp_sym_decrypt(email::bytea, ?) = ?", [$encryptionKey, $request->email])->whereNull('deleted_at')->value('email');

            // Find the user by the decrypted email
            $user = User::where('email', $decryptedEmail)->first();
            if ($user) {
                // Update the password
                $user->password = Hash::make($request->password);
                $user->created_at = Carbon::now();
                $user->updated_at = Carbon::now();
                $user->save();


                // Update the 'used' field in the password reset tokens table
                DB::table('password_reset_tokens')->where('email', $request->email)->update(['used' => 1]);

                // Return a JSON response with redirect information
                return response()->json(['success' => 'Password updated successfully', 'redirect' => route('login')]);
            } else {
                return response()->json(['error' => 'Something went wrong!']);
            }
        }
    }
}
