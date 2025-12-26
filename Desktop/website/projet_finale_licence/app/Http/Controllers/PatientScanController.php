<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalScan;
use App\Models\ScanPayment;

class PatientScanController extends Controller
{
    public function showScans()
{
    $user = auth()->user();

    $scans = MedicalScan::where('patient_id', $user->id)->get();

    return view('patient.checkingscanresult', compact('scans'));
}

public function requestPremium()
{
    $user = auth()->user();

    ScanPayment::create([
        'user_id' => $user->id,
        'status' => 'pending'
    ]);

    return redirect()->back()->with('success', 'Your premium request has been sent!');
}


public function checkScanResult()
{
    $user = auth()->user();
    $patient = Patient::where('id', $user->id)->first();

    $scans = MedicalScan::where('patient_id', $patient->id)->get();
    $payment = ScanPayment::where('user_id', $user->id)->latest()->first();

    $paymentStatus = 'none'; // par défaut
    if ($payment) {
        if ($payment->status == 'pending') {
            $paymentStatus = 'pending';
        } elseif ($payment->status == 'accepted') {
            $paymentStatus = 'accepted';
        }
    }

    return view('patient.checkingscanresult', compact('scans', 'paymentStatus'));
}

}