<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\VerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\RegisterRequest;
use App\Jobs\SendEmailVerificationJob;

class UserController extends Controller
{
    protected $user;
    /**
     * Display a listing of the resource.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Show the registration form for creating a new user.
     */
    public function create()
    {
        return view('users.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterRequest $request)
    {
        try {
            $otp = Str::random(6);

            $formValidation  = $request->userData();
            //Hash Password
            $formValidation->password = bcrypt($formValidation->password);

            $usersDetail = $formValidation->toArray();

            $user = User::create($usersDetail);
            $user->otp_code = $otp;
            $user->otp_expires_at = now()->addMinutes(10);
            $user->save();
            // Dispatch job to send email for email verification
            // SendEmailVerificationJob::dispatch($user);

            Mail::to($user->email)->send(new VerifyEmail($user));


            //login
            auth()->login($user);

            return redirect('/')->with('message', 'Registered!. Kindly verify account via your mail');
        } catch (\Exception $e) {
            Log::error('Registration Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect('/')->with('error', 'Error while registering. Please contact the administrative.');
        }
    }

    //verify email
    public function verifyEmail($otp)
    {
        $user = User::where('otp_code', $otp)->first();
        if (!$user) {
            return redirect('/')->with('message', 'Invalid verification token');
        } else if (isset($user->email_verified_at)) {
            return redirect('/')->with('message', 'Account already verified');
        }
        $user->email_verified_at = now();
        $user->save();
        //login
        auth()->login($user);
        return redirect('/')->with('message', 'Account verified successfully!');
    }

    public function resendVerifyEmailOtp()
    {
        $otp = Str::random(6);
        $user = Auth::user();

        if (isset($user->email_verified_at)) {
            return back()->with('message', 'Email has already been verified');
        }

        $user->otp_code = $otp;
        $user->otp_expires_at = now()->addMinutes(10);
        $user->update();

        SendEmailVerificationJob::dispatch($user);

        return back()->with('message', 'Kindly verify account via your mail');
    }
    //Logout User
    public function logout(Request $request)
    {
        try {
            auth()->logout(); 

            //invalidate user sessions
            $request->session()->invalidate();
            //regenerate token
            $request->session()->regenerateToken();

            return redirect('/')->with('message', 'You have been logged out!');
        } catch (\Exception $e) {
            Log::error('Logout Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect('/')->with('error', 'Error while logging out. Please contact the administrative.');
        }
    }

    /**
     * Display the login resource.
     */
    public function login()
    {
        return view('users.login');
    }

    //Login or Authenticate User
    public function authenticate(Request $request)
    {
        try {
            $formValidation  = $request->validate([
                'email' => ['required', 'email'],
                'password' => 'required'
            ]);

            $user = User::where('email', $formValidation['email'])->exists();

            //attmempt to log in user
            if (auth()->attempt($formValidation)) {
                $request->session()->regenerate();

                return redirect('/')->with('logged in successfully');
            } else if (!$user) {
                return back()->withErrors(['email' => 'Email provided is not registered'])->onlyInput('email');
            };

            return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
        } catch (\Exception $e) {
            Log::error('Login Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect('/')->with('error', 'Error while logging in. Please contact the administrative.');
        }
    }

    public function edit()
    {
        // Find the user by id
        $user = auth()->user();
        if (!$user) {
            return redirect('/')->with('error', 'Invalid user');
        }

        return view('users.edit-user', ['user' => $user]);
    }

    public function update(EditUserRequest $request)
    {
        try {
            // Get the authenticated user
            $user = auth()->user();

            Log::info('Updating user: ', ['user_id' => $user->id]);

            if (!$user) {
                return response()->json(['error' => 'Invalid user'], 404);
            }

            // Get validated data from the request
            $userDetails = $request->validated();

            // Update the user with the validated data
            $user->update($userDetails);

            Log::info('User updated successfully', $user->toArray());
            // Redirect with a success message
            return back()->with('message', 'Profile updated!');
        } catch (\Exception $e) {
            Log::error('Update Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->with('error', 'Error while updating your data. Please contact the administrative.');
        }
    }

    public function resetPassword(Request $request)
    {
        // Validate the password
        $request->validate([
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
            ],
        ]);

        try {
            // Get the authenticated user
            $user = auth()->user();

            if (!$user) {
                return response()->json(['error' => 'Invalid user'], 404);
            }

            // Update the user's password
            $user->update(['password' => Hash::make($request->password)]);

            Log::info('Password reset successfully for user: ', ['user_id' => $user->id]);
            //log user out
            auth()->logout();
            // Redirect with a success message
            return redirect('/login')->with('message', 'Password reset successfully!');
        } catch (\Exception $e) {
            Log::error('Password Reset Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->with('error', 'Error while resetting your password. Please contact the administrative.');
        }
    }
}
