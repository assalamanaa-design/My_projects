<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController; // Ajout de l'import du contrôleur Patient
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PremiumPatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PatientDashboardController;
use App\Http\Controllers\PatientProfileController;
use App\Http\Controllers\PremiumDashboardController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\PremiumRequestController;
use App\Http\Controllers\PatientScanController;


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/premium/dashboard', [PremiumPatientController::class, 'show'])->name('premium.dashboard');
Route::delete('/premium/delete', [PremiumPatientController::class, 'destroy'])->name('premium.delete');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('index'); // redirection vers l'accueil
})->name('logout');

Route::get('/', function () {
    return view('index'); // Laravel cherchera le fichier 'index.blade.php' dans 'resources/views'
})->name('index');


Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');


Route::get('/admin/list', [PatientController::class, 'index'])->name('admin.patients');
Route::get('/admin/list/{id}', [PatientController::class, 'show'])->name('admin.patients.show');
Route::put('/admin/list/{id}', [PatientController::class, 'update'])->name('admin.patients.update');
Route::delete('/admin/list/{id}/delete', [PatientController::class, 'destroy'])->name('admin.patients.delete');
Route::post('/admin/list', [PatientController::class, 'store'])->name('admin.patients.store');


Route::get('/patient/booking', [BookingController::class, 'create'])->name('patient.booking');
Route::post('/patient/booking', [BookingController::class, 'store'])->name('booking.store');

Route::get('/premium/booking', [BookingController::class, 'create'])->name('premium.booking');
Route::post('/premium/booking', [BookingController::class, 'store'])->name('booking.store');

Route::get('/admin/appointments', [App\Http\Controllers\AppointmentController::class, 'index'])->name('admin.appointments');
Route::post('/appointments/{id}/status/{status}', [AppointmentController::class, 'updateStatus'])
    ->name('appointments.updateStatus');




    Route::delete('/premium/dashboardd/{id}', [AppointmentController::class, 'destroy'])->name('premium.cancel.appointment');

Route::put('/premium/dashboardd/{id}', [AppointmentController::class, 'update'])->name('premium.update.appointment');

// Patient routes


Route::delete('/patient/dashboardd/{id}', [AppointmentController::class, 'destroy'])->name('patient.cancel.appointment');

Route::put('/patient/dashboardd/{id}', [AppointmentController::class, 'update'])->name('patient.update.appointment');







Route::middleware(['auth'])->group(function () {
    Route::get('/patient/help', [SupportController::class, 'help'])->name('patient.help');
    Route::post('/patient/help/send', [SupportController::class, 'send'])->name('help.send');
    Route::get('/premium/help', [SupportController::class, 'help'])->name('premium.help');
    Route::post('/premium/help/send', [SupportController::class, 'send'])->name('help.send');

});

Route::get('/admin/inquiries', [AdminController::class, 'inquiries'])->name('admin.inquiries');
Route::post('/admin/messages/{id}/resolve', [SupportController::class, 'resolveMessage'])->name('admin.messages.resolve');
Route::post('/admin/messages/{id}/reply', [SupportController::class, 'replyToMessage'])->name('admin.messages.reply');
Route::post('/admin/messages/reply/{id}', [SupportController::class, 'replyToMessage'])->name('admin.reply.message');
Route::post('/admin/messages/resolve/{id}', [SupportController::class, 'markAsResolved'])->name('admin.resolve.message');


Route::post('/admin/post/upload', [ScanController::class, 'store'])->name('scans.store');
Route::get('/admin/post', [ScanController::class, 'create'])->name('scans.create');

Route::middleware(['auth'])->group(function () {
    Route::get('/patient/profile', [PatientProfileController::class, 'show'])->name('patient.profile');
    Route::post('/patient/profile/update', [PatientProfileController::class, 'updateProfile'])->name('patient.profile.update');
});

    

    Route::middleware(['auth'])->group(function () {
        Route::get('/patient/dashboard', [PatientDashboardController::class, 'index'])->name('patient.dashboard');
        Route::get('/premium/dashboarddd', [PremiumDashboardController::class, 'index'])->name('premium.dashboard');
    });
    





    // Patient
Route::get('/patient/checkingscanresult', [ScanController::class, 'showScans'])->name('checkingscanresult');
Route::post('/patient/request-premium', [ScanController::class, 'requestPremium'])->name('request.premium');

// Admin
Route::get('/admin/checking_premium', [AdminController::class, 'viewPremiumRequests'])->name('checking_premium');
Route::post('/admin/accept-premium/{id}', [AdminController::class, 'acceptPremium'])->name('admin.accept.premium');
Route::post('/admin/reject-premium/{id}', [AdminController::class, 'rejectPremium'])->name('admin.reject.premium');






Route::middleware(['auth'])->group(function () {
    // Patient Routes

    Route::get('/patient/checkingscanresult', [ScanController::class, 'showScanResult'])->name('patient.scans');
    Route::post('/patient/request-upgrade', [ScanController::class, 'requestUpgrade'])->name('patient.requestUpgrade');

    Route::post('/patient/analyze', [ScanController::class, 'analyzeScan'])->name('scan.analyze');
    Route::get('/patient/scanresult', function () {
        return view('patient.scanresult');
    })->name('patient.scanresult');
    
Route::get('/patient/{id}/download-report', [PatientController::class, 'downloadReport'])->name('patient.downloadReport');
    

        // ✅ Nouvelle route pour upload de scan
        Route::post('/patient/upload-scan', [ScanController::class, 'uploadScan'])->name('upload.scan');

    // Admin Routes
    Route::get('/admin/checking_upgrade', [AdminController::class, 'showUpgradeRequests'])->name('admin.upgrades');
    Route::post('/admin/upgrade/accept/{id}', [AdminController::class, 'acceptUpgrade'])->name('admin.upgrade.accept');
    Route::post('/admin/upgrade/refuse/{id}', [AdminController::class, 'refuseUpgrade'])->name('admin.upgrade.refuse');
   
    


    Route::get('/premium/scananalysis', [ScanController::class, 'showScanAnalysis'])->name('premium.scananalysis');
Route::post('/premium/upload-scan', [ScanController::class, 'UploaddScan'])->name('premium.UploaddScan');
Route::post('/premium/request-upgrade', [ScanController::class, 'requestUpgrade'])->name('premium.requestUpgrade');
Route::post('/premium/request-upgrade-scan', [ScanController::class, 'requestUpgradeFromScanAnalysis'])->name('premium.scan.requestUpgrade');

Route::get('/premium/scananalysis', [ScanController::class, 'showScanAnalysis'])->name('scan.analysis');

Route::post('/premium/scanresult', [ScanController::class, 'analyzeScanpremium'])->name('premium.scan.analyze');

});


Route::middleware(['auth'])->group(function () {
    Route::get('/admin/premium-patients', [AdminController::class, 'showPremiumPatients'])->name('admin.premium.patients');
    Route::post('/admin/upgrade-patient/{id}', [AdminController::class, 'upgradePremiumToPatient'])->name('admin.upgrade.patient');
});



