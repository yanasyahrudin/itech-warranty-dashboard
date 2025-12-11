<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductReceivedLog;
use Illuminate\Http\Request;

class ProductReceivedController extends Controller
{
    public function index()
    {
        $logs = ProductReceivedLog::with(['product', 'receivedByUser'])
            ->latest()
            ->paginate(20);

        return view('admin.warehouse.received.index', compact('logs'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();

        return view('admin.warehouse.received.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        
        ProductReceivedLog::create([
            'product_id' => $validated['product_id'],
            'quantity' => $validated['quantity'],
            'received_by' => auth()->id(),
        ]);

        $product->incrementStock($validated['quantity']);

        return redirect()
            ->route('admin.warehouse.received.index')
            ->with('success', 'Product received and stock updated successfully.');
    }
}