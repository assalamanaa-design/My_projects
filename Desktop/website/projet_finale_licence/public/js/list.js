
// 🔹 Charger la liste des patients dynamiquement
function fetchPatients() {
    fetch("/admin/patients") // Utilisation de l'URL directement
        .then(response => response.json())
        .then(patients => {
            const patientsList = document.getElementById('patients-list');
            patientsList.innerHTML = '';

            patients.forEach(patient => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${patient.user.name}</td> 
                    <td>${patient.user.email}</td> 
                    <td>${patient.phone_number}</td>
                    <td>${patient.birth_date}</td>
                    <td>${patient.gender}</td>
                    <td>${patient.blood_type}</td>
                    <td>${patient.allergies ?? 'None'}</td>
                    <td>
                        <button class="btn btn-info" onclick="viewPatient(${patient.id})">View</button>
                        <button class="btn btn-warning" onclick="editPatient(${patient.id})">Edit</button>
                        <button class="btn btn-danger" onclick="deletePatient(${patient.id})">Delete</button>
                    </td>
                `;
                patientsList.appendChild(tr);
            });
        })
        .catch(error => console.error('Erreur lors du chargement des patients:', error));
}

document.addEventListener("DOMContentLoaded", function () {
    fetchPatients();

    document.getElementById('editPatientForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Empêche la soumission classique du formulaire

        let patientId = document.getElementById('editId').value;
        let formData = new FormData(this);

        fetch(`/admin/patients/${patientId}`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Patient updated successfully!');
                location.reload();
            } else {
                alert('Error updating patient');
            }
        })
        .catch(error => console.error('Error:', error));
    });
});

function fetchPatients() {
    fetch("/admin/patients")
        .then(response => response.json())
        .then(patients => {
            const patientsList = document.getElementById('patients-list');
            patientsList.innerHTML = '';

            patients.forEach(patient => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${patient.user.name}</td>
                    <td>${patient.user.email}</td>
                    <td>${patient.phone_number}</td>
                    <td>${patient.birth_date}</td>
                    <td>${patient.gender}</td>
                    <td>${patient.blood_type}</td>
                    <td>${patient.allergies ?? 'None'}</td>
                    <td>
                        <button class="btn btn-info" onclick="viewPatient(${patient.id})">View</button>
                        <button class="btn btn-warning" onclick="editPatient(${patient.id})">Edit</button>
                        <button class="btn btn-danger" onclick="deletePatient(${patient.id})">Delete</button>
                    </td>
                `;
                patientsList.appendChild(tr);
            });
        })
        .catch(error => console.error('Error fetching patients:', error));
}

function editPatient(id) {
    fetch(`/admin/patients/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('editId').value = id;
            document.getElementById('editName').value = data.name;
            document.getElementById('editEmail').value = data.email;
            document.getElementById('editPhone').value = data.phone_number;
            document.getElementById('editBirthDate').value = data.birth_date;
            document.getElementById('editGender').value = data.gender;
            document.getElementById('editBloodType').value = data.blood_type;
            document.getElementById('editAllergies').value = data.allergies;
            
            new bootstrap.Modal(document.getElementById('editPatientModal')).show();
        })
        .catch(error => console.error('Error fetching patient data:', error));
}

function deletePatient(id) {
    if (!confirm("Are you sure you want to delete this patient?")) return;

    fetch(`/admin/patients/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Patient deleted successfully!");
            location.reload();
        } else {
            alert("Error deleting patient");
        }
    })
    .catch(error => console.error('Error deleting patient:', error));
}



