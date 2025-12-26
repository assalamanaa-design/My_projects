@extends('layouts.premium')

@section('content')
<div class="container py-5">
    <!-- Header Section -->
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold text-gradient-primary">Premium Scan Analysis</h1>
        <p class="lead text-muted">Advanced medical imaging analysis powered by AI technology</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Upload Section -->
    
        <div class="card-body">
            @if($isUpgraded)
            <div class="ai-scan-container">
    <form id="ai-analysis-form" method="POST" action="{{ route('premium.scan.analyze') }}" enctype="multipart/form-data" class="ai-scan-form">
        @csrf
        <h2 class="form-title">Medical Scan Analysis</h2>
        <p class="form-subtitle">Upload your medical scan for AI-powered analysis</p>
        
        <div class="form-group">
            <label for="scan_type" class="form-label">Scan Type</label>
            <select name="scan_type" id="scan_type" class="form-select" required>
                <option value="">-- Choose Scan Type --</option>
                <option value="chest_xray">Chest X-Ray</option>
                <option value="ct_scan">CT Scan</option>
                <option value="mri">MRI</option>
            </select>
            
        </div>
        
        <div class="form-group file-upload-group">
            <label for="scan_image" class="file-upload-label">
                <div class="file-upload-box">
                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                    <span class="file-upload-text">Choose Scan Image</span>
                    <span class="file-upload-hint">JPEG, PNG (Max 5MB)</span>
                </div>
                <input type="file" name="scan_image" id="scan_image" accept="image/*" required class="file-upload-input">
            </label>
        </div>
        
        <button type="submit" class="analyze-button">
            <span class="button-text">AI Analysis</span>
            <i class="fas fa-microscope button-icon"></i>
        </button>
        
        <div class="form-footer">
            <p class="disclaimer">Our AI analysis provides preliminary results and should be reviewed by a medical professional.</p>
        </div>
    </form>
</div>
    
</form>
            @else
            <div class="card shadow-lg mb-5">
        <div class="card-header bg-white py-3">
        <h5 class="form-title">Medical Scan Analysis</h5>
        
        </div>
                <div class="upgrade-required text-center py-4">
                    <div class="icon-wrapper mb-3">
                        <i class="fas fa-lock fa-3x text-warning"></i>
                    </div>
                    <h5 class="mb-3">Premium Feature Locked</h5>
                    <p class="text-muted mb-4">Upgrade your account to access scan uploads and advanced AI analysis features</p>
                    <button class="btn btn-gradient-primary rounded-pill px-4 py-2" onclick="handleDoctorsClick()">
                    <i class="fas fa-crown me-2"></i> Upgrade Now
                    </button>
                </div>
                
            @endif
        </div>
    </div>



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
                    <p class="text-muted">Get a premium account for AI analysis</p>
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
                
                <form id="payForm" action="{{ route('premium.scan.requestUpgrade') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Your CCP Number</label>
                        <div class="input-group">
             
                        
                        <input type="text" name="ccp_number" class="form-control rounded-pill" placeholder="Enter your account number" required>
                    </div>
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
                    <button type="submit" class="btn btn-gradient-primary w-100 py-2">
                        <i class="fas fa-paper-plane me-2"></i>Submit Payment Request
                    </button>
                </form>
            </div>
        </div>
    </div>




    
    

    <!-- Doctors Modal -->
    @if($isUpgraded)
    <div id="doctorsModal" class="modal-overlay">
        <div class="modal-content animated fadeInUp">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title">Recommended Doctors</h5>
                <button type="button" class="btn-close btn-close-white" onclick="closeModal('doctorsModal')"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-info mb-4">
                    <i class="fas fa-info-circle me-2"></i>These specialists are best suited to analyze your medical scans.
                </div>
                
                <div class="doctors-list">
                    <div class="doctor-card p-3 mb-3 rounded d-flex align-items-center">
                        <div class="doctor-avatar me-3">
                            <img src="https://ui-avatars.com/api/?name=Sarah+Bensalah&background=6f42c1&color=fff" class="rounded-circle" width="60" alt="Dr. Sarah">
                        </div>
                        <div class="doctor-info flex-grow-1">
                            <h6 class="mb-1">Dr. Sarah Bensalah</h6>
                            <p class="text-muted small mb-1">Pneumologist - 12 years experience</p>
                            <div class="rating small text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span class="text-muted ms-2">4.7 (86 reviews)</span>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-outline-primary rounded-pill">Contact</button>
                    </div>
                    
                    <div class="doctor-card p-3 mb-3 rounded d-flex align-items-center">
                        <div class="doctor-avatar me-3">
                            <img src="https://ui-avatars.com/api/?name=Karim+Meddour&background=6f42c1&color=fff" class="rounded-circle" width="60" alt="Dr. Karim">
                        </div>
                        <div class="doctor-info flex-grow-1">
                            <h6 class="mb-1">Dr. Karim Meddour</h6>
                            <p class="text-muted small mb-1">Radiologist - 15 years experience</p>
                            <div class="rating small text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <span class="text-muted ms-2">5.0 (124 reviews)</span>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-outline-primary rounded-pill">Contact</button>
                    </div>
                    
                    <div class="doctor-card p-3 rounded d-flex align-items-center">
                        <div class="doctor-avatar me-3">
                            <img src="https://ui-avatars.com/api/?name=Lynda+Amrani&background=6f42c1&color=fff" class="rounded-circle" width="60" alt="Dr. Lynda">
                        </div>
                        <div class="doctor-info flex-grow-1">
                            <h6 class="mb-1">Dr. Lynda Amrani</h6>
                            <p class="text-muted small mb-1">General Practitioner - 8 years experience</p>
                            <div class="rating small text-warning">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="far fa-star"></i>
                                <span class="text-muted ms-2">4.1 (67 reviews)</span>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-outline-primary rounded-pill">Contact</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
    function handleDoctorsClick() {
        @if(!$isUpgraded)
            document.getElementById('paymentForm').style.display = 'flex';
        @else
            document.getElementById('doctorsModal').style.display = 'flex';
        @endif
    }

    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    // Close modal when clicking outside
    document.querySelectorAll('.modal-overlay').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) modal.style.display = 'none';
        });
    });

    // Close modal with ESC key
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            document.querySelectorAll('.modal-overlay').forEach(modal => {
                modal.style.display = 'none';
            });
        }
    });


