<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        // Tambahkan kolom sesuai skema Anda (mis: warranty_period_months)
        return Product::select('id', 'name', 'type', 'part_number', 'warranty_period_months')
            ->orderBy('name')
            ->get();
    }
}