@extends('layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-muted fw-light">Partenaires / </span> Liste des Partenaires
        </h4>
        <div class="card">
            <h5 class="card-header d-flex justify-content-between align-items-center">
                <div>Liste des Partenaires</div>
                <div class="ms-auto py-2 px-2">  
                    <div class="btn-group">
                        <a href="{{ route('partenaire.create') }}" type="button" class="btn btn-primary">Ajouter</a>
                    </div>
                </div>
            </h5>
            <div class="card-body">
                <div class="card-datatable table-responsive text-nowrap">
                    <table class="dt-responsive table table-striped" id="datatable--barm" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Structure</th>
                                <th>Email</th>
                                <th>N° téléphone</th>
                                <th>Type</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($partenaires as $item)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td><strong>{{ $item->user->username }}</strong></td>
                                    <td>{{ $item->user->email }}</td>
                                    <td>{{ $item->phone_number }}</td>
                                    <td>
                                        @foreach ($item->user->permissions as $permission)
                                            <span class="badge bg-primary">{{ permissionFr($permission->name) }}</span>
                                            @if (!$loop->last)
                                                &nbsp;
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @if ($item->user->status == 1)
                                            <span class="badge bg-success">Actif</span>
                                        @else
                                            <span class="badge bg-danger">Bloqué</span>
                                        @endif
                                    </td>
                                    <td class="d-flex" style="gap: 10px;">
                                        <a href="{{ route('partenaire.edit', $item->id) }}"
                                            class="btn btn-sm btn-outline-primary">Modifier</a>

                                        <button type="button" 
                                                class="btn btn-sm {{ $item->user->status == 1 ? 'btn-outline-warning' : 'btn-outline-success' }}" 
                                                onclick="confirmLockUnlock({{ $item->id }}, '{{ $item->user->username }}', {{ $item->user->status }})">
                                                <i class="fa {{ $item->user->status == 1 ? 'fa-lock' : 'fa-unlock' }}"></i>
                                        </button>

                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                onclick="confirmDelete({{ $item->id }}, '{{ $item->user->username }}')">
                                                <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulaire de suppression caché -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <!-- Formulaire de blocage/déblocage caché -->
    <form id="lockUnlockForm" method="POST" style="display: none;">
        @csrf
        @method('PUT')
    </form>

    <script>
        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                html: `<strong>${name}</strong> sera définitivement supprimé.<br><br><span class="text-danger">Cette action est irréversible !</span>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimer !',
                cancelButtonText: 'Annuler',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('deleteForm');
                    form.action = `{{ url('partenaire') }}/${id}`;
                    form.submit();
                }
            });
        }

        function confirmLockUnlock(id, name, currentStatus) {
            const isActive = currentStatus == 1;
            const action = isActive ? 'bloquer' : 'débloquer';
            const icon = isActive ? 'warning' : 'success';
            const confirmColor = isActive ? '#ffc107' : '#28a745';
            
            Swal.fire({
                title: `Voulez-vous ${action} ce partenaire ?`,
                html: `<strong>${name}</strong> sera ${action}.<br><br><span class="text-${isActive ? 'warning' : 'success'}">Cette action peut être annulée.</span>`,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: confirmColor,
                cancelButtonColor: '#6c757d',
                confirmButtonText: `Oui, ${action} !`,
                cancelButtonText: 'Annuler',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById('lockUnlockForm');
                    form.action = `{{ url('partenaire') }}/${id}/lock-unlock`;
                    form.submit();
                }
            });
        }
    </script>
@endsection
