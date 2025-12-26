
@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4 textt-primary"><font color= #007BFF >List of Patients</h1>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="text-start">
    <button class="btn btn-primary mb-3" onclick="openCreateModal()"> + Create New Patient</button>
      </div>
    <table class=" table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Birth Date</th>
                <th>Gender</th>
                <th>Blood Type</th>
                <th>Allergies</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($patients as $patient)
            <tr>
                <td>{{ $patient->name }}</td>
                <td>{{ $patient->email }}</td>
                <td>{{ $patient->patient->phone_number ?? 'N/A' }}</td>
                <td>{{ $patient->patient->birth_date ?? 'N/A' }}</td>
                <td>{{ ucfirst($patient->patient->gender ?? 'N/A') }}</td>
                <td>{{ $patient->patient->blood_type ?? 'N/A' }}</td>
                <td>{{ $patient->patient->allergies ?? 'None' }}</td>
                <td>
                    <button class="btn btn-info" onclick="viewPatient({{ $patient->id }})">View</button>
                    <button class="btn btn-warning" onclick="editPatient({{ $patient->id }})">Edit</button>
                    <form action="{{ route('admin.patients.delete', $patient->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal pour créer un patient -->
<div class="modal fade" id="createPatientModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Patient</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="createPatientForm" method="POST" action="{{ route('admin.patients.store') }}">
                    @csrf
                    
                    <label>Name</label>
                    <input type="text" name="name" class="form-control">

                    <label>Email</label>
                    <input type="email" name="email" class="form-control">

                    <label>Phone Number</label>
                    <input type="text" name="phone_number" class="form-control">

                    <label>Birth Date</label>
                    <input type="date" name="birth_date" class="form-control">

                    <label>Gender</label>
                    <select name="gender" class="form-control">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>

                    <label>Blood Type</label>
                    <select name="blood_type" class="form-control">
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>

                    <label>Allergies</label>
                    <input type="text" name="allergies" class="form-control">

                    <button type="submit" class="btn btn-success mt-3">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal pour voir un patient -->
<div class="modal fade" id="viewPatientModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Patient Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> <span id="viewName"></span></p>
                <p><strong>Email:</strong> <span id="viewEmail"></span></p>
                <p><strong>Phone:</strong> <span id="viewPhone"></span></p>
                <p><strong>Birth Date:</strong> <span id="viewDob"></span></p>
                <p><strong>Gender:</strong> <span id="viewGender"></span></p>
                <p><strong>Blood Type:</strong> <span id="viewBloodType"></span></p>
                <p><strong>Allergies:</strong> <span id="viewAllergies"></span></p>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour modifier un patient -->
<div class="modal fade" id="editPatientModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Patient</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>



            <form id="editPatientForm" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" id="editId" name="id">

                <label>Name</label>
                <input type="text" id="editName" name="name">

                <label>Email</label>
                <input type="email" id="editEmail" name="email">

                <label>Phone Number</label>
                <input type="text" id="editPhone" name="phone_number">

                <label>Birth Date</label>
                <input type="date" id="editBirthDate" name="birth_date">

                <label>Gender</label>
                <select id="editGender" name="gender">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>

                <label>Blood Type</label>
                <select id="editBloodType" name="blood_type">
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>

                <label>Allergies</label>
                <input type="text" id="editAllergies" name="allergies">

                <button type="submit">Update</button>
            </form>



        </div>
    </div>
