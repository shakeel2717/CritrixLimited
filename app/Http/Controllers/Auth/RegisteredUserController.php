<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\NewUserWelcomeNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create($username = null): View
    {
        if ($username) {
            $user = User::where("username", $username)->firstOrFail();
        }
        return view('auth.register', compact('username'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'username' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'referral' => ['nullable', 'string', 'exists:users,username'],
            'country' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'whatsapp' => ['required', 'string', 'max:255'],
        ]);

        $referral = null;
        if ($request->referral) {
            $referral = User::where('username', $request->referral)->firstOrFail();
            $referral = $referral->id;
        }

        $ip = $this->getClientIP($request);

        if (User::where('ip_address', $ip)->whereDay('created_at', today())->exists()) {
            return back()->withErrors([
                'ip_address' => 'You have already registered with this IP address.',
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'referral_id' => $referral,
            'country' => $request->country,
            'phone' => $request->phone,
            'ip_address' => $ip,

        ]);

        event(new Registered($user));

        // send notification to user
        $user->notify(new NewUserWelcomeNotification($user));

        Auth::login($user);

        return redirect(route('user.dashboard.index', absolute: false));
    }


    public function getClientIP(Request $request)
    {
        $ip = null;

        // Check for CloudFlare IP
        if ($request->hasHeader('CF-Connecting-IP')) {
            $ip = $request->header('CF-Connecting-IP');
        }
        // Check for Forwarded IP
        elseif ($request->hasHeader('X-Forwarded-For')) {
            $ip = explode(',', $request->header('X-Forwarded-For'))[0];
        }
        // Check for Remote Address
        elseif ($request->server('REMOTE_ADDR')) {
            $ip = $request->server('REMOTE_ADDR');
        }

        // Fallback to default method
        if ($ip === null) {
            $ip = $request->ip();
        }

        // Validate IP address
        return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : null;
    }
}
