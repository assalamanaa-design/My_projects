@extends('layouts.patient')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h2 class="text-primary fw-bold">Your Medical Scans</h2>
        @if(!$scans->isEmpty())
        <div class="badge bg-primary rounded-pill px-3 py-2">
            <i class="fas fa-images me-2"></i>{{ $scans->count() }} Scan(s)
        </div>
        @endif
    </div>

    @if ($isUpgraded)
    <div class="upload-section mb-5 p-4 bg-light rounded-3 shadow-sm">
        <h4 class="mb-4 text-primary"><i class="fas fa-cloud-upload-alt me-2"></i>Upload New Scan</h4>
        <form action="{{ route('upload.scan') }}" method="POST" enctype="multipart/form-data" class="row g-3">
            @csrf
            <div class="col-md-6">
                <label for="scan_type" class="form-label">Scan Type</label>
                <input type="text" id="scan_type" name="scan_type" class="form-control" placeholder="e.g. X-Ray, MRI, CT Scan" required>
            </div>

            <div class="col-md-6">
                <label for="scan_date" class="form-label">Scan Date</label>
                <input type="date" id="scan_date" name="scan_date" class="form-control" required>
            </div>

            <div class="col-12">
                <label for="scan_file" class="form-label">Scan File</label>
                <div class="input-group">
                    <input type="file" id="scan_file" name="scan_file" class="form-control" required>
                    <button class="btn btn-primary" type="button" id="file-upload-btn">
                        <i class="fas fa-folder-open me-2"></i>Browse
                    </button>
                </div>
                <div class="form-text">Accepted formats: JPG, PNG, PDF (Max 5MB)</div>
            </div>

            <div class="col-12 mt-2">
                <button type="submit" class="btn btn-primary px-4 py-2">
                    <i class="fas fa-upload me-2"></i>Upload Scan
                </button>
            </div>
        </form>
    </div>
    @else
    <div class="text-center mb-5">
        <button class="btn btn-warning rounded-pill px-4 py-2 upload-btn" onclick="showPaymentForm()">
            </i>👑 Upgrade to Upload Scans
        </button>
    </div>
    @endif




    @if ($scans->isEmpty())

        <div class="empty-state text-center py-5">
            <div class="empty-state-icon">
                <i class="fas fa-folder-open fa-4x text-muted"></i>
            </div>
            <h3 class="mt-4 text-muted">No scans available</h3>
            <p class="text-muted">Your results will appear here when available</p>
        </div>
        
    @else
    <div class="row g-4">
    @foreach ($scans as $scan)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="scan-card card border-0 h-100 shadow-sm">
                <!-- Image Container -->
                <div class="card-img-container position-relative">
                    <img src="{{ asset('storage/' . $scan->image_path) }}" 
                         class="card-img-top scan-image" 
                         alt="{{ $scan->scan_type }} Scan"
                         style="height: 200px; object-fit: cover;">


                    
                    <!-- Image Overlay Buttons -->
                    <div class="card-img-overlay d-flex align-items-center justify-content-center flex-column gap-2">
                        
                        <form action="{{ route('scan.analyze') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- إذا كان عندك scan محفوظ فالداتاباز وكتحمل الصورة منه -->
    <input type="hidden" name="scan_image_from_db" value="{{ $scan->image_path }}">

    <button type=submit class="btn btn-primary rounded-pill px-4 scan-action-btn">
                            <i class="fas fa-robot me-2"></i> AI Analysis</button>
