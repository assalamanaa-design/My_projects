@extends('layouts.admin')

@section('content')
<div class="main-content px-4 py-3">
    <div class="appointments-table shadow rounded-4 p-4 bg-white animate__animated animate__fadeIn">
        <h1 class="mb-4 textt-primary">Appointments List</h1>
        <div class="table-responsive">
            <table class="table table-hover table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Appointment Date</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="appointments-list">
                @foreach($appointments as $appointment)
                <tr class="animate__animated animate__fadeInUp">
                    <td>{{ $appointment->name ?? 'Unknown' }}</td>
                    <td>{{ $appointment->email ?? 'Unknown' }}</td>
                    <td>{{ $appointment->phone_number }}</td>
                    <td>{{ $appointment->date }}</td>
                    <td>{{ $appointment->message }}</td>
                    <td id="status-{{ $appointment->id }}">{{ $appointment->status }}</td>
                    <td>
                        <div class="d-flex gap-2 justify-content-center">
                            <button class="btn btn-success btn-sm" onclick="updateStatus({{ $appointment->id }}, 'Accepted')">Accept</button>
                            <button class="btn btn-danger btn-sm" onclick="updateStatus({{ $appointment->id }}, 'Refused')">Refuse</button>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .appointments-table {
        border-left: 4px solid #3498db;
    }
    
   
    table th {
        padding: 1rem 1.25rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background-color: #e1f0ff;
        color: black;
        border-top: none;
    }
    
    .textt-primary {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #eaeff2;
    }
    
    table tr:hover {
        background-color: #f8f9fa;
    }
    
    /* Status badge styling */
    td[id^="status-"] {
        font-weight: 500;
        text-transform: capitalize;
    }
    
    td[id^="status-"]:empty::before {
        content: "N/A";
        color: #6c757d;
        font-style: italic;
    }
    
    /* Action buttons */
    .btn-success {
        background-color: #2ecc71;
        border-color: #2ecc71;
    }
    
    .btn-danger {
        background-color: #e74c3c;
        border-color: #e74c3c;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .main-content {
            padding: 1rem;
        }
        
        table th, table td {
            padding: 0.75rem;
        }
    }
</style>

<script>
    function updateStatus(appointmentId, status) {
        fetch(`/appointments/${appointmentId}/status/${status}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Update status in table
            document.getElementById(`status-${appointmentId}`).textContent = status;

            // Show success notification
            const alert = document.createElement('div');
            alert.className = 'alert alert-success position-fixed top-0 end-0 m-3 animate__animated animate__fadeInDown';
            alert.textContent = data.message;

            document.body.appendChild(alert);

            // Remove after 3 seconds
            setTimeout(() => {
                alert.classList.replace('animate__fadeInDown', 'animate__fadeOutUp');
                setTimeout(() => alert.remove(), 1000);
            }, 3000);
        })
        .catch(error => {
            console.error('Error:', error);
            // Show error notification
            const alert = document.createElement('div');
            alert.className = 'alert alert-danger position-fixed top-0 end-0 m-3 animate__animated animate__fadeInDown';
            alert.textContent = 'Error updating status';

            document.body.appendChild(alert);

            setTimeout(() => {
                alert.classList.replace('animate__fadeInDown', 'animate__fadeOutUp');
                setTimeout(() => alert.remove(), 1000);
            }, 3000);
        });
    }
</script>
@endsection