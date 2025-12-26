@extends('layouts.premium')

@section('content')
<div class="laboratory-dashboard">
    <!-- Header Section -->
    <div class="container">
        <h1 class="dashboardd-title">Patient Dashboard</h1>

        <!-- Section Informations du patient -->
        <div class="cardd patient-info">
            <div class="cardd-body">
                <h2>Welcome, <span class="patient-name">{{ Auth::user()->name ?? 'Premium Patient' }}</span></h2>
                <p>{{ Auth::user()->email }}</p>
                <p> {{ Auth::user()->patient->phone_number ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Main Dashboard Grid -->
    <div class="dashboard-grid">
        
        <!-- Results Card -->
        <div class="dashboard-card results-card">
            <div class="card-header">
                <i class="fas fa-file-medical"></i>
                <h3>Résultats d'Analyses</h3>
            </div>
            <div class="card-body">
                <div class="results-list">
                    <!-- Exemple Result 1 -->
                    <div class="result-item">
                        <div class="result-type">Analyse sanguine</div>
                        <div class="result-date">10/04/2024</div>
                        <div class="result-actions">
                            <a href="#" class="btn-view-result">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="#" class="btn-download-result">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </div>
                    <!-- Exemple Result 2 -->
                    <div class="result-item">
                        <div class="result-type">Radiographie thorax</div>
                        <div class="result-date">05/04/2024</div>
                        <div class="result-actions">
                            <a href="#" class="btn-view-result">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="#" class="btn-download-result">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <a href="#" class="btn-view-all">Voir tous les résultats</a>
            </div>
        </div>

        <!-- Appointments Card -->
        <div class="dashboard-card appointment-card">
            <div class="card-header">
                <i class="fas fa-calendar-alt"></i>
                <h3>Appointments</h3>
            </div>
            <div class="card-body">
                <div class="next-appointment">
                    <h4>Next Appointment</h4>
                    @isset($nextAppointment)
                        @if($nextAppointment)
                            <p class="appointment-date">{{ $nextAppointment->date }}</p>


                           <div class="appointment-actions">
    <!-- Edit button triggers modal -->
    <button type="button" class="btn-edit" data-toggle="modal" data-target="#editAppointmentModal">
        <i class="fas fa-edit"></i> Edit
    </button>

    <!-- Cancel form -->
    <form action="{{ route('premium.cancel.appointment', $nextAppointment->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-cancel" onclick="return confirm('Are you sure you want to cancel this appointment?')">
            <i class="fas fa-times"></i> Cancel
        </button>
    </form>
</div>

<!-- Status badge -->
<span class="appointment-status-badge {{ strtolower($nextAppointment->status) }}">
    {{ ucfirst($nextAppointment->status) ?? 'Pending' }}
</span>

                            @if ($nextAppointment)
    
    
@else
    <span>No appointment</span>
    <button class="btn-view-details">Booking Now</button>

@endif


                            
                        @else
                            <p class="appointment-date">No appointment</p>
                            <p class="appointment-status">-</p>
                            <button class="btn-view-details">Booking Now</button>

                        @endif
                    @else
                        <p class="appointment-date">No Appointment</p>
                        <p class="appointment-status">-</p>
                        <button class="btn-view-details">Booking Now</button>

                    @endisset
                    
                </div>
            </div>
        </div>


        



        <!-- Messages Card -->
        <div class="dashboard-card messages-card">
            <div class="card-header">
                <i class="fas fa-envelope"></i>
                <h3>Messages</h3>
            </div>
            <div class="card-body">
                <div class="messages-list">
                    @if(isset($messages) && $messages->count() > 0)
                        @foreach($messages as $message)
                            <div class="message-item unread">
                                <div class="message-preview">{{ \Illuminate\Support\Str::limit($message->admin_reply, 50) }}</div>
                                <div class="message-date">{{ \Carbon\Carbon::parse($message->date_sent)->format('d/m H:i') }}</div>
                            </div>
                        @endforeach
                    @else
                        <p>No message available</p>
                    @endif
                </div>
                <a href="#" class="btn-view-all">See all messages</a>
            </div>
        </div>

    </div>
</div>

<!-- Edit Appointment Modal -->
@if($nextAppointment)
<div class="modal fade" id="editAppointmentModal" tabindex="-1" role="dialog" aria-labelledby="editAppointmentModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">

        <form method="POST" action="{{ route('premium.update.appointment', $nextAppointment->id) }}">
    @csrf
    @method('PUT')
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Appointment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <label for="date">New Date</label>
                <input type="date" name="date" class="form-control" value="{{ $nextAppointment->date }}" required>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </form>
  </div>
</div>
@endif



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>




<script>
    // Simulation de quelques interactions
    document.querySelectorAll('.btn-view-details, .btn-new-appointment, .btn-view-result, .btn-download-result, .btn-view-all').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            alert('Cette fonctionnalité sera implémentée dans la version complète');
        });
    });
</script>
@endsection

