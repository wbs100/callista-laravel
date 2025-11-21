@extends('layouts.admin-dashboard')

@section('content')
<div class="dashboard-content">
    <div class="highlighted-section">
        <div class="highlight-badge">Project Inquiries</div>
        <h2 class="section-title-highlighted">
            <i class="fas fa-question-circle"></i>
            Project Inquiries
        </h2>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-title">Total Inquiries</div>
                    <div class="stat-icon primary"></div>
                </div>
                <div class="stat-value">{{ $projectInquiries->total() }}</div>
                <div class="stat-change positive">
                    <i class="fas fa-info-circle"></i>
                    <span>All project inquiries</span>
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
                <label class="form-label">Project Type</label>
                <input type="text" id="filterProjectType" class="form-input" placeholder="Search by project type..."
                    value="{{ request('project_type') }}">
            </div>
            <div class="filter-actions">
                <button class="btn-filter" onclick="applyInquiryFilters()">
                    <i class="fas fa-filter"></i>
                    Filter
                </button>
                <button class="btn-clear-filter" onclick="clearInquiryFilters()">
                    <i class="fas fa-times"></i>
                    Clear
                </button>
            </div>
        </div>
    </div>
    <div class="highlighted-section">
        <div class="highlight-badge">Inquiry Management</div>
        <div class="order-header">
            <h2 class="section-title-highlighted">
                <i class="fas fa-list-alt"></i>
                Project Inquiries
            </h2>
        </div>
        <div class="orders-table">
            <div class="table-header">
                Recent Project Inquiries
                <span class="total-count">({{ $projectInquiries->total() }} total)</span>
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
                            <th>Timeline</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projectInquiries as $inquiry)
                        <tr>
                            <td>{{ $inquiry->id }}</td>
                            <td>{{ $inquiry->firstName }} {{ $inquiry->lastName }}</td>
                            <td>{{ $inquiry->email }}</td>
                            <td>{{ $inquiry->phone }}</td>
                            <td>{{ $inquiry->projectType }}</td>
                            <td>{{ $inquiry->budget }}</td>
                            <td>{{ $inquiry->timeline }}</td>
                            <td><span class="order-status status-{{ $inquiry->status ?? 'pending' }}">{{
                                    ucfirst($inquiry->status ?? 'pending') }}</span></td>
                            <td class="">
                                <button class="btn-action btn-view" onclick="viewInquiryDetails({{ $inquiry->id }})"><i
                                        class="fas fa-eye"></i></button>
                                <button class="btn-action btn-delete-order"
                                    onclick="deleteInquiry({{ $inquiry->id }})"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $projectInquiries->links('vendor.pagination.admin-pagination') }}
            <br>
        </div>
    </div>
</div>
<!-- Modals for details, delete can be added here, similar to custom requests -->
@endsection