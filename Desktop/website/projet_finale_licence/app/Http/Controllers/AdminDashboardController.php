<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Appointment;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
public function index()
{
    $totalPatients = User::whereIn('type', ['patient', 'premium_patient'])->count();
    $appointmentsToday = Appointment::whereDate('date', Carbon::today())->count();
    $testsEnCours = Appointment::where('status', 'En cours')->count();
    $resultatsDisponibles = Appointment::where('status', 'Résultat disponible')->count();

    return view('admin.dashboard', compact(
        'totalPatients',
        'appointmentsToday',
        'testsEnCours',
        'resultatsDisponibles'
    ));


}}