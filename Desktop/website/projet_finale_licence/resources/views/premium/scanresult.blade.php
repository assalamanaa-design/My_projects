@extends('layouts.premium')

@section('content')
<div class="container patient-results-container">
    <h2><i class="fas fa-flask"></i> AI Analysis Results</h2>
    
    @if (isset($result['label']))
        <div class="result-card">
            <div class="result-header">
                <i class="fas fa-microscope"></i>
                <span>AI-Assisted Diagnosis</span>
            </div>
            <div class="result-body">
                <div class="result-item">
                    <span class="result-label">Result:</span>
                    <span class="result-value">{{ $result['label'] }}</span>
                </div>
                
                <div class="result-item">
                    <span class="result-label">Confidence Level:</span>
                    <span class="result-value">{{ number_format($result['confidence'] * 100, 2) }}%</span>
                </div>
                
                <div class="confidence-meter">
                    <div class="confidence-level" style="width: {{ $result['confidence'] * 100 }}%"></div>
                </div>
            </div>
        </div>
        
        <div class="action-buttons">
    <button class="btn btn-suggest rounded-pill px-4" onclick="showDoctors()">
        <i class="fas fa-user-md"></i> Suggest Doctors
    </button>
    <button class="btn btn-download rounded-pill px-4">
        <i class="fas fa-download"></i> Download Report
    </button>
</div>
       
    @else
        <div class="result-card no-result-card">
            <div class="result-body">
                <div class="result-item">
                    <span class="result-label">No Results Available</span>
                    <p>We couldn't retrieve results for your analysis. Please contact technical support.</p>
                </div>
            </div>
        </div>
    @endif
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
/* resources/css/patient-results.css */

.patient-results-container {
    max-width: 800px;
    margin: 40px auto;
    padding: 30px;
    background-color: #f8fafc;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
}

.patient-results-container h2 {
    color: #2b6cb0;
    font-weight: 600;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 1px solid #e2e8f0;
    font-size: 28px;
}

.result-card {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    border: none;
    transition: transform 0.3s ease;
}

.result-card:hover {
    transform: translateY(-3px);
}

.result-header {
    background-color: #4299e1;
    color: white;
    padding: 15px 20px;
    font-weight: 500;
    display: flex;
    align-items: center;
}

.result-header i {
    margin-right: 10px;
    font-size: 20px;
}

.result-body {
    padding: 25px;
    background-color: white;
}

.result-item {
    margin-bottom: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.result-label {
    font-weight: 600;
    color: #4a5568;
    font-size: 16px;
}

.result-value {
    font-weight: 500;
    color: #2d3748;
    font-size: 16px;
}

.confidence-meter {
    height: 8px;
    background-color: #ebf8ff;
    border-radius: 4px;
    margin-top: 5px;
    overflow: hidden;
}

.confidence-level {
    height: 100%;
    background: linear-gradient(90deg, #63b3ed, #3182ce);
    border-radius: 4px;
}

.no-result-card {
    background-color: #fff5f5;
    border-left: 4px solid #fc8181;
}

.action-buttons {
    margin-top: 30px;
    display: flex;
    justify-content: flex-end;
}

.btn-download, .btn-consult {
    padding: 10px 20px;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-download {
    background-color: #e2e8f0;
    color: #2d3748;
    border: 1px solid #cbd5e0;
}

.btn-download:hover {
    background-color: #cbd5e0;
}

.btn-consult {
    background-color: #4299e1;
    color: white;
}

.btn-consult:hover {
    background-color: #3182ce;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .patient-results-container {
        margin: 20px;
        padding: 20px;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 10px;
    }
    
    .btn-consult {
        margin-left: 0;
        width: 100%;
    }
}



.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 1050;
}

.modal-content {
    background-color: white;
    border-radius: 10px;
    width: 600px;
    max-width: 95%;
    max-height: 90vh;
    overflow-y: auto;
}

.modal-header {
    padding: 15px 20px;
    border-bottom: 1px solid #dee2e6;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-body {
    padding: 20px;
}

.btn-close-white {
    color: white;
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
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







    .action-buttons {
    margin-top: 30px;
    display: flex;
    justify-content: space-between; /* Changé de flex-end à space-between */
    gap: 15px; /* Espace entre les boutons */
}

.btn-download {
    background-color: #4299e1;
    color: white;
    border: 1px solid #4299e1;
    padding: 10px 20px;
    border-radius: 50px; /* rounded-pill */
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-download:hover {
    background-color: #3182ce;
    border-color: #3182ce;
}

.btn-suggest {
    background-color: white;
    color: #4299e1;
    border: 1px solid #4299e1;
    padding: 10px 20px;
    border-radius: 50px; /* rounded-pill */
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-suggest:hover {
    background-color: #f8fafc;
    color: #3182ce;
    border-color: #3182ce;
}

/* Pour les petits écrans */
@media (max-width: 768px) {
    .action-buttons {
        flex-direction: column;
    }
    
    .btn-download, .btn-suggest {
        width: 100%;
    }
}

</style>
<script>
function showDoctors() {
    document.getElementById('doctorList').style.display = 'flex';
}

function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}

// Close modal on ESC key
document.addEventListener('keydown', function(event) {
    if (event.key === "Escape") {
        document.querySelectorAll('.modal-overlay').forEach(modal => {
            modal.style.display = 'none';
        });
    }
});

// Close modal when clicking outside
document.querySelectorAll('.modal-overlay').forEach(modal => {
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal(modal.id);
        }
    });
});
</script>
@endsection

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
@endpush