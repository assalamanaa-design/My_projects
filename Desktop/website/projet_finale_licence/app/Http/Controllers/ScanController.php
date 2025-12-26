<?php
namespace App\Http\Controllers;

use App\Models\MedicalScan;
use App\Models\ScanPayment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\PremiumPatientController;
use Illuminate\Support\Facades\Storage;
use App\Models\Patient;
use App\Models\PremiumPatient;

class ScanController extends Controller
{

    public function create()
    {
        $patients = Patient::with('user')->get(); // pour afficher les noms

    return view('admin.post', compact('patients'));
    }

    public function store(Request $request)
{
    $request->validate([
        'scan_type' => 'required',
        'scan_date' => 'required|date',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'result' => 'nullable|string',
        'patient_id' => 'required|exists:patients,id',
    ]);

    $path = $request->file('image')->store('scans', 'public');

    MedicalScan::create([
        'patient_id' => $request->patient_id,
        'scan_type' => $request->scan_type,
        'scan_date' => $request->scan_date,
        'image_path' => $path,
        'result' => $request->result,
    ]);

    return redirect()->back()->with('success', 'Scan enregistré avec succès !');
}


    // Afficher la carte de paiement (suggest doctor)
    public function showPaymentCard()
    {
        return view('patient.payment_card');
    }

