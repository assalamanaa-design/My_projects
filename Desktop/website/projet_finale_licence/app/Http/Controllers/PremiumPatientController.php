<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PremiumPatient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PremiumPatientController extends Controller
{




    public function register(Request $request)
{
    // Validation des données
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:100',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6|confirmed',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Création de l'utilisateur premium
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'type' => 'premium_patient',
    ]);

    // Création de l'entrée dans la table premium_patients
    PremiumPatient::create([
        'user_id' => $user->id, // Lien avec l'utilisateur
    ]);

    // Connexion automatique après inscription
    auth()->login($user);

    return redirect()->route('premium.dashboard');
}

public function show()
{
    $user = Auth::user();

    // تقدر تبعث داتا للواجهة اذا حبيت
    return view('premium.dashboarddd', compact('user'));
}

}