</form>
                        <a href="{{ asset('storage/' . $scan->image_path) }}" 
                           download 
                           class="btn btn-info rounded-pill px-4 download-scan-btn">
                            <i class="fas fa-download me-2"></i> Download
                        </a>
                    </div>
                </div>
                
                <!-- Card Body with Scan Info -->
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title text-primary mb-0">
                            <i class="fas fa-tag me-2"></i>{{ $scan->scan_type }}
                        </h5>
                        <span class="badge bg-light text-dark">
                            <i class="far fa-calendar-alt me-1"></i>
                            {{ \Carbon\Carbon::parse($scan->scan_date)->format('d/m/Y') }}
                        </span>
                    </div>
                   
                </div>
                
                <!-- Card Footer -->
                <div class="card-footer bg-white border-0 text-center py-3">
                    @if ($isUpgraded)
                        <button class="btn btn-success rounded-pill px-4 doctor-suggest-btn" 
                                onclick="showDoctors()">
                            <i class="fas fa-user-md me-2"></i> Recommended Doctors
                        </button>
                    @else
                        <button class="btn btn-warning rounded-pill px-4 upgrade-btn" 
                                onclick="showPaymentForm()">
                            </i>👑 Upgrade to Suggest Doctors
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- Notes Modal (place outside the loop) -->
<div class="modal fade" id="notesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Scan Notes</h5>
                <button type="button" class="btn-close btn-close-white" 
                        data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="fullNotesContent"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" 
                        data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
    @endif

   <!-- Payment Modal -->
    <!-- Payment Modal -->
    <div id="paymentForm" class="modal-overlay" style="display:none;">
        <div class="modal-content ">
            <div class="modal-header bg-primary text-white" style="background: linear-gradient(45deg, #6f42c1, #b07dfb);">
                <h5 class="modal-title">Upgrade to Premium</h5>
                <button type="button" class="btn-close btn-close-white" onclick="closeModal('paymentForm')"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                <div class="crown"style="font-size: 3rem;">👑</div>
                    <h4 class="mt-3">Premium Access</h4>
                    <p class="text-muted">Get recommendations from specialized doctors</p>
                </div>
                
                <div class="payment-details p-3 mb-4 rounded" style="background-color: #f8f9fa;">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Lab Account Number:</span>
                        <strong class="text-primary">0123456789</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Amount:</span>
                        <strong class="text-success">2,000 DZD</strong>
                    </div>
                </div>
                
                <form id="payForm">
                    <div class="mb-3">
                        <label class="form-label">Your Account Number</label>
                        <input type="text" name="ccp_number" class="form-control rounded-pill" placeholder="Enter your account number" required>
                    </div>
                    <div class="mb-3">
                    <label class="form-label">Experies</label>
        <div class="input-group">
        <input type="text" name="expires" class="form-control rounded-pill" placeholder="MM/YY" required>
    </div>
    </div>
    <div class="mb-3">
        <label class="form-label">CVV</label>
        <div class="input-group">
        <input type="text" name="cvv" class="form-control rounded-pill" placeholder="Security code" maxlength="4" required>
    </div>
    </div>
                    <div class="mb-4">
                        <label class="form-label">Amount</label>
                        <div class="input-group">
                            <input type="number" name="amount" value="2000" class="form-control rounded-pill" required>
                            <span class="input-group-text rounded-pill">DZD</span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2">
                        <i class="fas fa-paper-plane me-2"></i>Submit Request
                    </button>
                </form>
            </div>
        </div>
    </div>

   <!-- Doctors List Modal -->
<div id="doctorList" class="modal-overlay" style="display:none;">
    <div class="modal-content animated fadeInUp">
        <div class="modal-header" style="background-color: #0078FF; color: white;">
            <h5 class="modal-title">Recommended Doctors</h5>
            <button type="button" class="btn-close btn-close-white" onclick="closeModal('doctorList')"></button>
        </div>
        <div class="modal-body p-4">
            <div class="alert alert-info mb-4">
                <i class="fas fa-info-circle me-2"></i>These doctors specialize in analyzing this type of medical imaging.
            </div>
            
            <div class="doctors-list">
                <!-- Doctor 1 -->
                <div class="doctor-card p-3 mb-3 rounded d-flex align-items-center">
                    <div class="doctor-avatar me-3">
                        <img src="https://ui-avatars.com/api/?name=Amina+Boudia&background=random" class="rounded-circle" width="50" alt="Dr. Amina">
                    </div>
                    <div class="doctor-info flex-grow-1">
                        <h6 class="mb-1">Dr. Amina Boudia</h6>
                        <p class="text-muted small mb-1">Pulmonologist - 15 years experience</p>
                        <div class="rating small text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span class="text-muted ms-2">4.7 (128 reviews)</span>
                        </div>
                    </div>
                    <div class="position-relative">
                        <button class="btn btn-sm btn-outline-success rounded-pill">Contact</button>
                        <div class="contact-tooltip">
                            <p><strong>Clinic Address:</strong> 123 Medical Center Blvd, Suite 405, Algiers</p>
                            <p><strong>Phone:</strong> +213 123 456 789</p>
                        </div>
                    </div>
                </div>
                
                <!-- Doctor 2 -->
                <div class="doctor-card p-3 mb-3 rounded d-flex align-items-center">
                    <div class="doctor-avatar me-3">
                        <img src="https://ui-avatars.com/api/?name=Karim+Ziani&background=random" class="rounded-circle" width="50" alt="Dr. Karim">
                    </div>
                    <div class="doctor-info flex-grow-1">
                        <h6 class="mb-1">Dr. Karim Ziani</h6>
                        <p class="text-muted small mb-1">Radiologist - Department Head</p>
                        <div class="rating small text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span class="text-muted ms-2">5.0 (89 reviews)</span>
                        </div>
                    </div>
                    <div class="position-relative">
                        <button class="btn btn-sm btn-outline-success rounded-pill">Contact</button>
                        <div class="contact-tooltip">
                            <p><strong>Clinic Address:</strong> 456 Imaging Center, 3rd Floor, Oran</p>
                            <p><strong>Phone:</strong> +213 987 654 321</p>
                        </div>
                    </div>
                </div>
                
                <!-- Doctor 3 -->
                <div class="doctor-card p-3 rounded d-flex align-items-center">
                    <div class="doctor-avatar me-3">
                        <img src="https://ui-avatars.com/api/?name=Leila+Messaoud&background=random" class="rounded-circle" width="50" alt="Dr. Leila">
                    </div>
                    <div class="doctor-info flex-grow-1">
                        <h6 class="mb-1">Dr. Leila Messaoud</h6>
                        <p class="text-muted small mb-1">Medical Imaging Specialist</p>
                        <div class="rating small text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                            <span class="text-muted ms-2">4.2 (64 reviews)</span>
                        </div>
                    </div>
                    <div class="position-relative">
                        <button class="btn btn-sm btn-outline-success rounded-pill">Contact</button>
                        <div class="contact-tooltip">
                            <p><strong>Clinic Address:</strong> 789 Health Plaza, Radiology Dept, Constantine</p>
                            <p><strong>Phone:</strong> +213 555 123 456</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<style>
