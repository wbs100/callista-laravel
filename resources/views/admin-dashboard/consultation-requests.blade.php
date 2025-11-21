@extends('layouts.admin-dashboard')

@section('content')
<div class="dashboard-content">
    <div class="highlighted-section">
        <div class="highlight-badge">Consultation Requests</div>
        <h2 class="section-title-highlighted">
            <i class="fas fa-calendar-check"></i>
            Consultation Requests
        </h2>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Total Requests</div>
                    <div class="stat-icon primary"></div>
                </div>
                <div class="stat-value">{{ $consultationRequests->total() }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-info-circle"></i>
                    <span>All consultation requests</span>
                </div>
            </div>
            <div class="stat-card warning">
                <div class="stat-header">
                    <div class="stat-title">Pending</div>
                    <div class="stat-icon warning"></div>
                </div>
                <div class="stat-value">{{ $consultationRequests->where('status', 'pending')->count() }}</div>
                <div class="stat-change neutral">
                    <i class="fas fa-minus"></i>
                    <span>Needs attention</span>
                </div>
            </div>
            <div class="stat-card success">
                <div class="stat-header">
                    <div class="stat-title">Completed</div>
                    <div class="stat-icon success"></div>
                </div>
                <div class="stat-value">{{ $consultationRequests->where('status', 'completed')->count() }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-check"></i>
                    <span>Consultations done</span>
                </div>
            </div>
        </div>
    </div>
    <div class="order-filters">
        <div class="filter-row">
            <div class="form-group">
                <label class="form-label">Name</label>
                <input type="text" id="filterName" class="form-input" placeholder="Search by name..."
                    value="{{ request('name') }}">
            </div>
            <div class="form-group">
                <label class="form-label">Status</label>
                <select id="filterStatus" class="form-select">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ request('status')=='completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div class="filter-actions">
                <button class="btn-filter" onclick="applyConsultationFilters()">
                    <i class="fas fa-filter"></i>
                    Filter
                </button>
                <button class="btn-clear-filter" onclick="clearConsultationFilters()">
                    <i class="fas fa-times"></i>
                    Clear
                </button>
            </div>
        </div>
    </div>
    <div class="highlighted-section">
        <div class="highlight-badge">Request Management</div>
        <div class="order-header">
            <h2 class="section-title-highlighted">
                <i class="fas fa-list-alt"></i>
                Consultation Requests
            </h2>
        </div>
        <div class="orders-table">
            <div class="table-header">
                Recent Consultation Requests
                <span class="total-count">({{ $consultationRequests->total() }} total)</span>
            </div>
            <div class="orders-table-content">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Project Type</th>
                            <th>Budget</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($consultationRequests as $request)
                        <tr>
                            <td>{{ $request->id }}</td>
                            <td>{{ $request->first_name }} {{ $request->last_name }}</td>
                            <td>{{ $request->email }}</td>
                            <td>{{ $request->phone }}</td>
                            <td>{{ $request->project_type }}</td>
                            <td>{{ $request->budget }}</td>
                            <td>{{ $request->preferred_date }}</td>
                            <td><span class="order-status status-{{ $request->status }}">{{ ucfirst($request->status)
                                    }}</span></td>
                            <td class="">
                                <button class="btn-action btn-view"
                                    onclick="viewConsultationDetails({{ $request->id }})"><i
                                        class="fas fa-eye"></i></button>
                                <button class="btn-action btn-edit-order"
                                    onclick="editConsultationStatus({{ $request->id }}, '{{ $request->status }}')"><i
                                        class="fas fa-edit"></i></button>
                                <button class="btn-action btn-delete-order"
                                    onclick="deleteConsultation({{ $request->id }})"><i
                                        class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $consultationRequests->links('vendor.pagination.admin-pagination') }}
            <br>
        </div>
    </div>
</div>
<!-- Modals for details, edit, delete can be added here, similar to custom requests -->
@endsection