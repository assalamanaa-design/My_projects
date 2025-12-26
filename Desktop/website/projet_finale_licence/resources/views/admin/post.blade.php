
@extends('layouts.admin')

@section('content')
<div class="scan-upload-container">
    <div class="scan-upload-header">
        <h2><i class="fas fa-file-medical-alt"></i> New Medical Scan</h2>
        <p class="subtitle">Upload medical imaging results</p>
    </div>

    <form action="{{ route('scans.store') }}" method="POST" enctype="multipart/form-data" class="scan-upload-form">
        @csrf

        <div class="form-row">
            <div class="form-group">
                <label for="scan_type">
                    <i class="fas fa-tag"></i> Scan Type
                </label>
                <select name="scan_type" class="form-control" required>
                    <option value="">Select...</option>
                    <option value="MRI">MRI</option>
                    <option value="CT Scan">CT Scan</option>
                    <option value="Ultrasound">Ultrasound</option>
                    <option value="X-Ray">X-Ray</option>
                    <option value="Mammography">Mammography</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="scan_date">
                    <i class="fas fa-calendar-alt"></i> Scan Date
                </label>
                <input type="date" name="scan_date" class="form-control" required>
            </div>
        </div>

        <div class="form-group file-upload-container">
            <label for="image">
                <i class="fas fa-file-upload"></i> Scan File
            </label>
            <div class="file-upload-wrapper">
                <input type="file" name="image" id="image" class="file-upload-input" required>
                <label for="image" class="file-upload-label">
                    <span class="file-upload-text">Choose a file</span>
                    <span class="file-upload-button"><i class="fas fa-cloud-upload-alt"></i> Browse</span>
                </label>
                <div class="file-upload-preview" id="filePreview">
                    <i class="fas fa-file-medical"></i>
                    <span>No file selected</span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="result">
                <i class="fas fa-file-alt"></i> Notes (optional)
            </label>
            <textarea name="result" class="form-control" rows="4" placeholder="Add any observations about this scan..."></textarea>
        </div>

        <div class="form-group">
            <label for="patient_id">
                <i class="fas fa-user-injured"></i> Patient
            </label>
            <select name="patient_id" class="form-control select2" required>
                <option value="">-- Select a patient --</option>
                @foreach ($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->user->name }} (ID: {{ $patient->id }})</option>
                @endforeach
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-upload">
                <i class="fas fa-upload"></i> Upload Scan
            </button>
        </div>
    </form>
</div>

<style>
/* Base Styles */
.scan-upload-container {
    max-width: 800px;
    margin: 30px auto;
    padding: 40px;
    border-radius: 16px;
    background: white;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    font-family: 'Segoe UI', 'Roboto', sans-serif;
}

.scan-upload-header {
    text-align: center;
    margin-bottom: 40px;
    color: #2c3e50;
}

.scan-upload-header h2 {
    font-size: 35px;
    font-weight: 700;
    margin-bottom: 8px;
    color: #3498db;
}

.scan-upload-header .subtitle {
    font-size: 16px;
    color: #7f8c8d;
    margin-bottom: 0;
}

/* Form Layout */
.scan-upload-form {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.form-row {
    display: flex;
    gap: 20px;
}

.form-row .form-group {
    flex: 1;
}

/* Form Elements */
.form-group {
    margin-bottom: 0;
}

label {
    display: block;
    margin-bottom: 10px;
    font-weight: 500;
    color: #34495e;
    font-size: 15px;
}

label i {
    margin-right: 8px;
    color: #3498db;
}

.form-control {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    font-size: 15px;
    transition: all 0.3s;
    background-color: #f9f9f9;
}

.form-control:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
    background-color: white;
}

select.form-control {
    appearance: none;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 15px center;
    background-size: 15px;
}

textarea.form-control {
    min-height: 120px;
    resize: vertical;
}

/* File Upload Styling */
.file-upload-container {
    margin-top: 10px;
}

.file-upload-wrapper {
    position: relative;
}

.file-upload-input {
    position: absolute;
    left: 0;
    top: 0;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

.file-upload-label {
    display: block;
}

.file-upload-text {
    display: block;
    margin-bottom: 8px;
    font-size: 14px;
    color: #7f8c8d;
}

.file-upload-button {
    display: inline-block;
    padding: 10px 15px;
    background-color: #e1f0fa;
    color: #2980b9;
    border-radius: 6px;
    font-weight: 500;
    transition: all 0.2s;
}

.file-upload-button:hover {
    background-color: #d0e6f7;
}

.file-upload-preview {
    margin-top: 15px;
    padding: 15px;
    border: 1px dashed #e0e0e0;
    border-radius: 8px;
    text-align: center;
    background-color: #f9f9f9;
    color: #7f8c8d;
    font-size: 14px;
}

.file-upload-preview i {
    font-size: 24px;
    display: block;
    margin-bottom: 10px;
    color: #3498db;
}

/* Button Styling */
.btn-upload {
    width: 100%;
    padding: 14px;
    background-color: #3498db;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.btn-upload:hover {
    background-color: #2980b9;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
}

.btn-upload:active {
    transform: translateY(0);
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .form-row {
        flex-direction: column;
        gap: 25px;
    }
    
    .scan-upload-container {
        padding: 30px 20px;
        margin: 20px;
    }
}

/* Select2 Customization */
.select2-container .select2-selection--single {
    height: 46px;
    border: 1px solid #e0e0e0 !important;
    border-radius: 8px !important;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 46px !important;
    padding-left: 15px !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 44px !important;
}
</style>

<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- Include Select2 for better select elements -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        placeholder: "-- Select a patient --",
        allowClear: true
    });

    // File upload preview
    $('#image').change(function() {
        const file = this.files[0];
        const preview = $('#filePreview');
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                if (file.type.startsWith('image/')) {
                    preview.html(`<img src="${e.target.result}" class="img-preview" style="max-width: 100%; max-height: 200px; border-radius: 4px; margin-bottom: 10px;"><div>${file.name}</div>`);
                } else {
                    preview.html(`<i class="fas fa-file-medical" style="font-size: 24px; margin-bottom: 10px; color: #3498db;"></i><div>${file.name}</div>`);
                }
            }
            
            reader.readAsDataURL(file);
        } else {
            preview.html('<i class="fas fa-file-medical"></i><span>No file selected</span>');
        }
    });

    // Form submission feedback
    $('.scan-upload-form').on('submit', function() {
        $('.btn-upload').html('<i class="fas fa-spinner fa-spin"></i> Uploading...');
        $('.btn-upload').prop('disabled', true);
    });
});
</script>
@endsection