</script>

<style>
    /* Base Styles */
    body {
        background-color: #f8f9fa;
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


    .text-gradient-primary {
        background: #0078FF;
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(45deg, #6f42c1, #b07dfb) !important;
    }
    
    .btn-gradient-primary {
        background: linear-gradient(45deg, #6f42c1, #b07dfb);
        border: none;
        color: white;
        transition: all 0.3s ease;
    }
    
    .btn-gradient-primary:hover {
        background: linear-gradient(45deg, #5e36b1, #9c6cf7);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(111, 66, 193, 0.3);
        color: white;
    }
    
    /* Card Styles */
    .card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
    }
    
    .feature-card {
        transition: all 0.3s ease;
    }
    
    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
    
    /* Form Styles */
    .form-floating label {
        color: #6c757d;
    }
    
    .form-control:focus {
        border-color: #b07dfb;
        box-shadow: 0 0 0 0.25rem rgba(176, 125, 251, 0.25);
    }
    
    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        display: none;
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
    
    .premium-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(45deg, #6f42c1, #b07dfb);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }
    
    /* Doctor Cards */
    .doctor-card {
        transition: all 0.3s ease;
        border: 1px solid #eee;
    }
    
    .doctor-card:hover {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }
    
    /* Animations */
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
        .modal-content {
            width: 95%;
        }
        
        .display-5 {
            font-size: 2.5rem;
        }
    }
 















/* Styles spécifiques pour le formulaire AI Scan */
.ai-scan-container {
    padding: 0;
    min-height: auto;
    background: transparent;
}

.ai-scan-form {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    padding: 2rem;
    width: 100%;
    transition: all 0.3s ease;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.form-title {
    color: #2c3e50;
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
    text-align: center;
    font-weight: 600;
}

.form-subtitle {
    color: #7f8c8d;
    font-size: 0.9rem;
    text-align: center;
    margin-bottom: 1.5rem;
}

/* Form group styles */
.form-group {
    margin-bottom: 1.5rem;
    position: relative;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    color: #5a6a7e;
    font-weight: 500;
    font-size: 0.85rem;
}

.form-select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #e0e6ed;
    border-radius: 8px;
    background-color: #f8fafc;
    appearance: none;
    font-size: 0.9rem;
    color: #2c3e50;
    transition: all 0.3s;
    cursor: pointer;
}

.form-select:focus {
    outline: none;
    border-color: #6f42c1;
    box-shadow: 0 0 0 3px rgba(111, 66, 193, 0.1);
}

.select-icon {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #7f8c8d;
    pointer-events: none;
    font-size: 0.8rem;
}

/* File upload styles */
.file-upload-group {
    margin: 1.5rem 0;
}

.file-upload-label {
    display: block;
    cursor: pointer;
}

.file-upload-box {
    border: 2px dashed #d8e0ea;
    border-radius: 8px;
    padding: 2rem 1rem;
    text-align: center;
    transition: all 0.3s;
    background-color: #f8fafc;
}

.file-upload-label:hover .file-upload-box {
    border-color: #0078ff;
    background-color: #f5f0ff;
}

.upload-icon {
    font-size: 1.75rem;
    color: #0078ff;
    margin-bottom: 0.5rem;
}

.file-upload-text {
    display: block;
    font-weight: 500;
    color: #3c4d62;
    margin-bottom: 0.3rem;
    font-size: 0.95rem;
}

.file-upload-hint {
    font-size: 0.75rem;
    color: #95a1b5;
}

.file-upload-input {
    display: none;
}

/* Button styles */
.analyze-button {
    width: 100%;
    padding: 0.85rem;
    background: #0078ff;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 0.95rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
    margin-top: 0.5rem;
}

.analyze-button:hover {
    background: #0078ff;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(111, 66, 193, 0.2);
}

.button-icon {
    font-size: 0.9rem;
}

/* Footer styles */
.form-footer {
    margin-top: 1.5rem;
    text-align: center;
}

.disclaimer {
    font-size: 0.7rem;
    color: #95a5a6;
    line-height: 1.4;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .ai-scan-form {
        padding: 1.5rem;
    }
    
    .form-title {
        font-size: 1.3rem;
    }
    
    .file-upload-box {
        padding: 1.5rem 1rem;
    }
}

@media (max-width: 576px) {
    .ai-scan-form {
        padding: 1.25rem;
    }
    
    .form-title {
        font-size: 1.2rem;
    }
    
    .form-subtitle {
        font-size: 0.85rem;
    }
    
    .file-upload-box {
        padding: 1.25rem 0.75rem;
    }
    
    .analyze-button {
        padding: 0.75rem;
        font-size: 0.9rem;
    }
}
</style>
@endsection