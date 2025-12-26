



@extends('layouts.admin')

@section('content')
<div class="medical-inquiries-container" style="margin-top: 1rem;"> <!-- Reduced top margin -->
  

    <div class="inquiries-card">
    <h1  class="textt-primary">Patient Communications</h1>
        <div class="table-responsive-lg">
            <table class="medical-table">
                <thead>
                    <tr style="background-color: #2c7be5; color: white;"> <!-- Blue header background -->
                        <th class="patient-col">Patient</th>
                        <th class="contact-col">Email</th>
                        <th class="message-col">Message</th>
                        <th class="status-col">Status</th>
                        <th class="date-col">Received</th>
                        <th class="actions-col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($messages as $message)
                    <tr class="{{ $message->status === 'Resolved' ? 'resolved' : 'pending' }}">
                        <td class="patient-info">
                            <div class="patient-name">{{ $message->name }}</div>
                            @if($message->patient_id)
                            <div class="patient-id">MRN: {{ $message->patient_id }}</div>
                            @endif
                        </td>
                        <td>
                            <div class="contact-email">{{ $message->email }}</div>
                            @if($message->phone)
                            <div class="contact-phone">{{ $message->phone }}</div>
                            @endif
                        </td>
                        <td class="message-content">
                            <div class="original-message">
                                <i class="fas fa-comment-dots"></i> {{ Str::limit($message->message, 150) }}
                            </div>
                            
                            @if ($message->admin_reply)
                            <div class="admin-reply">
                                <div class="reply-header">
                                    <i class="fas fa-user-md"></i> <strong>Clinician Response</strong>
                                    <span class="reply-date">{{ $message->reply_date }}</span>
                                </div>
                                <div class="reply-text">{{ $message->admin_reply }}</div>
                            </div>
                            @endif
                        </td>
                        <td class="status-cell">
                            <div class="status-badge {{ $message->status === 'Resolved' ? 'resolved' : 'pending' }}">
                                <i class="fas {{ $message->status === 'Resolved' ? 'fa-check-circle' : 'fa-hourglass-half' }}"></i>
                                {{ $message->status }}
                            </div>
                        </td>
                        <td class="date-cell">
                            <div class="received-date">{{ $message->date_sent }}</div>
                            <div class="received-time">{{ $message->time_sent }}</div>
                        </td>
                        <td class="actions-cell">
                            <div class="action-buttons">
                                <button class="btn-reply" onclick="toggleReplyForm({{ $message->id }})">
                                    <i class="fas fa-reply"></i> Respond
                                </button>

                                <div class="reply-form-container" id="reply-form-{{ $message->id }}">
                                    <form action="{{ route('admin.reply.message', $message->id) }}" method="POST" class="reply-form">
                                        @csrf
                                        <div class="form-group">
                                            <textarea name="reply" class="form-control" placeholder="Type your professional response..." rows="3" required></textarea>
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" class="btn-send">
                                                <i class="fas fa-paper-plane"></i> Send Response
                                            </button>
                                            <button type="button" class="btn-cancel" onclick="toggleReplyForm({{ $message->id }})">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                @if ($message->status !== 'Resolved')
                                <form action="{{ route('admin.messages.resolve', $message->id) }}" method="POST" class="resolve-form">
                                    @csrf
                                    <button type="submit" class="btn-resolve">
                                        <i class="fas fa-check-double"></i> Mark Resolved
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
:root {
    --primary: #0078ff;
    --primary-light: #e6f0fd;
    --primary-dark: #1a68d1;
    --secondary: #6e84a3;
    --success: #00d97e;
    --success-light: #e1faf0;
    --warning: #f6c343;
    --warning-light: #fff8e6;
    --danger: #e63757;
    --light: #f9fbfd;
    --lighter: #f5f8fa;
    --border: #e3ebf6;
    --text-dark: #2c3e50;
    --text-medium: #4a5568;
    --text-light: #95aac9;
}

.medical-inquiries-container {
    max-width: 1400px;
    margin: 1rem auto; /* Reduced top margin */
    padding: 0 1.5rem;
    font-family: 'Segoe UI', 'Roboto', 'Helvetica Neue', sans-serif;
}
.textt-primary{
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #eaeff2;
}
.page-header {
    text-align: center;
    margin-bottom: 1.5rem; /* Reduced margin */
}

.header-icon {
    font-size: 2.8rem;
    color: var(--primary);
    margin-bottom: 0.5rem; /* Reduced margin */
}

.inquiries-card h1 {
    color: var(--primary) ;
    
    margin-bottom: 0.5rem;
    font-size: 40px;
}

