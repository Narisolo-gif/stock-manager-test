{{--
    Vue : products/create.blade.php
    Rôle : Formulaire de création d'un nouveau produit
    Données reçues : aucune (nouveau produit vide)
--}}

@extends('layouts.app')

@section('title', 'Nouveau produit')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">

            {{-- Fil d'Ariane --}}
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item">
                        <a href="{{ route('products.index') }}" class="text-decoration-none">
                            <i class="bi bi-box-seam me-1"></i>Produits
                        </a>
                    </li>
                    <li class="breadcrumb-item active">Nouveau</li>
                </ol>
            </nav>

            {{-- Carte formulaire --}}
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h5 class="mb-0 fw-semibold text-dark">
                        <i class="bi bi-plus-circle me-2 text-primary"></i>Créer un produit
                    </h5>
                </div>

                <div class="card-body p-4">
                    {{--
                        Formulaire de création.
                        action  → route products.store (POST)
                        Pas de fichier ici, donc pas besoin de enctype multipart.
                    --}}
                    <form action="{{ route('products.store') }}" method="POST" novalidate>
                        @csrf

                        {{-- Nom --}}
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">
                                Nom du produit <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}"
                                placeholder="Ex : Clavier mécanique"
                                autofocus
                                maxlength="255"
                            >
                            {{-- Affichage de l'erreur de validation Laravel --}}
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold">
                                Description
                                <span class="text-muted fw-normal small">(facultatif)</span>
                            </label>
                            <textarea
                                id="description"
                                name="description"
                                rows="4"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Décrivez le produit brièvement…"
                                maxlength="2000"
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-end" id="desc-count">0 / 2000</div>
                        </div>

                        {{-- Prix et Quantité côte à côte --}}
                        <div class="row g-3 mb-4">
                            <div class="col-sm-6">
                                <label for="price" class="form-label fw-semibold">
                                    Prix (€) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input
                                        type="number"
                                        id="price"
                                        name="price"
                                        class="form-control @error('price') is-invalid @enderror"
                                        value="{{ old('price') }}"
                                        placeholder="0.00"
                                        min="0"
                                        step="0.01"
                                    >
                                    <span class="input-group-text">€</span>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label for="quantity" class="form-label fw-semibold">
                                    Quantité en stock <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input
                                        type="number"
                                        id="quantity"
                                        name="quantity"
                                        class="form-control @error('quantity') is-invalid @enderror"
                                        value="{{ old('quantity', 0) }}"
                                        min="0"
                                        step="1"
                                    >
                                    <span class="input-group-text">unités</span>
                                    @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Boutons d'action --}}
                        <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4">
                                Annuler
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-lg me-1"></i>Enregistrer
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Compteur de caractères pour la description
    const textarea = document.getElementById('description');
    const counter  = document.getElementById('desc-count');

    function updateCount() {
        const len = textarea.value.length;
        counter.textContent = len + ' / 2000';
        counter.classList.toggle('text-danger', len >= 1900);
    }

    textarea.addEventListener('input', updateCount);
    updateCount(); // initialisation si old() est rempli
</script>
@endpush