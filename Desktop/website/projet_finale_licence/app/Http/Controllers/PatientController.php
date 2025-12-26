<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Appointment;
use Barryvdh\DomPDF\Facade as PDF; 


class PatientController extends Controller
{
    // Afficher la liste des patients
    public function index()
    {
        $patients = User::where('type', 'patient')->with('patient')->get(); 
        return view('admin.list', compact('patients'));
    }

    public function show($id)
    {
        $patient = User::where('id', $id)->with('patient')->first();

        if (!$patient) {
            return response()->json(['error' => 'Patient non trouvé'], 404);
        }

        return response()->json($patient);
    }



    public function edit($id)
    {
        // Récupère l'utilisateur avec ses informations de patient associées
        $patient = User::with('patient')->find($id);
    
        // Si l'utilisateur n'est pas trouvé, retourne une erreur
        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }
    
        // Retourne les données du patient sous format JSON
        return response()->json([
            'id' => $patient->id,
            'name' => $patient->name,
            'email' => $patient->email,
            'phone_number' => $patient->patient->phone_number ?? null,
            'birth_date' => $patient->patient->birth_date ?? null,
            'gender' => $patient->patient->gender ?? null,
            'blood_type' => $patient->patient->blood_type ?? null,
            'allergies' => $patient->patient->allergies ?? null
        ]);
    }
    

public function updatePatient(Request $request)
{
    $request->validate([
        'id' => 'required|integer',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone_number' => 'nullable|string|max:20',
        'birth_date' => 'nullable|date',
        'gender' => 'nullable|string|max:10',
        'blood_type' => 'nullable|string|max:5',
        'allergies' => 'nullable|string|max:255',
    ]);

    // Vérifier si l'utilisateur existe
    $user = User::find($request->id);
    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    // Mettre à jour les infos de l'utilisateur
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

    // Vérifier si le patient existe avant de l'update
    $patient = Patient::where('user_id', $request->id)->first();
    if ($patient) {
        $patient->update([
            'phone_number' => $request->phone_number,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'blood_type' => $request->blood_type,
            'allergies' => $request->allergies,
        ]);
    } else {
        return response()->json(['error' => 'Patient not found'], 404);
    }

    return response()->json(['success' => 'Patient updated successfully']);
}

    

    // Supprimer un patient
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.patients')->with('success', 'Patient supprimé avec succès !');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required',
            'birth_date' => 'required|date',
            'gender' => 'required',
            'blood_type' => 'required',
            'allergies' => 'nullable|string',
        ]);
    
        $password = Str::random(8); // Génère un mot de passe aléatoire
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($password),
            'type' => 'patient',
        ]);
    
        $user->patient()->create([
            'phone_number' => $request->phone_number,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'blood_type' => $request->blood_type,
            'allergies' => $request->allergies,
        ]);
    
         // Envoi de l'email
        return redirect()->route('admin.patients')->with('success', "Patient créé avec succès. Mot de passe : $password");
    }
    


    public function requestScanPremium(Request $request)
{
    $user = auth()->user();

    ScanPayment::create([
        'user_id' => $user->id,
        'status' => 'pending'
    ]);

    return response()->json(['message' => 'Request sent']);
}

public function canAccessPremiumFeatures()
{
    $user = auth()->user();
    $payment = ScanPayment::where('user_id', $user->id)
        ->where('status', 'accepted')
        ->first();

    return response()->json(['access' => $payment ? true : false]);
}








public function downloadReport($patientId)
{
    // Récupérer les informations du patient (ou utiliser des données existantes)
    $patient = Patient::find($patientId);
    $result = $this->getAnalysisResult($patient);  // Une méthode pour récupérer les résultats

    // Générer le PDF
    $pdf = PDF::loadView('reports.patient_report', compact('patient', 'result'));

    // Retourner le PDF en téléchargement
    return $pdf->download('rapport_patient_' . $patient->name . '.pdf');
}







}