</div>
<style>
    /* Couleurs principales */
    :root {
        --primary-color: #0078FF;
        --secondary-color: #6c757d;
        --success-color: #28a745;
        --info-color: #17a2b8;
        --warning-color: #ffc107;
        --danger-color: #dc3545;
        --light-color: #f8f9fa;
        --dark-color: #343a40;
    }

    /* Style général */
    .container {
        padding: 20px;
        max-width: 100%;
    }
    
    .textt-primary{
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #eaeff2;
}

    h1 {
        color: var(--primary-color);
        
        margin-bottom: 25px !important;
        margin-bottom: 10px; /* ou 5px si tu veux encore moins */
        padding-bottom: 10px;
        display: inline-block;
        font-family: arial, verdana, 'Clear Sans', sana-serif ; 
    }
    
    

    /* Tableau */
    .table {
        width: 100%;
        border-collapse: collapse;
        margin: 25px 0;
        font-size: 0.9em;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        border-radius: 10px;
        overflow: hidden;
    }

    .table thead tr {
        background-color: var(--primary-color);
        color: white;
        text-align: left;
        font-weight: bold;
    }

    .table th,
    .table td {
        padding: 12px 15px;
        vertical-align: middle;
    }

    .table tbody tr {
        border-bottom: 1px solid #dddddd;
        transition: all 0.3s ease;
    }

    .table tbody tr:nth-of-type(even) {
        background-color: #f3f3f3;
    }

    .table tbody tr:last-of-type {
        border-bottom: 2px solid var(--primary-color);
    }

    .table tbody tr:hover {
        background-color: #e9f5ff;
        transform: scale(1.005);
    }

    /* Boutons */
    .btn {
        padding: 8px 15px;
        border-radius: 5px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
        background-color: var(--primary-color);

    }

    .btn-info {
        background-color: var(--info-color);
        color: white;
    }

    .btn-warning {
        background-color: var(--warning-color);
        color: black;
    }

    .btn-danger {
        background-color: var(--danger-color);
    }

    .btn-success {
        background-color: var(--success-color);
    }

    .btn:hover {
        opacity: 0.9;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    /* Modals */
    .modal-content {
        border-radius: 10px;
        border: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        background-color: var(--primary-color);
        color: white;
        border-bottom: none;
        border-radius: 10px 10px 0 0;
    }
    

    .modal-title {
        font-weight: 600;
        color: white ;
    }

    .btn-close {
        filter: invert(1);
    }

    /* Formulaires */
    .form-control {
        border-radius: 5px;
        padding: 10px;
        border: 1px solid #ced4da;
        margin-bottom: 15px;
        width: 100%;
        transition: border 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    label {
        font-weight: 500;
        margin-bottom: 5px;
        display: block;
        color: var(--dark-color);
    }

    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 15px;
    }

    /* Alertes */
    .alert {
        border-radius: 5px;
        padding: 15px;
        margin-bottom: 20px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .table {
            display: block;
            overflow-x: auto;
        }
        
        .btn {
            margin-bottom: 5px;
            display: block;
            width: 100%;
        }
        
        .d-inline {
            display: inline-block !important;
            width: auto;
        }
    }

    /* View Modal Content */
    #viewPatientModal .modal-body p {
        margin-bottom: 15px;
        font-size: 16px;
    }

    #viewPatientModal strong {
        color: var(--primary-color);
        min-width: 120px;
        display: inline-block;
    }

    /* Action buttons in table */
    .table td:last-child {
        white-space: nowrap;
    }

    .table td .btn {
        margin-right: 5px;
        margin-bottom: 5px;
    }
</style>
<script>
function openCreateModal() {
        new bootstrap.Modal(document.getElementById('createPatientModal')).show();
    }


    function editPatient(id) {
    fetch(`/admin/patients/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            console.log("Données reçues pour l'édition :", data); // Vérifier si tout arrive bien

            document.getElementById('editPatientId').value = data.id;
            document.getElementById('editName').value = data.name ?? '';
            document.getElementById('editEmail').value = data.email ?? '';
            document.getElementById('editPhone').value = data.phone_number ?? '';
            document.getElementById('editDob').value = data.birth_date ?? '';
            document.getElementById('editGender').value = data.gender ?? '';
            document.getElementById('editBloodType').value = data.blood_type ?? '';
            document.getElementById('editAllergies').value = data.allergies ?? '';

            new bootstrap.Modal(document.getElementById('editPatientModal')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Erreur lors de la récupération des données.");
        });
}



function viewPatient(id) {
    fetch(`/admin/list/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('viewName').innerText = data.name ?? 'N/A';
            document.getElementById('viewEmail').innerText = data.email ?? 'N/A';
            document.getElementById('viewPhone').innerText = data.patient?.phone_number ?? 'N/A';
            document.getElementById('viewDob').innerText = data.patient?.birth_date ?? 'N/A';
            document.getElementById('viewGender').innerText = data.patient?.gender ?? 'N/A';
            document.getElementById('viewBloodType').innerText = data.patient?.blood_type ?? 'N/A';
            document.getElementById('viewAllergies').innerText = data.patient?.allergies ?? 'None';

            new bootstrap.Modal(document.getElementById('viewPatientModal')).show();
        })
        .catch(error => {
            alert("Error viewing patient data: " + error.message);
        });
}



</script>


<script src="{{ asset('js/list.js') }}"></script>
@endsection

