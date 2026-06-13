<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Stock Manager') — Stock Manager</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', system-ui, sans-serif; }
        .navbar-brand { font-weight: 700; letter-spacing: -0.3px; }
        footer { font-size: .85rem; }
        /* Avatar initiales */
        .avatar-initials {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: #6366f1;
            color: #fff;
            font-size: .75rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-transform: uppercase;
        }
    </style>

    @stack('styles')
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">

            {{-- Logo --}}
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="bi bi-boxes me-2"></i>Stock Manager
            </a>

            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">

                {{-- Liens principaux --}}
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                           href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2 me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}"
                           href="{{ route('products.index') }}">
                            <i class="bi bi-box-seam me-1"></i>Produits
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}"
                           href="{{ route('clients.index') }}">
                            <i class="bi bi-people me-1"></i>Clients
                        </a>
                    </li>
                </ul>

                {{-- Menu utilisateur (affiché uniquement si connecté) --}}
                @auth
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">

                        {{-- Bouton déclencheur du dropdown --}}
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2"
                           href="#" role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            {{-- Avatar avec les initiales de l'utilisateur --}}
                            <span class="avatar-initials">
                                {{ mb_substr(auth()->user()->name, 0, 1) }}
                            </span>
                            <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-1">

                            {{-- Infos du compte --}}
                            <li>
                                <div class="dropdown-header py-2">
                                    <div class="fw-semibold text-dark">{{ auth()->user()->name }}</div>
                                    <div class="text-muted small">{{ auth()->user()->email }}</div>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider my-1"></li>

                            {{-- Profil --}}
                            <li>
                                <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person-circle me-2 text-muted"></i>Mon profil
                                </a>
                            </li>

                            <li><hr class="dropdown-divider my-1"></li>

                            {{--
                                Déconnexion — doit être un POST (sécurité CSRF).
                                On utilise un formulaire caché déclenché par un lien.
                            --}}
                            <li>
                                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                    @csrf
                                </form>
                                <a class="dropdown-item py-2 text-danger"
                                   href="#"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i>Se déconnecter
                                </a>
                            </li>

                        </ul>
                    </li>
                </ul>
                @endauth

            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="text-center text-muted py-4 mt-5 border-top bg-white">
        <div class="container">
            &copy; {{ date('Y') }} Stock Manager
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

</body>
</html>