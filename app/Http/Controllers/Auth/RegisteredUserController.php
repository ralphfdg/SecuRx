<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PatientProfile;
use App\Models\DoctorProfile;
use App\Models\PharmacistProfile;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        return view('auth.register', ['role' => $request->role ?? 'patient']);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Base Validation (Applies to everyone)
        $request->validate([
            'role'       => ['required', 'in:patient,doctor,pharmacist'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'dob'        => ['required', 'date'],
            'gender'     => ['required', 'string'],
            'mobile_num' => ['required', 'string', 'max:20'],
            'username'   => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email'      => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password'   => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Role-Specific Validation
        if ($request->role === 'doctor') {
            $request->validate([
                'license_number'     => ['required', 'string', 'unique:doctor_profiles,prc_number'],
                'license_expiration' => ['required', 'date'],
                'ptr_number'         => ['required', 'string'],
            ]);
        } elseif ($request->role === 'patient') {
            $request->validate([
                'height'  => ['required', 'numeric'],
                'weight'  => ['required', 'numeric'],
                'address' => ['required', 'string'],
            ]);
        } elseif ($request->role === 'pharmacist') {
            $request->validate([
                'pharmacy_name'    => ['required', 'string'],
                'lto_number'       => ['required', 'string', 'unique:pharmacist_profiles,lto_number'],
                'lto_expiration'   => ['required', 'date'],
                'business_address' => ['required', 'string'],
            ]);
        }

        // 3. Database Transaction (If creating the profile fails, it deletes the user so data isn't corrupted)
        $user = DB::transaction(function () use ($request) {
            
            // Determine account status. Patients are active immediately. Pros must wait for Admin.
            $accountStatus = ($request->role === 'patient') ? 'active' : 'pending';

            // Create the Base User Account with ALL universal personal data
            $user = User::create([
                'first_name'  => $request->first_name,
                'last_name'   => $request->last_name,
                'middle_name' => $request->middle_name,
                'qualifier'   => $request->qualifier,
                'name'        => trim($request->first_name . ' ' . $request->last_name), // Combining for Laravel default
                'username'    => $request->username,
                'email'       => $request->email,
                'dob'         => $request->dob,
                'gender'      => $request->gender,
                'mobile_num'  => $request->mobile_num,
                'password'    => Hash::make($request->password),
                'role'        => $request->role,
                'status'      => $accountStatus,
            ]);

            // Create the specific profile
            if ($request->role === 'patient') {
                PatientProfile::create([
                    'user_id'        => $user->id,
                    'height'         => $request->height,
                    'weight'         => $request->weight,
                    'address'        => $request->address,
                    'school_work'    => $request->school_work,
                    'mother_name'    => $request->mother_name,
                    'mother_contact' => $request->mother_contact,
                    'father_name'    => $request->father_name,
                    'father_contact' => $request->father_contact,
                ]);
            } elseif ($request->role === 'doctor') {
                DoctorProfile::create([
                    'user_id'            => $user->id,
                    'prc_number'         => $request->license_number,
                    'prc_expiration'     => $request->license_expiration,
                    'ptr_number'         => $request->ptr_number,
                    's2_number'          => $request->s2_number,
                    's2_expiration'      => $request->s2_expiration,
                ]);
            } elseif ($request->role === 'pharmacist') {
                PharmacistProfile::create([
                    'user_id'          => $user->id,
                    'pharmacy_name'    => $request->pharmacy_name,
                    'lto_number'       => $request->lto_number,
                    'lto_expiration'   => $request->lto_expiration,
                    'business_address' => $request->business_address,
                ]);
            }

            return $user;
        });

        event(new Registered($user));

        // 4. The Capstone Logic: Only log in Patients automatically.
        if ($user->role === 'patient') {
            Auth::login($user);
            return redirect()->route('dashboard'); // Forward to Patient portal
        }

        // 5. Doctors and Pharmacists get sent to the "Pending Approval" page instead
        return redirect()->route('pending.approval')->with('success', 'Registration submitted. Please wait 24-48 hours for DOH/Admin verification.');
    }
}