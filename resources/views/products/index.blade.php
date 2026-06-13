{{--
    Vue : products/index.blade.php
    Rôle : Liste paginée de tous les produits avec actions CRUD et recherche
    Données reçues : $products (LengthAwarePaginator), $search, $filter
--}}

@extends('layouts.app')

@section('title', 'Gestion des produits')

@section('content')
<div class="container py-4">

    {{-- En-tête de page --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">
                <i class="bi bi-box-seam me-2 text-primary"></i>Produits
            </h1>
            <p class="text-muted small mb-0">
                {{ $products->total() }} produit{{ $products->total() > 1 ? 's' : '' }} au total
            </p>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-primary px-4">
            <i class="bi bi-plus-lg me-1"></i> Nouveau produit
        </a>
    </div>

    {{-- Barre de recherche et filtres --}}
    <div class="card shadow-sm border-0 rounded-3 mb-4">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('products.index') }}" class="row g-2 align-items-end">
                <div class="col-12 col-md-7">
                    <label for="search" class="form-label small fw-semibold text-muted mb-1">Rechercher</label>
                    <input
                        type="text"
                        id="search"
                        name="search"
                        class="form-control form-control-sm"
                        placeholder="Nom ou description du produit…"
                        value="{{ $search ?? '' }}"
                    >
                </div>
                <div class="col-12 col-md-5 d-flex gap-2">
                    <button type="submit" class="btn btn-sm btn-outline-primary flex-grow-1">
                        <i class="bi bi-search me-1"></i>Rechercher
                    </button>
                    <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-secondary">
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

    {{-- Bandeau filtre actif --}}
    @if ($filter === 'low_stock')
        <div class="alert alert-warning border-0 shadow-sm d-flex justify-content-between align-items-center" role="alert">
            <span>
                <i class="bi bi-funnel-fill me-2"></i>
                Filtre actif : <strong>stock faible (≤ 5 unités)</strong> —
                {{ $products->total() }} produit{{ $products->total() > 1 ? 's' : '' }} concerné{{ $products->total() > 1 ? 's' : '' }}
            </span>
            <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-x-lg me-1"></i>Effacer le filtre
            </a>
        </div>
    @endif

    {{-- Tableau des produits --}}
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            @if ($products->isEmpty())
                {{-- État vide --}}
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <p class="text-muted mt-3 mb-1">
                        @if ($search ?? false)
                            Aucun produit trouvé pour « {{ $search }} ».
                        @else
                            Aucun produit enregistré.
                        @endif
                    </p>
                    <a href="{{ route('products.create') }}" class="btn btn-sm btn-outline-primary mt-2">
                        Créer le premier produit
                    </a>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 text-uppercase small fw-semibold text-muted" style="width: 40px">#</th>
                                <th class="text-uppercase small fw-semibold text-muted">Nom</th>
                                <th class="text-uppercase small fw-semibold text-muted">Description</th>
                                <th class="text-uppercase small fw-semibold text-muted text-end">Prix</th>
                                <th class="text-uppercase small fw-semibold text-muted text-center">Stock</th>
                                <th class="text-uppercase small fw-semibold text-muted text-center pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    {{-- Numéro de ligne absolu (tient compte de la pagination) --}}
                                    <td class="ps-4 text-muted small">
                                        {{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}
                                    </td>

                                    {{-- Nom du produit --}}
                                    <td>
                                        <span class="fw-semibold text-dark">{{ $product->name }}</span>
                                    </td>

                                    {{-- Description tronquée --}}
                                    <td class="text-muted small">
                                        {{ Str::limit($product->description, 60, '…') ?: '—' }}
                                    </td>

                                    {{-- Prix aligné à droite --}}
                                    <td class="text-end fw-semibold">
                                        {{ number_format($product->price, 2, ',', ' ') }} €
                                    </td>

                                    {{-- Badge de stock avec code couleur --}}
                                    <td class="text-center">
                                        @if ($product->quantity === 0)
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                                Rupture
                                            </span>
                                        @elseif ($product->quantity <= 5)
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle">
                                                {{ $product->quantity }} restant{{ $product->quantity > 1 ? 's' : '' }}
                                            </span>
                                        @else
                                            <span class="badge bg-success-subtle text-success border border-success-subtle">
                                                {{ $product->quantity }} en stock
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Actions --}}
                                    <td class="text-center pe-4">
                                        <div class="d-flex justify-content-center gap-2">
                                            {{-- Éditer --}}
                                            <a href="{{ route('products.edit', $product) }}"
                                               class="btn btn-sm btn-outline-secondary"
                                               title="Modifier">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            {{-- Supprimer --}}
                                            <form action="{{ route('products.destroy', $product) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Supprimer « {{ addslashes($product->name) }} » ? Cette action est irréversible.')">
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

                {{-- Pagination --}}
                @if ($products->hasPages())
                    <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top bg-light rounded-bottom-3">
                        <span class="text-muted small">
                            Affichage de {{ $products->firstItem() }} à {{ $products->lastItem() }}
                            sur {{ $products->total() }} résultats
                        </span>
                        {{ $products->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>

</div>
@endsection