<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Client;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord avec les statistiques globales.
     * Route : GET /dashboard (middleware auth)
     */
    public function index()
    {
        // Nombre total de produits
        $productsCount = Product::count();

        // Nombre total de clients
        $clientsCount = Client::count();

        // Produits avec stock faible (quantité <= 5)
        $lowStock = Product::where('quantity', '<=', 5)->count();

        return view('dashboard', compact('productsCount', 'clientsCount', 'lowStock'));
    }
}