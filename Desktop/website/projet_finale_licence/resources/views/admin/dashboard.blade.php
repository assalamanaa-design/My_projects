@php use Illuminate\Support\Facades\Auth; @endphp

@extends('layouts.admin')

@section('title', 'Dashboard - Admin')

@section('content')
<div class="welcome-banner">
    <h1><font color= black > Welcome, <span> {{ Auth::user()->name }}!</span></h1>
    <p>{{ now()->format('l, d F Y') }}</p>
</div>

<div class="row mt-4">
    <div class="col-md-3">
        <div class="cardd">
            <h5>Total Patients</h5>
            <p><i class="fas fa-users"></i> {{ $totalPatients }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="cardd">
            <h5>Appointments Today</h5>
            <p><i class="fas fa-calendar-alt"></i> {{ $appointmentsToday }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="cardd">
            <h5>Tests en Cours</h5>
            <p><i class="fas fa-flask"></i> {{ $testsEnCours }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="cardd">
            <h5>Résultats Disponibles</h5>
            <p><i class="fas fa-check-circle"></i> {{ $resultatsDisponibles }}</p>
        </div>
    </div>
</div>
<div class="balance">
<h3 class="mt-4">Balance Overview</h3>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <h5>Savings</h5>
            <canvas id="savingsChart"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <h5>Monthly Expenses</h5>
            <canvas id="expensesChart"></canvas>
        </div>
    </div>
</div>
@endsection