    // Demande de paiement pour le compte premium
    public function requestPayment(Request $request)
    {
        $user = auth()->user();

        // Créer un enregistrement pour la demande de paiement
        ScanPayment::create([
            'user_id' => $user->id,
            'ccp_number' => $request->ccp_number,
            'status' => 'pending'
        ]);

        return response()->json(['message' => 'Payment requested']);
    }


public function showScanResult()
{
    $user = auth()->user();
    $scans = MedicalScan::where('patient_id', $user->id)->get();

    $isUpgraded = ScanPayment::where('user_id', $user->id)
        ->where('status', 'accepted')
        ->exists();

    return view('patient.checkingscanresult', compact('scans', 'isUpgraded'));
}

public function requestUpgrade(Request $request)
{
    $request->validate([
        'ccp_number' => 'required|string|max:30',
        'amount' => 'required|numeric|min:1'
    ]);
   

    ScanPayment::create([
        'user_id' => auth()->id(),
        'ccp_number' => $request->ccp_number,
        'status' => 'pending',
    ]);

    return response()->json(['success' => true]);
}


public function uploadScan(Request $request)
{
    // Validation des données
    $request->validate([
        'scan_file' => 'required|mimes:jpeg,png,jpg,pdf|max:2048',
        'scan_type' => 'required|string|max:255',
        'scan_date' => 'required|date',
    ]);

    // Récupération du fichier
    $scanFile = $request->file('scan_file');
    $scanPath = $scanFile->store('scans', 'public');

    // Sauvegarde du scan dans la base de données
    $scan = new MedicalScan();
    $scan->patient_id = Auth::id();  // Ou le patient connecté
    $scan->scan_type = $request->scan_type;
    $scan->scan_date = $request->scan_date;
    $scan->image_path = $scanPath;
    $scan->result = 'Pending'; // Par exemple, 'Pending' avant d'être analysé
    $scan->save();

    // Retourner une réponse
    return back()->with('success', 'Scan uploaded successfully');
}


public function showScanAnalysis()
{
    $userId = auth()->id();

    // Vérifie si l'utilisateur a une demande acceptée
    $isUpgraded = ScanPayment::where('user_id', $userId)
                             ->where('status', 'accepted')
                             ->exists();

    return view('premium.scananalysis', compact('isUpgraded'));
}




public function requestUpgradeFromScanAnalysis(Request $request)
{
    $existingRequest = ScanPayment::where('user_id', Auth::id())->where('status', 'pending')->first();

    if ($existingRequest) {
        return back()->with('error', 'Une demande est déjà en cours.');
    }

    ScanPayment::create([
        'user_id' => auth()->id(),
        'ccp_number' => $request->ccp_number,
        'status' => 'pending',
    ]);
    
    return back()->with('success', 'Demande envoyée. Attendez la validation de l\'admin.');
}



public function UploaddScan(Request $request)
{
    $request->validate([
        'scan_type' => 'required|string|max:100',
        'scan_date' => 'required|date',
        'scan_file' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // 1. Upload du fichier
    if ($request->hasFile('scan_file')) {
        $image = $request->file('scan_file');
        $path = $image->store('scans', 'public'); // le fichier sera stocké dans storage/app/public/scans
    } else {
        return back()->with('error', 'Scan file is missing.');
    }

    // 2. Création du scan
    $scan = new MedicalScan();
    $scan->scan_type = $request->scan_type;
    $scan->scan_date = $request->scan_date;
    $scan->image_path = $path;
    $scan->result = 'Pending';

    // 3. Vérification de l'existence du patient ou du premium_patient
    if (auth()->user()->type === 'premium_patient') {
        $premium = \App\Models\PremiumPatient::where('user_id', auth()->id())->first();
        if ($premium) {
            $scan->premium_id = $premium->id;
        } else {
            return back()->with('error', 'Aucun patient premium trouvé.');
        }
    } else {
        $patient = \App\Models\Patient::where('user_id', auth()->id())->first();
        if ($patient) {
            $scan->patient_id = $patient->id;
        } else {
            return back()->with('error', 'Aucun patient trouvé.');
        }
    }

    // 4. Sauvegarde du scan
    $scan->save();

    return redirect()->route('premim.scananalysis')->with('success', 'Scan uploaded successfully!');
}

public function showScanAnalysisPage()
{
    $userId = auth()->id(); // utilisateur connecté

    $premiumPatient = PremiumPatient::where('user_id', $userId)->first();

    // Vérifie si la demande de paiement a été acceptée
    $isUpgraded = false;

    if ($premiumPatient) {
        $upgrade = ScanPayment::where('premium_patient_id', $premiumPatient->id)
            ->where('status', 'accepted')
            ->latest()
            ->first();

        $isUpgraded = $upgrade ? true : false;

        // Récupération des scans uniquement si upgrade validé
        $scans = $isUpgraded
            ? MedicalScan::where('patient_id', $premiumPatient->patient_id)->get()
            : collect(); // Collection vide sinon
    } else {
        $scans = collect();
    }

    return view('premium.scananalysis', [
        'isUpgraded' => $isUpgraded,
        'scans' => $scans,
    ]);
}







public function analyzeScan(Request $request)
{
    // Vérifie si l'image vient de la base de données
    if ($request->has('scan_image_from_db')) {
        $relativePath = $request->input('scan_image_from_db');
        $absolutePath = storage_path('app/public/' . $relativePath);

        if (!file_exists($absolutePath)) {
            return back()->with('error', 'Image not found.');
        }

        $imageContents = file_get_contents($absolutePath);
        $imageName = basename($absolutePath);
    } else {
        // Sinon : upload depuis formulaire
        $request->validate([
            'scan_image' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        $image = $request->file('scan_image');
        $imageContents = file_get_contents($image);
        $imageName = $image->getClientOriginalName();
    }

    // Envoi à Flask
    $response = Http::attach('file', $imageContents, $imageName)
        ->post('http://127.0.0.1:5000/predict');

    if ($response->successful()) {
        $result = $response->json();
        return view('patient.scanresult', ['result' => $result]);
    } else {
        return back()->with('error', 'Erreur lors de l’analyse de l’image.');
    }
}



public function analyzeScanpremium(Request $request)
{
    // Si l'utilisateur sélectionne une image existante depuis la base de données
    if ($request->has('scan_image_from_db')) {
        $relativePath = $request->input('scan_image_from_db');
        $absolutePath = storage_path('app/public/' . $relativePath);

        if (!file_exists($absolutePath)) {
            return back()->with('error', 'Image introuvable.');
        }

        $imageContents = file_get_contents($absolutePath);
        $imageName = basename($absolutePath);
    } 
    // Sinon, upload manuel par formulaire
    else {
        $request->validate([
            'scan_image' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        $image = $request->file('scan_image');
        $imageContents = file_get_contents($image);
        $imageName = $image->getClientOriginalName();
    }

    // Envoi de l'image au serveur Flask pour prédiction
    try {
        $response = Http::attach('file', $imageContents, $imageName)
            ->post('http://127.0.0.1:5000/predict');

        if ($response->successful()) {
            $result = $response->json();

            return view('premium.scanresult', [
                'result' => $result,
                'image_path' => isset($relativePath) ? asset('storage/' . $relativePath) : null,
            ]);
        } else {
            return back()->with('error', 'Erreur lors de l’analyse de l’image.');
        }
    } catch (\Exception $e) {
        return back()->with('error', 'Erreur de communication avec le serveur IA : ' . $e->getMessage());
    }
}

}


