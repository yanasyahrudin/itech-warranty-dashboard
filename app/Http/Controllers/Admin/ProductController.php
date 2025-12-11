<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Product::orderBy('part_number')->paginate(15);
        
        $stats = [
            'total_products' => Product::count(),
            'total_stock' => Product::sum('stock_quantity'),
            'low_stock' => Product::where('stock_quantity', '<=', 10)->count(),
            'product_types' => Product::distinct('type')->count('type'),
        ];

        return view('admin.products.index', compact('products', 'stats'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        // Get distinct product types for suggestions
        $productTypes = Product::distinct()->pluck('type')->filter();
        
        return view('admin.products.create', compact('productTypes'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'part_number' => 'required|string|max:100|unique:products,part_number',
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'warranty_period_months' => 'required|integer|min:1|max:120',
            'stock_quantity' => 'nullable|integer|min:0',
            'description' => 'nullable|string|max:1000',
        ], [
            'part_number.required' => 'Part number is required',
            'part_number.unique' => 'Part number already exists',
            'name.required' => 'Product name is required',
            'type.required' => 'Product type is required',
            'warranty_period_months.required' => 'Warranty period is required',
            'warranty_period_months.min' => 'Warranty period must be at least 1 month',
            'warranty_period_months.max' => 'Warranty period cannot exceed 120 months',
        ]);

        $product = Product::create([
            'part_number' => strtoupper($request->part_number),
            'name' => $request->name,
            'type' => $request->type,
            'warranty_period_months' => $request->warranty_period_months,
            'stock_quantity' => $request->stock_quantity ?? 0,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully! Part Number: ' . $product->part_number);
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load(['warrantyRegistrations' => function($query) {
            $query->latest()->take(10);
        }]);

        $stats = [
            'total_registrations' => $product->warrantyRegistrations()->count(),
            'active_warranties' => $product->warrantyRegistrations()
                ->where('status', 'approved')
                ->where('warranty_end_date', '>=', now())
                ->count(),
            'pending_approvals' => $product->warrantyRegistrations()
                ->where('status', 'pending')
                ->count(),
            'current_stock' => $product->stock_quantity,
        ];

        return view('admin.products.show', compact('product', 'stats'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $productTypes = Product::distinct()->pluck('type')->filter();
        
        return view('admin.products.edit', compact('product', 'productTypes'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'part_number' => 'required|string|max:100|unique:products,part_number,' . $product->id,
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'warranty_period_months' => 'required|integer|min:1|max:120',
            'stock_quantity' => 'nullable|integer|min:0',
            'description' => 'nullable|string|max:1000',
        ]);

        $product->update([
            'part_number' => strtoupper($request->part_number),
            'name' => $request->name,
            'type' => $request->type,
            'warranty_period_months' => $request->warranty_period_months,
            'stock_quantity' => $request->stock_quantity ?? 0,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // Check if product has warranty registrations
        if ($product->warrantyRegistrations()->count() > 0) {
            return back()->with('error', 'Cannot delete product that has warranty registrations. Please archive it instead.');
        }

        $partNumber = $product->part_number;
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully: ' . $partNumber);
    }
}