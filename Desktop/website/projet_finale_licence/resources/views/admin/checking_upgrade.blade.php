@extends('layouts.admin')

@section('content')
<div class="container">
<div class="premium-requests-container">
    <div class="page-header">
        <h2 class="page-title">Premium Account Requests</h2>
        
    </div>

    <div class="carrd">
        <div class="card-body">
            <div class="table-responsive">
                <table class="premium-requests-table">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Email Address</th>
                            <th>CCP Number</th>
                            <th>Request Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requests as $req)
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="user-name">{{ $req->user->name }}</div>
                                
                                </div>
                            </td>
                            <td>{{ $req->user->email }}</td>
                            <td>
                                <span class="ccp-badge">{{ $req->ccp_number ?? 'Not provided' }}</span>
                            </td>
                            <td>
                                <div class="request-date">
                                    <div class="date">{{ $req->created_at->format('d M Y') }}</div>
                                    <div class="time">{{ $req->created_at->format('h:i A') }}</div>
                                </div>
                            </td>
                            <td class="action-buttons">
                                <form action="{{ route('admin.upgrade.accept', $req->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-accept">
                                        <i class="fas fa-check-circle"></i> Approve
                                    </button>
                                </form>
                                <form action="{{ route('admin.upgrade.refuse', $req->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn-reject">
                                        <i class="fas fa-times-circle"></i> Reject
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
    

    /* Page Header */
    .page-header {
        margin-bottom: 2rem;
    }

    .page-title {
        
        color: #0078ff;
    font-weight: 600;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #eaeff2;
    }

    .page-subtitle {
        color: #7f8c8d;
        font-size: 1rem;
    }

    /* Card Styling */
    

    /* Table Styling */
    .premium-requests-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        border:none;
    }

    .premium-requests-table thead th {
        background-color:  #ddeafc;
        color: black;
        font-weight: 600;
        padding: 1rem 1.25rem;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #e9ecef;
    }
    .premium-requests-table thead th:hover{
        color: #0078ff;
    }

    .premium-requests-table tbody td {
        padding: 1.25rem;
        vertical-align: middle;
        border-bottom: 1px solid  #ddeafc;
    }

    .premium-requests-table tbody tr:last-child td {
        border-bottom: none;
    }

    .premium-requests-table tbody tr:hover {
        background-color:rgb(244, 245, 247);
    }

    /* User Info Styling */
    .user-info {
        line-height: 1.4;
    }

    .user-name {
        font-weight: 500;
        color: #2c3e50;
    }

    .user-id {
        font-size: 0.8rem;
        color: #7f8c8d;
    }

    /* CCP Badge */
    .ccp-badge {
        display: inline-block;
        padding: 0.35rem 0.75rem;
        background-color: #ddeafc;
        color: #0078ff;
        border-radius: 50px;
        font-size: 0.85rem;
        font-family: 'Courier New', monospace;
        font-weight: 500;
    }

    /* Date Styling */
    .request-date {
        line-height: 1.4;
    }

    .date {
        font-weight: 500;
        color: #2c3e50;
    }

    .time {
        font-size: 0.85rem;
        color: #7f8c8d;
    }

    /* Action Buttons */
    .action-buttons {
        white-space: nowrap;
    }

    .btn-accept, .btn-reject {
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        margin-right: 0.5rem;
    }

    .btn-accept {
        background: linear-gradient(45deg, #2ecc71, #27ae60);
        color: white;
        box-shadow: 0 2px 8px rgba(46, 204, 113, 0.3);
    }

    .btn-accept:hover {
        background: linear-gradient(45deg, #27ae60, #219653);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(46, 204, 113, 0.4);
    }

    .btn-reject {
        background: linear-gradient(45deg, #e74c3c, #c0392b);
        color: white;
        box-shadow: 0 2px 8px rgba(231, 76, 60, 0.3);
    }

    .btn-reject:hover {
        background: linear-gradient(45deg, #c0392b, #a53125);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(231, 76, 60, 0.4);
    }

    .btn-accept i, .btn-reject i {
        margin-right: 6px;
        font-size: 0.9em;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .premium-requests-container {
            padding: 1rem;
        }
        
        .premium-requests-table thead th, 
        .premium-requests-table tbody td {
            padding: 0.75rem;
        }
        
        .action-buttons {
            white-space: normal;
        }
        
        .btn-accept, .btn-reject {
            margin-bottom: 0.5rem;
        }
    }
</style>
@endsection