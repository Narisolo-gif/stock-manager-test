@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
<div class="container py-4">

    <div class="mb-4">
        <h1 class="h3 fw-bold text-dark mb-1">
            <i class="bi bi-speedometer2 me-2 text-primary"></i>Tableau de bord
        </h1>
        <p class="text-muted small mb-0">Bienvenue, {{ auth()->user()->name }}</p>
    </div>

    <div class="row g-4 mb-4">

        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="rounded-3 bg-primary bg-opacity-10 p-3">
                        <i class="bi bi-box-seam fs-3 text-primary"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-1 text-uppercase fw-semibold">Produits</p>
                        <p class="h2 fw-bold mb-0">{{ $productsCount }}</p>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top px-4 py-2">
                    <a href="{{ route('products.index') }}" class="text-primary small text-decoration-none fw-semibold">
                        Voir tous les produits <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="rounded-3 bg-success bg-opacity-10 p-3">
                        <i class="bi bi-people fs-3 text-success"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-1 text-uppercase fw-semibold">Clients</p>
                        <p class="h2 fw-bold mb-0">{{ $clientsCount }}</p>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top px-4 py-2">
                    <a href="{{ route('clients.index') }}" class="text-success small text-decoration-none fw-semibold">
                        Voir tous les clients <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="rounded-3 {{ $lowStock > 0 ? 'bg-danger bg-opacity-10' : 'bg-secondary bg-opacity-10' }} p-3">
                        <i class="bi bi-exclamation-triangle fs-3 {{ $lowStock > 0 ? 'text-danger' : 'text-secondary' }}"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-1 text-uppercase fw-semibold">Stock faible</p>
                        <p class="h2 fw-bold mb-0 {{ $lowStock > 0 ? 'text-danger' : '' }}">{{ $lowStock }}</p>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top px-4 py-2">
                    <a href="{{ $lowStock > 0 ? route('products.index', ['filter' => 'low_stock']) : route('products.index') }}"
                       class="{{ $lowStock > 0 ? 'text-danger' : 'text-secondary' }} small text-decoration-none fw-semibold">
                        {{ $lowStock > 0 ? 'Voir les produits critiques' : 'Tout est en ordre' }}
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 px-4 border-bottom">
            <h5 class="mb-0 fw-semibold">
                <i class="bi bi-lightning me-2 text-warning"></i>Accès rapides
            </h5>
        </div>
        <div class="card-body p-4">
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>Nouveau produit
                </a>
                <a href="{{ route('clients.create') }}" class="btn btn-success">
                    <i class="bi bi-person-plus me-1"></i>Nouveau client
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-list-ul me-1"></i>Liste des produits
                </a>
                <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-list-ul me-1"></i>Liste des clients
                </a>
            </div>
        </div>
    </div>

</div>
@endsection