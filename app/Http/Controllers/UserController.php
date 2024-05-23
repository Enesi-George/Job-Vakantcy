<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Jobs\SendEmailVerification;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
    public function store(Request $request)
    {
        $otp = Str::random(6);
        $formValidation  = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6'
        ]);

        //Hash Password
        $formValidation['password'] = bcrypt($formValidation['password']);

        $user = User::create($formValidation);
        $user->otp_code = $otp;
        $user->save();
        // Dispatch job to send email for email verification
        SendEmailVerification::dispatch($user);

        //login
        auth()->login($user);

        return redirect('/')->with('message', 'Registered!. Kindly verify account via your mail');
    }

    //verify email
    public function verifyEmail($otp)
    {
            $user = User::where('otp_code', $otp)->first();
            if(!$user){
                return redirect('/')->with('message', 'Invalid verification token');

            }else if(isset($user->email_verified_at)){
                return redirect('/')->with('message', 'Account already verified');
            }
            $user->email_verified_at = now();
            $user->save();
            //login
            auth()->login($user);
            return redirect('/')->with('message', 'Account verified successfully!');
    }

    //Logout User
    public function logout(Request $request)
    {
        auth()->logout(); //remove authenticatn infomation from the user session

        //invalidate user sessions
        $request->session()->invalidate();
        //regenerate token
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been logged out!');
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
        $formValidation  = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        //attmempt to log in user
        if (auth()->attempt($formValidation)) {
            $request->session()->regenerate();

            return redirect('/')->with('logged in successfully');
        }

        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }
}
