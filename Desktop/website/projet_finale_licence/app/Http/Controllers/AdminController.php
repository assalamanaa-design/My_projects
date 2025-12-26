<?php


namespace App\Http\Controllers;
use App\Models\Message; //
use App\Models\ScanPayment; 
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\PremiumPatient;



class AdminController extends Controller
{
    public function index()
    {
        return view ('admin.dashboard'); // Charge la vue du dashboard admin
    }
    public function inquiries()
{
    $messages = Message::with('user')->latest()->get();

    return view('admin.inquiries', compact('messages'));
}


public function showPatientsForUpgrade()
{
    $patients = ScanPayment::where('status', 'pending')->get();
    return view('admin.checking_upgrade', compact('patients'));
}

// Accepter ou refuser un patient premium
public function updatePatientStatus($id, $status)
{
    $payment = ScanPayment::find($id);
    $payment->status = $status;
    $payment->save();

    // Si accepté, mettez à jour le statut du patient
    if ($status == 'accepted') {
        $user = User::find($payment->user_id);
        $user->type = 'premium_patient';
        $user->save();
    }

    return redirect()->route('admin.checking_upgrade');
}


public function showUpgradeRequests()
{
    $requests = ScanPayment::where('status', 'pending')->with('user')->get();
    return view('admin.checking_upgrade', compact('requests'));
}

public function acceptUpgrade($id)
{
    $request = ScanPayment::findOrFail($id);
    $request->status = 'accepted';
    $request->save();
    return back()->with('success', 'Patient accepté.');
}

public function refuseUpgrade($id)
{
    $request = ScanPayment::findOrFail($id);
    $request->status = 'rejected';
    $request->save();
    return back()->with('error', 'Patient refusé.');
}







public function showPremiumPatients()
{
    

    $premiumPatients = PremiumPatient::whereHas('user', function ($query) {
        $query->where('type', 'premium_patient');
    })->with('user')->get();

    return view('admin.premium-patients', compact('premiumPatients'));
}



public function upgradePremiumToPatient($id)
{
    $premium = PremiumPatient::where('user_id', $id)->first();
    if (!$premium) {
        return response()->json(['success' => false, 'message' => 'Patient premium introuvable.']);
    }

    // Changer le type du user
    $user = User::find($id);
    $user->type = 'patient';
    $user->save();

    // Créer un patient (remplir les valeurs par défaut ici)
    Patient::create([
        'id' => $user->id,
        'birth_date' => now(), // Valeur temporaire
        'phone_number' => null,
        'gender' => null,
        'blood_type' => null,
        'allergies' => null,
    ]);

    // Supprimer l'entrée premium
    $premium->delete();
    ScanPayment::where('user_id', $user->id)->delete();
    // Ajouter un enregistrement ScanPayment avec statut 'pending'
    ScanPayment::create([
        'user_id' => $user->id,
        'ccp_number' => '00000000', // valeur temporaire (à modifier plus tard par le patient)
        'status' => 'rejected',
    ]);

    return response()->json(['success' => true]);
}
}

