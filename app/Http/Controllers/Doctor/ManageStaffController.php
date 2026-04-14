<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\SecretaryProfile;
use App\Models\DoctorProfile;

class ManageStaffController extends Controller
{
    public function index()
    {
        // Get the authenticated doctor's profile to find their clinic_id
        $doctorProfile = DoctorProfile::where('user_id', Auth::id())->first();
        
        $staffMembers = collect();

        if ($doctorProfile && $doctorProfile->clinic_id) {
            // Find all users with the 'secretary' role who belong to this clinic
            $staffMembers = User::where('role', 'secretary')
                ->whereHas('secretaryProfile', function ($query) use ($doctorProfile) {
                    $query->where('clinic_id', $doctorProfile->clinic_id);
                })
                ->orderBy('first_name', 'asc')
                ->paginate(6);
        }

        return view('doctor.staff', compact('staffMembers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile_num' => 'required|string|max:255',
        ]);

        $doctorProfile = DoctorProfile::where('user_id', Auth::id())->firstOrFail();

        // 1. Auto-generate a secure password and username
        $rawPassword = Str::password(12);
        $baseUsername = strtolower($request->first_name . '_' . $request->last_name);
        $username = $baseUsername . '_' . rand(1000, 9999);

        // 2. Create the User record
        $user = User::create([
            'id' => (string) Str::uuid(),
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name . ' ' . $request->last_name,
            'username' => $username,
            'email' => $request->email,
            'mobile_num' => $request->mobile_num,
            'role' => 'secretary',
            'status' => 'active',
            'password' => Hash::make($rawPassword),
        ]);

        // 3. Create the Secretary Profile to link them to the clinic
        SecretaryProfile::create([
            'id' => (string) Str::uuid(),
            'user_id' => $user->id,
            'clinic_id' => $doctorProfile->clinic_id,
        ]);

        // TODO: Fire an Event/Mailable here to send the $rawPassword and $username to $request->email

        return back()->with([
            'success' => 'Secretary account created successfully!',
            'new_username' => $username,
            'new_password' => $rawPassword
        ]);
    }

    public function update(Request $request, $id)
    {
        $staff = User::where('role', 'secretary')->findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $staff->id,
            'mobile_num' => 'required|string|max:255',
        ]);

        $staff->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'mobile_num' => $request->mobile_num,
        ]);

        return back()->with('success', 'Secretary details updated successfully.');
    }

    public function toggleStatus($id)
    {
        $staff = User::where('role', 'secretary')->findOrFail($id);
        
        // Toggle between active and revoked
        $newStatus = $staff->status === 'active' ? 'revoked' : 'active';
        $staff->update(['status' => $newStatus]);

        $message = $newStatus === 'revoked' ? 'Access has been revoked.' : 'Access has been restored.';
        return back()->with('success', $message);
    }
}