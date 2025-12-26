<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;

class PatientProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $patient = Patient::where('id', $user->id)->first();

        return view('patient.profile', compact('user', 'patient'));
    }
    
    


    public function updateProfile(Request $request)
{
    $user = auth()->user();
    $patient = $user->patient;

    $request->validate([
        'birth_date' => 'nullable|date',
        'phone_number' => 'nullable|string|max:20',
        'gender' => 'nullable|in:male,female',
        'blood_type' => 'nullable|string|max:3',
        'allergies' => 'nullable|string|max:255',
    ]);

    if ($patient) {
        $patient->update([
            'birth_date' => $request->birth_date,
            'phone_number' => $request->phone_number,
            'gender' => $request->gender,
            'blood_type' => $request->blood_type,
            'allergies' => $request->allergies,
        ]);

        return redirect()->route('patient.profile')->with('success', 'Profile updated successfully.');

    }

    return response()->json(['error' => 'Patient not found'], 404);
}


}
