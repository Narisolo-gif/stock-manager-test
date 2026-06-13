{{--
    Vue : clients/index.blade.php
    Rôle : Liste paginée de tous les clients avec actions CRUD et recherche
    Données reçues : $clients (LengthAwarePaginator), $search
--}}

@extends('layouts.app')

@section('title', 'Gestion des clients')

@section('content')
<div class="container py-4">

    {{-- En-tête de page --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">
                <i class="bi bi-people me-2 text-primary"></i>Clients
            </h1>
            <p class="text-muted small mb-0">
                {{ $clients->total() }} client{{ $clients->total() > 1 ? 's' : '' }} au total
            </p>
        </div>
        <a href="{{ route('clients.create') }}" class="btn btn-primary px-4">
            <i class="bi bi-plus-lg me-1"></i> Nouveau client
        </a>
    </div>

    {{-- Barre de recherche --}}
    <div class="card shadow-sm border-0 rounded-3 mb-4">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('clients.index') }}" class="row g-2 align-items-end">
                <div class="col-12 col-md-7">
                    <label for="search" class="form-label small fw-semibold text-muted mb-1">Rechercher</label>
                    <input
                        type="text"
                        id="search"
                        name="search"
                        class="form-control form-control-sm"
                        placeholder="Prénom, nom, e-mail ou téléphone…"
                        value="{{ $search ?? '' }}"
                    >
                </div>
                <div class="col-12 col-md-5 d-flex gap-2">
                    <button type="submit" class="btn btn-sm btn-outline-primary flex-grow-1">
                        <i class="bi bi-search me-1"></i>Rechercher
                    </button>
                    <a href="{{ route('clients.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-x-lg"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Notifications flash (succès / erreur) --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tableau des clients --}}
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            @if ($clients->isEmpty())
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <p class="text-muted mt-3 mb-1">
                        @if ($search ?? false)
                            Aucun client trouvé pour « {{ $search }} ».
                        @else
                            Aucun client enregistré.
                        @endif
                    </p>
                    <a href="{{ route('clients.create') }}" class="btn btn-sm btn-outline-primary mt-2">
                        Créer le premier client
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 text-uppercase small fw-semibold text-muted" style="width: 40px">#</th>
                                <th class="text-uppercase small fw-semibold text-muted">Client</th>
                                <th class="text-uppercase small fw-semibold text-muted">Email</th>
                                <th class="text-uppercase small fw-semibold text-muted text-center">Téléphone</th>
                                <th class="text-uppercase small fw-semibold text-muted">Adresse</th>
                                <th class="text-uppercase small fw-semibold text-muted text-center pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr>
                                    <td class="ps-4 text-muted small">
                                        {{ ($clients->currentPage() - 1) * $clients->perPage() + $loop->iteration }}
                                    </td>
                                    <td>
                                        <span class="fw-semibold text-dark">{{ $client->first_name }} {{ $client->last_name }}</span>
                                    </td>
                                    <td class="text-muted small">{{ $client->email }}</td>
                                    <td class="text-center">
                                        @if ($client->phone)
                                            {{ $client->phone }}
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="text-muted small">
                                        {{ Str::limit($client->address, 60, '…') ?: '—' }}
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('clients.edit', $client) }}"
                                               class="btn btn-sm btn-outline-secondary"
                                               title="Modifier">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('clients.destroy', $client) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Supprimer « {{ addslashes($client->first_name . ' ' . $client->last_name) }} » ? Cette action est irréversible.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger"
                                                        title="Supprimer">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($clients->hasPages())
                    <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top bg-light rounded-bottom-3">
                        <span class="text-muted small">
                            Affichage de {{ $clients->firstItem() }} à {{ $clients->lastItem() }}
                            sur {{ $clients->total() }} résultats
                        </span>
                        {{ $clients->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>

</div>
@endsection
