@extends('layouts.patient')

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
            <button class="btn btn-consult">
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
</style>
@endsection

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
@endpush