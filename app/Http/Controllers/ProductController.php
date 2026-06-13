<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Affiche la liste paginée des produits.
     * Accepte un paramètre optionnel ?filter=low_stock pour n'afficher
     * que les produits dont la quantité est inférieure ou égale à 5.
     * Accepte aussi ?search=terme pour rechercher par nom ou description.
     * Route : GET /products
     */
    public function index(Request $request)
    {
        $filter = $request->query('filter');
        $search = $request->query('search', '');

        $query = Product::query();

        // Filtre stock faible : quantité <= 5
        if ($filter === 'low_stock') {
            $query->where('quantity', '<=', 5);
        }

        // Recherche par nom ou description
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->latest()->paginate(10)->withQueryString();

        return view('products.index', compact('products', 'filter', 'search'));
    }

    /**
     * Affiche le formulaire de création d'un nouveau produit.
     * Route : GET /products/create
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Valide et enregistre un nouveau produit en base.
     * Route : POST /products
     */
    public function store(Request $request)
    {
        // Validation des données entrantes selon les règles métier
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'price'       => ['required', 'numeric', 'min:0', 'decimal:0,2'],
            'quantity'    => ['required', 'integer', 'min:0'],
        ], [
            // Messages d'erreur personnalisés en français
            'name.required'     => 'Le nom du produit est obligatoire.',
            'name.max'          => 'Le nom ne peut pas dépasser 255 caractères.',
            'price.required'    => 'Le prix est obligatoire.',
            'price.numeric'     => 'Le prix doit être un nombre valide.',
            'price.min'         => 'Le prix ne peut pas être négatif.',
            'price.decimal'     => 'Le prix accepte au maximum 2 décimales.',
            'quantity.required' => 'La quantité est obligatoire.',
            'quantity.integer'  => 'La quantité doit être un nombre entier.',
            'quantity.min'      => 'La quantité ne peut pas être négative.',
        ]);

        // Création du produit avec les données validées (mass assignment sécurisé)
        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produit créé avec succès.');
    }

    /**
     * Affiche le détail d'un produit spécifique.
     * Route : GET /products/{product}
     * Utilise le route model binding de Laravel.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Affiche le formulaire d'édition d'un produit existant.
     * Route : GET /products/{product}/edit
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Valide et met à jour un produit existant en base.
     * Route : PUT/PATCH /products/{product}
     */
    public function update(Request $request, Product $product)
    {
        // Même règles de validation que pour la création
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'price'       => ['required', 'numeric', 'min:0', 'decimal:0,2'],
            'quantity'    => ['required', 'integer', 'min:0'],
        ], [
            'name.required'     => 'Le nom du produit est obligatoire.',
            'name.max'          => 'Le nom ne peut pas dépasser 255 caractères.',
            'price.required'    => 'Le prix est obligatoire.',
            'price.numeric'     => 'Le prix doit être un nombre valide.',
            'price.min'         => 'Le prix ne peut pas être négatif.',
            'price.decimal'     => 'Le prix accepte au maximum 2 décimales.',
            'quantity.required' => 'La quantité est obligatoire.',
            'quantity.integer'  => 'La quantité doit être un nombre entier.',
            'quantity.min'      => 'La quantité ne peut pas être négative.',
        ]);

        // Mise à jour uniquement des champs fillable validés
        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', 'Produit mis à jour avec succès.');
    }

    /**
     * Supprime un produit de la base de données.
     * Route : DELETE /products/{product}
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Produit supprimé avec succès.');
    }
}