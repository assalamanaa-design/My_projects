@extends('layouts.premium')

@section('content')
<div class="booking-form">
    <h2>Book an Appointment</h2>
    <form action="{{ route('booking.store') }}" method="post">
        @csrf
        <div class="row">
        <div class="col-lg-6 col-12">
            <input type="text" name="name" id="name" class="form-control" placeholder="Full Name" required>
        </div>


            <div class="col-lg-6 col-12">
    <div class="datepicker-container">
        <input type="text" name="date" id="date" class="form-control datepicker" placeholder="Select Date" readonly required>
        <i class="fa fa-calendar calendar-icon"></i>
    </div>
</div>

            <div class="col-lg-6 col-12">
                <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone Number" required>
            </div>

            <div class="col-lg-6 col-12">
                <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
            </div>

            <div class="col-12">
                <textarea class="form-control" rows="5" id="message" name="message" placeholder="Additional Message"></textarea>
            </div>

            <div class="col-lg-3 col-md-4 col-6 mx-auto">
                <button type="submit" class="form-control">Book Now</button>
            </div>
        </div>
    </form>
   

</div>
<style>

/* Main Container */
.booking-form {
    max-width: 800px;
    margin: 40px auto;
    padding: 40px;
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    border: 1px solid #e0e6ed;
}

/* Title Styling with Animation */
.booking-form h2 {
    position: relative;
    color: #2c3e50;
    font-size: 32px;
    font-weight: 600;
    margin-bottom: 40px;
    text-align: center;
    padding-bottom: 15px;
}

.booking-form h2::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, #3490dc, #5a67d8);
    border-radius: 2px;
    transition: width 0.3s ease;
}

.booking-form h2:hover::after {
    width: 150px;
}

/* Form Elements */
.booking-form .form-control {
    height: 50px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    padding: 10px 15px;
    font-size: 16px;
    transition: all 0.3s ease;
    margin-bottom: 20px;
}

.booking-form .form-control:focus {
    border-color: #3490dc;
    box-shadow: 0 0 0 3px rgba(52, 144, 220, 0.2);
}

/* Date Picker Container */
.datepicker-container {
    position: relative;
}

.calendar-icon {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #718096;
    pointer-events: none;
}

/* Textarea Styling */
.booking-form textarea.form-control {
    height: 150px;
    resize: none;
}

/* Submit Button */
.booking-form button[type="submit"] {
    background: linear-gradient(135deg, #3490dc 0%, #5a67d8 100%);
    color: white;
    border: none;
    padding: 15px 30px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 16px;
    box-shadow: 0 4px 15px rgba(52, 144, 220, 0.3);
    width: 100%;
    margin-top: 10px;
}

.booking-form button[type="submit"]:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(52, 144, 220, 0.4);
    background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
}

.booking-form button[type="submit"]:active {
    transform: translateY(0);
}

/* Success Message */
.alert-success {
    background-color: #f0fff4;
    color: #2f855a;
    border-left: 4px solid #48bb78;
    padding: 15px;
    border-radius: 4px;
    margin-top: 20px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .booking-form {
        padding: 30px 20px;
        margin: 20px;
    }
    
    .booking-form h2 {
        font-size: 26px;
    }
    
    .booking-form .row > div {
        padding-left: 5px;
        padding-right: 5px;
    }
}

/* Animation for Form Elements */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.booking-form .form-control, 
.booking-form textarea,
.booking-form button {
    animation: fadeIn 0.5s ease forwards;
}

.booking-form .col-lg-6:nth-child(1) .form-control { animation-delay: 0.1s; }
.booking-form .col-lg-6:nth-child(2) .form-control { animation-delay: 0.2s; }
.booking-form .col-lg-6:nth-child(3) .form-control { animation-delay: 0.3s; }
.booking-form .col-lg-6:nth-child(4) .form-control { animation-delay: 0.4s; }
.booking-form textarea { animation-delay: 0.5s; }
.booking-form button { animation-delay: 0.6s; }

.booking-form button[type="submit"]::before {
    transform: scaleY(0);
    transform-origin: bottom;
}

.booking-form button:hover {
    color: #0078;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialisation du datepicker
    flatpickr("#date", {
        dateFormat: "Y-m-d",
        minDate: "today",
        disable: [
            function(date) {
                // Désactiver les weekends (samedi et dimanche)
                return (date.getDay() === 0 || date.getDay() === 6);
            }
        ],
        locale: {
            firstDayOfWeek: 1 // Commence la semaine par lundi
        }
    });
});
</script>
  
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@endsection

@push('styles')
    <!-- Lien vers ton fichier CSS -->
    <link href="{{ asset('css/booking.css') }}" rel="stylesheet">

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endpush
@push('scripts')
    <script src="{{ asset('js/booking.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush
