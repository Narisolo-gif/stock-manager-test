{{--
    Vue : clients/create.blade.php
    Rôle : Formulaire de création d'un nouveau client
    Données reçues : aucune
--}}

@extends('layouts.app')

@section('title', 'Nouveau client')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">

            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item">
                        <a href="{{ route('clients.index') }}" class="text-decoration-none">
                            <i class="bi bi-people me-1"></i>Clients
                        </a>
                    </li>
                    <li class="breadcrumb-item active">Nouveau</li>
                </ol>
            </nav>

            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h5 class="mb-0 fw-semibold text-dark">
                        <i class="bi bi-plus-circle me-2 text-primary"></i>Créer un client
                    </h5>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('clients.store') }}" method="POST" novalidate>
                        @csrf

                        <div class="row g-3 mb-4">
                            <div class="col-sm-6">
                                <label for="first_name" class="form-label fw-semibold">
                                    Prénom <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="first_name"
                                    name="first_name"
                                    class="form-control @error('first_name') is-invalid @enderror"
                                    value="{{ old('first_name') }}"
                                    placeholder="Ex : Marie"
                                    maxlength="255"
                                    autofocus
                                >
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <label for="last_name" class="form-label fw-semibold">
                                    Nom <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="last_name"
                                    name="last_name"
                                    class="form-control @error('last_name') is-invalid @enderror"
                                    value="{{ old('last_name') }}"
                                    placeholder="Ex : Dupont"
                                    maxlength="255"
                                >
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">
                                Adresse e-mail <span class="text-danger">*</span>
                            </label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                placeholder="client@exemple.com"
                                maxlength="255"
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-sm-6">
                                <label for="phone" class="form-label fw-semibold">
                                    Téléphone
                                </label>
                                <input
                                    type="text"
                                    id="phone"
                                    name="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    value="{{ old('phone') }}"
                                    placeholder="Ex : 06 12 34 56 78"
                                    maxlength="30"
                                >
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <label for="address" class="form-label fw-semibold">
                                    Adresse
                                </label>
                                <textarea
                                    id="address"
                                    name="address"
                                    rows="2"
                                    class="form-control @error('address') is-invalid @enderror"
                                    placeholder="Rue, code postal, ville…"
                                    maxlength="2000"
                                >{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text text-end" id="address-count">{{ strlen(old('address', '')) }} / 2000</div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                            <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary px-4">
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
    const textarea = document.getElementById('address');
    const counter  = document.getElementById('address-count');

    function updateCount() {
        const len = textarea.value.length;
        counter.textContent = len + ' / 2000';
        counter.classList.toggle('text-danger', len >= 1900);
    }

    textarea.addEventListener('input', updateCount);
    updateCount();
</script>
@endpush
