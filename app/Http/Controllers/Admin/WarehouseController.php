<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\WarehouseLog;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /**
     * Display list of received products
     */
    public function receivedIndex()
    {
        $logs = WarehouseLog::where('type', 'received')
            ->with('product', 'receivedByUser')
            ->latest()
            ->paginate(15);

        $stats = [
            'total_received' => WarehouseLog::where('type', 'received')->sum('quantity'),
            'total_transactions' => WarehouseLog::where('type', 'received')->count(),
            'today_received' => WarehouseLog::where('type', 'received')
                ->whereDate('created_at', today())
                ->sum('quantity'),
        ];

        return view('admin.warehouse.received.index', compact('logs', 'stats'));
    }

    /**
     * Show form to receive new products
     */
    public function receivedCreate()
    {
        $products = Product::orderBy('part_number')->get();
        return view('admin.warehouse.received.create', compact('products'));
    }

    /**
     * Store received products
     */
    public function receivedStore(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:10000',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Create warehouse log
        WarehouseLog::create([
            'type' => 'received',
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'notes' => $request->notes,
            'received_by' => auth()->id(),
        ]);

        // Update product stock
        $product = Product::find($request->product_id);
        $product->increment('stock_quantity', $request->quantity);

        return redirect()->route('admin.warehouse.received.index')
            ->with('success', 'Product received successfully. Stock updated: ' . $product->part_number . ' (+' . $request->quantity . ')');
    }

    /**
     * Display list of issued products
     */
    public function issuedIndex()
    {
        $logs = WarehouseLog::where('type', 'issued')
            ->with('product', 'issuedByUser')
            ->latest()
            ->paginate(15);

        $stats = [
            'total_issued' => WarehouseLog::where('type', 'issued')->sum('quantity'),
            'total_transactions' => WarehouseLog::where('type', 'issued')->count(),
            'today_issued' => WarehouseLog::where('type', 'issued')
                ->whereDate('created_at', today())
                ->sum('quantity'),
        ];

        return view('admin.warehouse.issued.index', compact('logs', 'stats'));
    }

    /**
     * Show form to issue products
     */
    public function issuedCreate()
    {
        $products = Product::where('stock_quantity', '>', 0)
            ->orderBy('part_number')
            ->get();
        
        return view('admin.warehouse.issued.create', compact('products'));
    }

    /**
     * Store issued products
     */
    public function issuedStore(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'destination' => 'required|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        $product = Product::find($request->product_id);

        // Check stock availability
        if ($product->stock_quantity < $request->quantity) {
            return back()
                ->withInput()
                ->with('error', 'Insufficient stock. Available: ' . $product->stock_quantity . ' units');
        }

        // Create warehouse log
        WarehouseLog::create([
            'type' => 'issued',
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'destination' => $request->destination,
            'notes' => $request->notes,
            'issued_by' => auth()->id(),
        ]);

        // Update product stock
        $product->decrement('stock_quantity', $request->quantity);

        return redirect()->route('admin.warehouse.issued.index')
            ->with('success', 'Product issued successfully to: ' . $request->destination . ' (-' . $request->quantity . ')');
    }
}