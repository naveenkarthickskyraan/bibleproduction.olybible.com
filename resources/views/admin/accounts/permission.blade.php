<style>
    .permission-badge {
        transition: all 0.2s ease;
        font-size: 0.85rem;
        border-radius: 4px;
        cursor: default;
    }

    .permission-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .permission-granted {
        background-color: #d1fae5 !important;
        color: #065f46 !important;
        border-left: 3px solid #10b981;
    }

    .permission-denied {
        background-color: #fee2e2 !important;
        color: #b91c1c !important;
        border-left: 3px solid #ef4444;
    }

    .permission-denied i.fa-times-circle {
        margin-left: 5px;
    }

    .full-access-badge {
        background-color: #dbeafe !important;
        color: #1e40af !important;
        border-left: 3px solid #3b82f6;
    }
</style>

<!-- Permission Alert -->
<div id="permissionAlert" style="display: none;">
    <div class="alert alert-light border shadow p-3 mb-3 rounded"
            onmouseenter="pauseAutoHide()" >

        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="mb-0"><i class="fa fa-shield-alt me-1 text-primary me-2"></i>{{ $name }} Permissions Overview</h6>
            <button type="button" data-bs-toggle="tooltip" title="Close this notification (will show again after 1 hour)" class="btn-close" aria-label="Close" onclick="dismissPermissionAlert(true)"></button>
        </div>

        @if(Auth::guard('admin')->user()->accountAccessPrivilege == "system")
            <span class="permission-badge badge p-2 px-3 full-access-badge">
                <i class="fas fa-star me-1"></i>
                Full Access
                <i class="fas fa-check-circle ms-1"></i>
            </span>
        @else
            <div class="d-flex flex-wrap gap-2">
                @foreach (['read', 'create', 'update', 'delete', 'status'] as $perm)
                    @php
                        $userPermissions = Auth::guard('admin')->user()->accountAccessPrivilege;
                        $userPermissions = json_decode($userPermissions, true);
                        $hasPermission = in_array($perm, $userPermissions[$menu] ?? []);
                        $badgeClass = $hasPermission ? 'permission-granted' : 'permission-denied';
                        $icon = match($perm) {
                            'read' => 'fa-eye',
                            'create' => 'fa-plus-circle',
                            'update' => 'fa-edit',
                            'delete' => 'fa-trash-alt',
                            'status' => 'fa-toggle-on',
                        };
                        $statusIcon = $hasPermission ? 'fa-check-circle' : 'fa-times-circle';
                    @endphp
                    <span class="permission-badge badge p-2 px-3 {{ $badgeClass }}">
                        <i class="fas {{ $icon }} me-1"></i>
                        {{ ucfirst($perm) }}
                        <i class="fas {{ $statusIcon }} ms-1"></i>
                        @if(!$hasPermission)
                            <span class="ms-1">(Denied)</span>
                        @endif
                    </span>
                @endforeach
            </div>
        @endif
    </div>
</div>