.inquiries-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.3);
    padding: 1.5rem;
    border: 1px solid var(--border);
    overflow: hidden;
    border-left: 4px solid #3498db;
}

.medical-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    margin-top: 40px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
    
}

.medical-table thead tr {
    background-color: var(--primary); /* Blue header */
    color: white;
}

.medical-table th {
    padding: 1rem 1.25rem;
    text-align: left;
    font-weight: 600;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background-color:#e1f0ff;
    color: black;

}
.medical-table th:hover{
    color: var(--primary);
}

.medical-table th:first-child {
    border-top-left-radius: 10px;
}

.medical-table th:last-child {
    border-top-right-radius: 10px;
}

.medical-table td {
    padding: 1.25rem;
    vertical-align: top;
    border-bottom: 1px solid var(--border);
    color: var(--text-medium);
}

.medical-table tr:last-child td {
    border-bottom: none;
}

.medical-table tr:hover {
    background-color: var(--lighter);
}

/* Rest of your existing CSS remains the same */
.patient-info {
    min-width: 180px;
}

.patient-name {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 0.25rem;
    font-size: 20px ;
    
}

.patient-id {
    font-size: 0.8rem;
    color: var(--secondary);
    background: var(--light);
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    display: inline-block;
}

.contact-email {
    margin-bottom: 0.5rem;
    word-break: break-word;
}

.contact-phone {
    font-size: 0.9rem;
    color: var(--text-medium);
}

.message-content {
    max-width: 350px;
}

.original-message {
    margin-bottom: 1rem;
    line-height: 1.5;
}

.original-message i {
    color: var(--primary);
    margin-right: 0.5rem;
}

.admin-reply {
    background: var(--primary-light);
    border-radius: 8px;
    padding: 0.75rem;
    border-left: 3px solid var(--primary);
}

.reply-header {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
    font-size: 0.85rem;
}

.reply-header i {
    color: var(--primary);
    margin-right: 0.5rem;
}

.reply-header strong {
    color: var(--text-dark);
}

.reply-date {
    margin-left: auto;
    font-size: 0.75rem;
    color: var(--secondary);
}

.reply-text {
    font-size: 0.9rem;
    line-height: 1.5;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.35rem 0.75rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 500;
}

.status-badge i {
    margin-right: 0.5rem;
}

.status-badge.resolved {
    background: var(--success-light);
    color: var(--success);
}

.status-badge.pending {
    background: var(--warning-light);
    color: #b78103;
}

.received-date {
    font-weight: 500;
    margin-bottom: 0.25rem;
}

.received-time {
    font-size: 0.85rem;
    color: var(--secondary);
}

.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    min-width: 200px;
}

.btn-reply {
    background: var(--primary);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-reply:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
}

.btn-reply i {
    font-size: 0.9rem;
}

.reply-form-container {
    display: none;
    animation: fadeIn 0.3s ease-out;
}

.reply-form {
    background: white;
    border: 1px solid var(--border);
    border-radius: 8px;
    padding: 1rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.form-group textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid var(--border);
    border-radius: 6px;
    resize: vertical;
    min-height: 100px;
    font-family: inherit;
}

.form-group textarea:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(44, 123, 229, 0.15);
}

.form-actions {
    display: flex;
    gap: 0.75rem;
    margin-top: 0.75rem;
}

.btn-send {
    background: var(--success);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-send:hover {
    background: #00c571;
}

.btn-cancel {
    background: white;
    color: var(--secondary);
    border: 1px solid var(--border);
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    flex: 1;
}

.btn-cancel:hover {
    background: var(--lighter);
}

.btn-resolve {
    background: var(--success-light);
    color: var(--success);
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-resolve:hover {
    background: #d1f5e4;
}

.resolve-form {
    margin-top: 0.5rem;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 1200px) {
    .medical-table {
        display: block;
        overflow-x: auto;
    }
    
    .patient-col { min-width: 180px; }
    .contact-col { min-width: 180px; }
    .message-col { min-width: 300px; }
    .status-col { min-width: 120px; }
    .date-col { min-width: 120px; }
    .actions-col { min-width: 200px; }
}

@media (max-width: 768px) {
    .medical-inquiries-container {
        padding: 0 1rem;
    }
    
    .inquiries-card {
        padding: 1rem;
    }
    
    .action-buttons {
        min-width: 160px;
    }
}
</style>

<script>
function toggleReplyForm(id) {
    const form = document.getElementById('reply-form-' + id);
    if (form.style.display === 'none' || form.style.display === '') {
        form.style.display = 'block';
        // Smooth scroll to show the full form
        form.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    } else {
        form.style.display = 'none';
    }
}
</script>
@endsection