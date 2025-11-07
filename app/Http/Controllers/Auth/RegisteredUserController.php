<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
    public function create(): View
    {
        return view('auth.register');
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
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:15', 'unique:'.User::class],
            'username' => ['required', 'string', 'max:50', 'unique:'.User::class],
            'next_of_kin_name' => ['required', 'string', 'max:255'],
            'next_of_kin_phone' => ['required', 'string', 'max:15'],
            'next_of_kin_relationship' => ['required', 'string', 'max:50'],
            'role' => ['required', 'string', 'in:member,admin'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'phone.unique' => 'This phone number is already registered.',
            'username.unique' => 'This username is already taken.',
            'next_of_kin_name.required' => 'Next of kin name is required for registration.',
            'next_of_kin_phone.required' => 'Next of kin phone number is required.',
            'next_of_kin_relationship.required' => 'Please specify relationship with next of kin.',
            'role.required' => 'Please select a role.',
        ]);

        // Security check: Only allow admin registration if there are no existing admins
        // or if the current user is an admin
        $selectedRole = $request->role;
        
        if ($selectedRole === 'admin') {
            $existingAdmins = User::where('role', 'admin')->count();
            
            // If there are existing admins, check if current user is authenticated and is admin
            if ($existingAdmins > 0) {
                if (!Auth::check() || !Auth::user()->isAdmin()) {
                    return redirect()->back()->with('error', 'Only existing administrators can create new admin accounts.');
                }
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'username' => $request->username,
            'next_of_kin_name' => $request->next_of_kin_name,
            'next_of_kin_phone' => $request->next_of_kin_phone,
            'next_of_kin_relationship' => $request->next_of_kin_relationship,
            'role' => $selectedRole,
            'account_balance' => 0, // Start with zero balance
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Only log in if it's a member registration or if admin is creating another admin
        if ($selectedRole === 'member' || (Auth::check() && Auth::user()->isAdmin())) {
            Auth::login($user);
        }

        if ($selectedRole === 'admin') {
            return redirect()->route('admin.members')->with('success', 'Admin account created successfully.');
        }

        return redirect(route('dashboard', absolute: false));
    }
}