@extends('layouts.admin')

@section('content')
<div class="container">
<div class="premium-patients-container">
    <h2 class="premium-patients-header">External Patients Management</h2>

    <table class="table premium-patients-table mt-4">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Account Type</th>
                <th class="action-cell">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($premiumPatients as $pp)
                @if ($pp->user)
                    <tr id="row-{{ $pp->user->id }}">
                        <td>{{ $pp->user->name }}</td>
                        <td>{{ $pp->user->email }}</td>
                        <td>
                            <span class="status-badge">
                                External patient
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm upgrade-btn" onclick="upgradePatient({{ $pp->user->id }})">
                                <i class="fas fa-level-up-alt mr-1"></i> Upgrade
                            </button>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
</div>
<style>
    /* Premium Patients Page Styling */

.premium-patients-container h2 {
    color: #0078ff;
}
.premium-patients-header {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #eaeff2;
}

.premium-patients-table {
    background-color: white;
    border-radius: 6px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
}

.premium-patients-table thead {
    background-color: #3498db;
    color: white;
}

.premium-patients-table th {
    padding: 1rem;
    font-weight: 500;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
}

.premium-patients-table td {
    padding: 1rem;
    vertical-align: middle;
    border-top: 1px solid #f1f5f9;
}

.premium-patients-table tbody tr:hover {
    background-color: #f8fafc;
}

.upgrade-btn {
    background: linear-gradient(45deg, #5e36b1, #9c6cf7) !important;
    border: none;
    padding: 0.5rem 1.25rem;
    font-size: 0.85rem;
    font-weight: 500;
    color: white !important;
    border-radius: 6px;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(94, 54, 177, 0.3);
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.upgrade-btn:hover {
    background: linear-gradient(45deg, #4d2a9b, #8a5be8) !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(94, 54, 177, 0.4);
    text-decoration: none;
}

.upgrade-btn:active {
    transform: translateY(0);
    box-shadow: 0 2px 5px rgba(94, 54, 177, 0.3);
}

.upgrade-btn i {
    margin-right: 6px;
    font-size: 0.9em;
}
.status-badge {
    padding: 0.35rem 0.65rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-premium {
    background-color: #e3f7ed;
    color: #2ecc71;
}

.status-regular {
    background-color: #fff4e6;
    color: #f39c12;
}

.action-cell {
    min-width: 120px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .premium-patients-container {
        padding: 1rem;
    }
    
    .premium-patients-table th, 
    .premium-patients-table td {
        padding: 0.75rem;
    }
}
</style>
<script>
    function upgradePatient(userId) {
        if (confirm("Are you sure you want to upgrade this patient to premium status?")) {
            fetch(`/admin/upgrade-patient/${userId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Show success notification
                    showNotification('success', 'Patient upgraded successfully!');
                    
                    // Remove the row or update the status visually
                    document.getElementById(`row-${userId}`).remove();
                    
                    // Alternatively, you could update the row to show new status:
                    // const row = document.getElementById(`row-${userId}`);
                    // row.querySelector('.status-badge').className = 'status-badge status-premium';
                    // row.querySelector('.status-badge').textContent = 'Premium';
                    // row.querySelector('.upgrade-btn').disabled = true;
                } else {
                    showNotification('error', data.message || "Error during upgrade.");
                }
            })
            .catch(error => {
                showNotification('error', "An error occurred during the upgrade process.");
                console.error('Error:', error);
            });
        }
    }

    function showNotification(type, message) {
        // You can implement a toast notification here
        // For simplicity using alert, but consider using a library like Toastr
        alert(message);
        
        /* Example with Toastr:
        toastr[type](message);
        */
    }
</script>

<!-- Include Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


@endsection