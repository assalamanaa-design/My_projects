@extends('layouts.patient')

@section('content')
<div class="profile-container">
    <!-- Header avec effet de verre -->
    <div class="profile-header glassmorphism">
        <div class="avatar-wrapper">
            <div class="profile-avatar pulse-animation">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M12 4a4 4 0 014 4a4 4 0 01-4 4a4 4 0 01-4-4a4 4 0 014-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4z"/>
                </svg>
            </div>
            <h1 class="profile-title">My Medical Profile</h1>
            <p class="profile-subtitle">Secure & Confidential</p>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="profile-content">
        <!-- Carte Informations Personnelles -->
        <div class="profile-card slide-in-left">
            <div class="card-header">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M12 3a4 4 0 014 4c0 1.95-1.4 3.58-3.25 3.93L8 15h2v2H6v-2h2l1-5H7a3 3 0 01-3-3c0-1.31.83-2.42 2-2.83V3.5A2.5 2.5 0 018.5 1c1.23 0 2.25.89 2.46 2.08A3.99 3.99 0 0112 3m7 9v2h-2v-2h2m0-4v6h-2V8h2m-5 11H7l-2 2v1h14v-1l-2-2z"/>
                    </svg>
                </div>
                <h2>Personal Details</h2>
            </div>
            <div class="card-body">
                <div class="info-item">
                    <span class="info-label">Full Name</span>
                    <span class="info-value">{{ $user->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email</span>
                    <span class="info-value highlight">{{ $user->email }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Phone</span>
                    <span class="info-value">{{ $patient->phone_number ?? 'Not provided' }}</span>
                </div>
            </div>
        </div>

        <!-- Carte Dossiers Médicaux -->
        <div class="profile-card slide-in-right">
            <div class="card-header">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 9h-2V7h2v5zm-1-6.5c-.55 0-1-.45-1-1s.45-1 1-1s1 .45 1 1s-.45 1-1 1z"/>
                    </svg>
                </div>
                <h2>Medical Records</h2>
            </div>
            <div class="card-body">
                <div class="info-item">
                    <span class="info-label">Date of Birth</span>
                    <span class="info-value">{{ $patient->birth_date ?? 'Not provided' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Gender</span>
                    <span class="info-value">{{ ucfirst($patient->gender) }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Blood Type</span>
                    <span class="info-value blood-type">{{ $patient->blood_type ?? 'Unknown' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Allergies</span>
                    <span class="info-value">{{ $patient->allergies ?? 'None recorded' }}</span>
                </div>
            </div>
        </div>

        <!-- Boutons d'action -->
        <div class="action-buttons fade-in">
            
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M20.71 7.04c.39-.39.39-1.04 0-1.41l-2.34-2.34c-.37-.39-1.02-.39-1.41 0l-1.84 1.83l3.75 3.75M3 17.25V21h3.75L17.81 9.93l-3.75-3.75L3 17.25z"/>
                </svg>
  Edit Profile
</button>
            
            <button class="btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM7 12h2v5H7zm4-7h2v12h-2zm4 5h2v7h-2z"/>
                </svg>
                <a href="{{ route('patient.scans') }}" >Medical History</a>
            </button>
        </div>
    </div>
</div>






<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header">
        <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form id="editProfileForm" method="POST" action="{{ route('patient.profile.update') }}">
      
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="birthDate" class="form-label">Birth Date</label>
            <input type="date" class="form-control" id="birthDate" name="birth_date" value="{{ old('birth_date', $patient->birth_date ?? '') }}">
          </div>
          
          <div class="mb-3">
            <label for="phoneNumber" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phoneNumber" name="phone_number" value="{{ old('phone_number', $patient->phone_number ?? '') }}">
          </div>
          
          <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select class="form-select" id="gender" name="gender">
              <option value="male" {{ (old('gender', $patient->gender ?? '') == 'male') ? 'selected' : '' }}>Male</option>
              <option value="female" {{ (old('gender', $patient->gender ?? '') == 'female') ? 'selected' : '' }}>Female</option>
            </select>
          </div>
          
          <div class="mb-3">
            <label for="bloodType" class="form-label">Blood Type</label>
            <select class="form-select" id="bloodType" name="blood_type">
              <option value="">Select</option>
              <option value="A+" {{ (old('blood_type', $patient->blood_type ?? '') == 'A+') ? 'selected' : '' }}>A+</option>
              <option value="A-" {{ (old('blood_type', $patient->blood_type ?? '') == 'A-') ? 'selected' : '' }}>A-</option>
              <option value="B+" {{ (old('blood_type', $patient->blood_type ?? '') == 'B+') ? 'selected' : '' }}>B+</option>
              <option value="B-" {{ (old('blood_type', $patient->blood_type ?? '') == 'B-') ? 'selected' : '' }}>B-</option>
              <option value="AB+" {{ (old('blood_type', $patient->blood_type ?? '') == 'AB+') ? 'selected' : '' }}>AB+</option>
              <option value="AB-" {{ (old('blood_type', $patient->blood_type ?? '') == 'AB-') ? 'selected' : '' }}>AB-</option>
              <option value="O+" {{ (old('blood_type', $patient->blood_type ?? '') == 'O+') ? 'selected' : '' }}>O+</option>
              <option value="O-" {{ (old('blood_type', $patient->blood_type ?? '') == 'O-') ? 'selected' : '' }}>O-</option>
            </select>
          </div>
          
          <div class="mb-3">
            <label for="allergies" class="form-label">Allergies</label>
            <textarea class="form-control" id="allergies" name="allergies" rows="3">{{ old('allergies', $patient->allergies ?? '') }}</textarea>
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</div>


<style>
    :root {
        --primary-color: #4361ee;
        --secondary-color: #3f37c9;
        --accent-color: #4895ef;
        --text-dark: #2b2d42;
        --text-light: #8d99ae;
        --bg-light: #f8f9fa;
        --glass-blur: blur(12px);
        --shadow-sm: 0 2px 8px rgba(0,0,0,0.08);
        --shadow-md: 0 4px 16px rgba(0,0,0,0.12);
        --shadow-lg: 0 8px 24px rgba(0,0,0,0.16);
        --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    /* Base Styles */
    body {
        background-color:rgb(253, 250, 250);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        color: var(--text-dark);
        line-height: 1.6;
    }

    .profile-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    /* Header Styles */
    .profile-header {
        background: linear-gradient(135deg, rgba(67, 97, 238, 0.9) 0%, rgba(63, 55, 201, 0.9) 100%);
        border-radius: 16px;
        padding: 3rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-md);
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
        transform: rotate(30deg);
    }

    .glassmorphism {
        backdrop-filter: var(--glass-blur);
        -webkit-backdrop-filter: var(--glass-blur);
        background-color: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .avatar-wrapper {
        text-align: center;
        position: relative;
        z-index: 2;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        margin: 0 auto 1.5rem;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--shadow-lg);
        border: 3px solid rgba(255, 255, 255, 0.3);
    }

    .profile-avatar svg {
        width: 60px;
        height: 60px;
        color: white;
    }

    .profile-title {
        color: white;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        letter-spacing: -0.5px;
    }

    .profile-subtitle {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.1rem;
        font-weight: 400;
    }

    /* Profile Content */
    .profile-content {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    @media (min-width: 768px) {
        .profile-content {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Profile Cards */
    .profile-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .profile-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-md);
        
    }

    .profile-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(to bottom, var(--primary-color), var(--accent-color));
    }

    .card-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background-color: rgba(67, 97, 238, 0.08); /* Fond bleu très clair */
        border-radius: 12px;
        margin-left: -1rem; /* Compensation du padding */
        margin-right: -1rem;
        margin-top: -1rem;
    }

    .card-header h2 {
        color: var(--primary-color); /* Texte en bleu */
        font-weight: 700;
        font-size: 1.4rem;
        margin: 0;
    }

    /* Adaptation de l'icône */
    .card-icon {
        width: 40px;
        height: 40px;
        background: rgba(67, 97, 238, 0.15);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
    }

    .card-icon svg {
        width: 20px;
        height: 20px;
        color: var(--primary-color);
    }

    .profile-card h2 {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 0;
        color: var(--text-dark);
    }

    .card-body {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .info-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .info-label {
        color: var(--text-light);
        font-weight: 500;
    }

    .info-value {
        font-weight: 600;
        text-align: right;
    }

    .highlight {
        color: var(--primary-color);
        font-weight: 700;
    }

    .blood-type {
        background: #ffebee;
        color: #c62828;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-weight: 700;
    }

    /* Action Buttons */
    .action-buttons {
        grid-column: 1 / -1;
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        margin-top: 1rem;
    }

    .btn-primary, .btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.875rem 1.75rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: var(--transition);
        border: none;
        box-shadow: var(--shadow-sm);
    }

    .btn-primary {
        background: var(--primary-color);
        color: white;
    }

    .btn-primary:hover {
        background: var(--secondary-color);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-secondary {
        background: white;
        color: var(--primary-color);
        border: 1px solid rgba(67, 97, 238, 0.3);
    }

    .btn-secondary:hover {
        background: rgba(67, 97, 238, 0.05);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-primary svg, .btn-secondary svg {
        width: 18px;
        height: 18px;
        margin-right: 8px;
    }

    /* Animations */
    .pulse-animation {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    .slide-in-left {
        animation: slideInLeft 0.6s ease-out;
    }

    .slide-in-right {
        animation: slideInRight 0.6s ease-out;
    }

    .fade-in {
        animation: fadeIn 0.8s ease-out;
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    /* Modal Styles */
.modal {
    backdrop-filter: blur(5px);
}

.modal-content {
    border: none;
    overflow: hidden;
}

.modal-header {
    background: linear-gradient(135deg, rgba(67, 97, 238, 0.1) 0%, rgba(63, 55, 201, 0.1) 100%);
    border-bottom: 1px solid rgba(67, 97, 238, 0.1);
    padding: 1.5rem;
}

.modal-title {
    color: var(--primary-color);
    font-weight: 700;
    font-size: 1.5rem;
}

.btn-close {
    filter: invert(0.5) sepia(1) saturate(5) hue-rotate(200deg);
}

.modal-body {
    padding: 2rem;
}

.modal-footer {
    border-top: 1px solid rgba(67, 97, 238, 0.1);
    padding: 1.5rem;
}

/* Form Styles */
.form-label {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.5rem;
    display: block;
}

.form-control, .form-select {
    padding: 0.75rem 1rem;
    border: 1px solid rgba(67, 97, 238, 0.2);
    border-radius: 10px;
    transition: var(--transition);
    background-color: rgba(67, 97, 238, 0.03);
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.15);
    background-color: white;
}

textarea.form-control {
    min-height: 100px;
}

/* Button Styles */
.btn-success {
    background-color: var(--primary-color);
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    transition: var(--transition);
}

.btn-success:hover {
    background-color: var(--secondary-color);
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}

.btn-secondary {
    background-color: white;
    color: var(--primary-color);
    border: 1px solid rgba(67, 97, 238, 0.3);
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    transition: var(--transition);
}

.btn-secondary:hover {
    background-color: rgba(67, 97, 238, 0.05);
    border-color: rgba(67, 97, 238, 0.5);
}

/* Responsive Adjustments */
@media (max-width: 576px) {
    .modal-body {
        padding: 1.5rem 1rem;
    }
    
    .modal-footer {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .modal-footer .btn {
        width: 100%;
    }
}
</style>
<script>




fetch('/patient/update-profile', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
  },
  body: JSON.stringify({
    birth_date: '2000-01-01',
    phone_number: '0600000000',
    // autres champs...
  })
})
.then(response => response.json())
.then(data => {
  alert(data.message);
})
.catch(error => {
  console.error('Error:', error);
});
</script>

@endsection