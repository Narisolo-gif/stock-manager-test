<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    /**
     * Affiche la liste paginée des clients.
     * Accepte un paramètre ?search=terme pour rechercher par prénom, nom ou e-mail.
     * Route : GET /clients
     */
    public function index(Request $request)
    {
        $search = $request->query('search', '');
        $query = Client::query();

        // Recherche par prénom, nom ou e-mail
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $clients = $query->latest()->paginate(10)->withQueryString();

        return view('clients.index', compact('clients', 'search'));
    }

    /**
     * Affiche le formulaire de création d'un nouveau client.
     * Route : GET /clients/create
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Valide et enregistre un nouveau client en base.
     * Route : POST /clients
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'email', 'max:255', 'unique:clients,email'],
            'phone'      => ['nullable', 'string', 'max:30'],
            'address'    => ['nullable', 'string', 'max:2000'],
        ], [
            'first_name.required' => 'Le prénom est obligatoire.',
            'first_name.max'      => 'Le prénom ne peut pas dépasser 255 caractères.',
            'last_name.required'  => 'Le nom est obligatoire.',
            'last_name.max'       => 'Le nom ne peut pas dépasser 255 caractères.',
            'email.required'      => 'L’adresse e-mail est obligatoire.',
            'email.email'         => 'L’adresse e-mail doit être valide.',
            'email.unique'        => 'Cet e-mail est déjà utilisé par un autre client.',
            'email.max'           => 'L’adresse e-mail ne peut pas dépasser 255 caractères.',
            'phone.max'           => 'Le numéro de téléphone ne peut pas dépasser 30 caractères.',
            'address.max'         => 'L’adresse ne peut pas dépasser 2000 caractères.',
        ]);

        Client::create($validated);

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client créé avec succès.');
    }

    /**
     * Affiche le formulaire d'édition d'un client existant.
     * Route : GET /clients/{client}/edit
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Valide et met à jour un client existant en base.
     * Route : PUT/PATCH /clients/{client}
     */
    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('clients', 'email')->ignore($client->id),
            ],
            'phone'      => ['nullable', 'string', 'max:30'],
            'address'    => ['nullable', 'string', 'max:2000'],
        ], [
            'first_name.required' => 'Le prénom est obligatoire.',
            'first_name.max'      => 'Le prénom ne peut pas dépasser 255 caractères.',
            'last_name.required'  => 'Le nom est obligatoire.',
            'last_name.max'       => 'Le nom ne peut pas dépasser 255 caractères.',
            'email.required'      => 'L’adresse e-mail est obligatoire.',
            'email.email'         => 'L’adresse e-mail doit être valide.',
            'email.unique'        => 'Cet e-mail est déjà utilisé par un autre client.',
            'email.max'           => 'L’adresse e-mail ne peut pas dépasser 255 caractères.',
            'phone.max'           => 'Le numéro de téléphone ne peut pas dépasser 30 caractères.',
            'address.max'         => 'L’adresse ne peut pas dépasser 2000 caractères.',
        ]);

        $client->update($validated);

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client mis à jour avec succès.');
    }

    /**
     * Supprime un client de la base de données.
     * Route : DELETE /clients/{client}
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client supprimé avec succès.');
    }
}
