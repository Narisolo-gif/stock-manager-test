{{--
    Vue : products/edit.blade.php
    Rôle : Formulaire de modification d'un produit existant
    Données reçues : $product (instance App\Models\Product)
--}}

@extends('layouts.app')

@section('title', 'Modifier « ' . $product->name . ' »')

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
                    <li class="breadcrumb-item active text-truncate" style="max-width: 200px">
                        {{ $product->name }}
                    </li>
                </ol>
            </nav>

            {{-- Carte formulaire --}}
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-semibold text-dark">
                        <i class="bi bi-pencil-square me-2 text-warning"></i>Modifier le produit
                    </h5>
                    {{-- Métadonnée : date de dernière mise à jour --}}
                    <span class="text-muted small">
                        Mis à jour {{ $product->updated_at->diffForHumans() }}
                    </span>
                </div>

                <div class="card-body p-4">
                    {{--
                        Formulaire de modification.
                        Laravel ne supporte pas PUT nativement en HTML,
                        on utilise @method('PUT') pour l'indiquer.
                    --}}
                    <form action="{{ route('products.update', $product) }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')

                        {{-- Nom --}}
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">
                                Nom du produit <span class="text-danger">*</span>
                            </label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                {{--
                                    old('name', $product->name) :
                                    si validation échoue → restaure la saisie (old)
                                    sinon → affiche la valeur en base ($product->name)
                                --}}
                                value="{{ old('name', $product->name) }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Ex : Clavier mécanique"
                                autofocus
                                maxlength="255"
                            >
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
                            >{{ old('description', $product->description) }}</textarea>
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
                                        value="{{ old('price', $product->price) }}"
                                        class="form-control @error('price') is-invalid @enderror"
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
                                        value="{{ old('quantity', $product->quantity) }}"
                                        class="form-control @error('quantity') is-invalid @enderror"
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
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">

                        

                            {{-- Annuler / Sauvegarder (à droite) --}}
                            <div class="d-flex gap-2">
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4">
                                    Annuler
                                </a>
                                <button type="submit" class="btn btn-warning px-4 text-dark fw-semibold">
                                    <i class="bi bi-check-lg me-1"></i>Mettre à jour
                                </button>
                            </div>

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
    updateCount(); // initialisation avec la valeur déjà en place
</script>
@endpush