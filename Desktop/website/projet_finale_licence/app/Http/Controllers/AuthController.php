<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\PremiumPatient;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validation des champs du formulaire
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Récupérer l'utilisateur par son email
        $user = User::where('email', $request->email)->first();

        // Vérification du mot de passe
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            // Redirection en fonction du rôle
            if ($user->type == 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->type == 'premium_patient') {
                return redirect()->route('premium.dashboard');
            } else {
                return redirect()->route('patient.dashboard');
            }
        }

        // Si la connexion échoue, retourner un message d'erreur
        return back()->withErrors(['email' => 'Email ou mot de passe incorrect.']);
    }

    // Fonction pour afficher la page de connexion
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Déconnexion de l'utilisateur
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Vous avez été déconnecté.');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Inscription (seul le type "premium_patient" est autorisé ici)
    public function register(Request $request)
{
    // Validation des champs
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|confirmed',
        // ajoute ici les autres champs de premium_patient si besoin
    ]);

    // Création dans la table users
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'type' => 'premium_patient', // type premium_patient
    ]);

    // Création dans premium_patients via la relation définie
    $user->premiumPatient()->create([
        'user_id' => $user->id,  // Associe le user_id
    ]);

    // Connexion et redirection
    Auth::login($user);

    return redirect()->route('login.form')->with('success', 'Inscription réussie ! Connectez-vous.');
}
}