/* Main Styles */
.empty-state {
    max-width: 500px;
    margin: 0 auto;
}

.empty-state-icon {
    opacity: 0.5;
}

.scan-card {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.scan-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
}

.scan-image {
    height: 250px;
    object-fit: cover;
    border-bottom: 1px solid #eee;
}

.card-img-container {
    overflow: hidden;
}

.card-img-overlay {
    background: rgba(0, 0, 0, 0.3);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.card-img-container:hover .card-img-overlay {
    opacity: 1;
}

.scan-action-btn, .doctor-suggest-btn, .upgrade-btn {
    transition: all 0.3s ease;
    font-weight: 500;
}

.scan-action-btn {
    transform: scale(0.9);
}

.card-img-container:hover .scan-action-btn {
    transform: scale(1);
}

/* Modal Styles */

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1050;
    backdrop-filter: blur(5px);
}

.modal-content {
    background-color: #fff;
    border-radius: 15px;
    width: 90%;
    max-width: 500px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

/* Ajouter à votre section style */
.modal-content {
    max-height: 90vh;
    margin: 2rem auto;
    display: flex;
    flex-direction: column;
}

.modal-body {
    overflow-y: auto;
    flex-grow: 1;
}

.rounded-pill {
    padding: 0.5rem 1rem;
}

@media (max-width: 576px) {
    .modal-content {
        width: 95%;
        margin: 1rem auto;
    }
    
    .form-control {
        padding: 0.375rem 0.75rem;
    }
}


.premium-icon {
    width: 80px;
    height: 80px;
}

.doctor-card {
    transition: all 0.3s ease;
    border: 1px solid #eee;
}

.doctor-card:hover {
    background-color: #f8f9fa;
    border-color: #dee2e6;
}

.animated {
    animation-duration: 0.4s;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fadeInUp {
    animation-name: fadeInUp;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .scan-card {
        margin-bottom: 20px;
    }
    
    .modal-content {
        width: 95%;
    }
}


/* Style pour la modal de paiement */
.modal-content {
    border: none;
    box-shadow: 0 10px 30px rgba(111, 66, 193, 0.2);
}
#payForm button{
    background: linear-gradient(45deg, #5e36b1, #9c6cf7) !important;
}
/* Animation du dégradé au survol du bouton */
#payForm button:hover {
    background: linear-gradient(45deg, #5e36b1, #9c6cf7) !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(111, 66, 193, 0.3);
    transition: all 0.3s ease;
}

/* Style pour les icônes */
.premium-icon {
    box-shadow: 0 4px 10px rgba(111, 66, 193, 0.3);
}

/* Style pour les champs de formulaire */
.form-control:focus {
    border-color: #b07dfb;
    box-shadow: 0 0 0 0.25rem rgba(176, 125, 251, 0.25);
}


.upload-btn {
    background: linear-gradient(45deg, #5e36b1, #9c6cf7) !important 
}

.doctor-suggest-btn{
    background-color: #0078FF ;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 10px;
    transition: background 0.3s ease; 
}
.doctor-suggest-btn:hover{
    background-color: #0b5ed7; /* Bleu plus foncé au survol */
    border-color: #0a58ca;
}

.upload-btn {
    background: linear-gradient(45deg,rgb(43, 137, 224), #b07dfb);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 10px;
    transition: background 0.3s ease; 
}

.upgrade-btn {
    background: linear-gradient(45deg, #6f42c1, #b07dfb);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 10px;
    transition: background 0.3s ease;
}


 /* Ajoutez ce style supplémentaire */
 .download-scan-btn {
        transition: all 0.3s ease;
        transform: scale(0.9);
        opacity: 0;
        background-color: #17a2b8;
        border: none;
        color: white;
    }

    .card-img-container:hover .download-scan-btn {
        transform: scale(1);
        opacity: 1;
    }

    /* Animation pour le bouton de téléchargement */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .card-img-container:hover .download-scan-btn {
        animation: fadeIn 0.3s ease-out forwards;
        animation-delay: 0.1s;
    }




    /* Updated Upload Section Styles */
.upload-section {
    border-left: 4px solid #0d6efd;
    background: linear-gradient(to right, #f8f9fa, #fff);
}

.upload-section h4 {
    position: relative;
    padding-bottom: 10px;
}

.upload-section h4::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 50px;
    height: 3px;
    background: #0d6efd;
}

#file-upload-btn {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}

/* Improved Upload Button */
.upload-btn {
    background: linear-gradient(45deg, #ffc107, #ff9800);
    color: white;
    border: none;
    box-shadow: 0 4px 15px rgba(255, 152, 0, 0.3);
    transition: all 0.3s ease;
    font-weight: 500;
    letter-spacing: 0.5px;
}

.upload-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 152, 0, 0.4);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .upload-section {
        padding: 20px;
    }
    
    .d-flex.justify-content-between.align-items-center.mb-5 {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .badge {
        margin-top: 10px;
    }
}













.contact-tooltip {
        display: none;
        position: absolute;
        bottom: 100%;
        right: 0;
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px;
        width: 250px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        z-index: 100;
    }
    
    .position-relative:hover .contact-tooltip {
        display: block;
    }
    
    .contact-tooltip p {
        margin-bottom: 5px;
        font-size: 13px;
    }
    
    .contact-tooltip p:last-child {
        margin-bottom: 0;
    }

</style>

<script>
function showPaymentForm() {
    document.getElementById('paymentForm').style.display = 'flex';
}

function showDoctors() {
    document.getElementById('doctorList').style.display = 'flex';
}

function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}

document.getElementById('payForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Envoi en cours...';
    submitBtn.disabled = true;

    const formData = new FormData(this);

    fetch("{{ route('patient.requestUpgrade') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(async res => {
        const data = await res.json();
        if (res.ok) {
            return data;
        }
        throw data;
    })
    .then(data => {
        if (data.success) {
            // Show success message with SweetAlert or similar
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: 'Votre demande a été envoyée avec succès!',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            }).then(() => {
                closeModal('paymentForm');
                // Optionally refresh the page or update UI
                setTimeout(() => location.reload(), 1000);
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        let errorMessage = 'Une erreur est survenue';
        if (error.errors) {
            errorMessage = Object.values(error.errors).join('<br>');
        } else if (error.message) {
            errorMessage = error.message;
        }
        
        Swal.fire({
            icon: 'error',
            title: 'Erreur',
            html: errorMessage,
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK'
        });
    })
    .finally(() => {
        submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Envoyer la Demande';
        submitBtn.disabled = false;
    });
});

// Add animation when modal is shown
['paymentForm', 'doctorList'].forEach(id => {
    const modal = document.getElementById(id);
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal(id);
            }
        });
    }
});
document.getElementById('payForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
    submitBtn.disabled = true;

    const formData = new FormData(this);

    fetch("{{ route('patient.requestUpgrade') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(async res => {
        const data = await res.json();
        if (res.ok) {
            return data;
        }
        throw data;
    })
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Your request has been submitted successfully!',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            }).then(() => {
                closeModal('paymentForm');
                setTimeout(() => location.reload(), 1000);
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        let errorMessage = 'An error occurred';
        if (error.errors) {
            errorMessage = Object.values(error.errors).join('<br>');
        } else if (error.message) {
            errorMessage = error.message;
        }
        
        Swal.fire({
            icon: 'error',
            title: 'Error',
            html: errorMessage,
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK'
        });
    })
    .finally(() => {
        submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Submit Request';
        submitBtn.disabled = false;
    });
});















    function showPaymentForm() {
        document.getElementById('paymentForm').style.display = 'flex';
    }

    function showDoctors() {
        document.getElementById('doctorList').style.display = 'flex';
    }

    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    // Optional: Close modal on ESC or click outside
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            document.querySelectorAll('.modal-overlay').forEach(modal => modal.style.display = 'none');
        }
    });

    document.querySelectorAll('.modal-overlay').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) modal.style.display = 'none';
        });
    });


</script>
@endsection











