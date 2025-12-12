<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSerialNumber;
use App\Models\WarehouseTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    /**
     * Display received products index
     */
    public function receivedIndex()
    {
        $transactions = WarehouseTransaction::with(['product', 'user'])
            ->where('type', 'received')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'total_transactions' => WarehouseTransaction::where('type', 'received')->count(),
            'total_quantity' => WarehouseTransaction::where('type', 'received')->sum('quantity'),
            'today_transactions' => WarehouseTransaction::where('type', 'received')
                ->whereDate('created_at', today())
                ->count(),
            'today_quantity' => WarehouseTransaction::where('type', 'received')
                ->whereDate('created_at', today())
                ->sum('quantity'),
        ];

        return view('admin.warehouse.received-index', compact('transactions', 'stats'));
    }

    /**
     * Show form to create received product
     */
    public function receivedCreate()
    {
        $products = Product::orderBy('part_number')->get();
        
        return view('admin.warehouse.received-create', compact('products'));
    }

    /**
     * Store received products and generate serial numbers
     */
    public function receivedStore(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:1000',
            'notes' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        
        try {
            $product = Product::findOrFail($request->product_id);
            $quantity = (int) $request->quantity;
            
            // 1. Create warehouse transaction
            $transaction = WarehouseTransaction::create([
                'product_id' => $product->id,
                'type' => 'received',
                'quantity' => $quantity,
                'notes' => $request->notes,
                'transaction_by' => auth()->id(),
            ]);

            // 2. Update product stock
            $product->increment('stock_quantity', $quantity);

            // 3. Generate serial numbers
            for ($i = 0; $i < $quantity; $i++) {
                $serialNumber = $product->generateSerialNumber();
                
                ProductSerialNumber::create([
                    'product_id' => $product->id,
                    'serial_number' => $serialNumber,
                    'status' => 'available',
                ]);
            }

            DB::commit();

            return redirect()
                ->route('admin.warehouse.received.print', ['transaction' => $transaction->id])
                ->with('success', "Product received successfully! {$quantity} serial numbers generated.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to process: ' . $e->getMessage()]);
        }
    }

    /**
     * Print serial numbers page
     */
    public function receivedPrint(WarehouseTransaction $transaction)
    {
        if ($transaction->type !== 'received') {
            abort(404);
        }

        $transaction->load(['product', 'user']);

        // Get serial numbers from this transaction
        // We'll get serials created around the transaction time
        $serialNumbers = ProductSerialNumber::where('product_id', $transaction->product_id)
            ->where('created_at', '>=', $transaction->created_at->subMinute())
            ->where('created_at', '<=', $transaction->created_at->addMinute())
            ->orderBy('serial_number')
            ->limit($transaction->quantity)
            ->get();

        return view('admin.warehouse.received-print', compact('transaction', 'serialNumbers'));
    }

    /**
     * Display issued products index
     */
    public function issuedIndex()
    {
        $transactions = WarehouseTransaction::with(['product', 'user'])
            ->where('type', 'issued')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'total_transactions' => WarehouseTransaction::where('type', 'issued')->count(),
            'total_quantity' => WarehouseTransaction::where('type', 'issued')->sum('quantity'),
            'today_transactions' => WarehouseTransaction::where('type', 'issued')
                ->whereDate('created_at', today())
                ->count(),
            'today_quantity' => WarehouseTransaction::where('type', 'issued')
                ->whereDate('created_at', today())
                ->sum('quantity'),
        ];

        return view('admin.warehouse.issued-index', compact('transactions', 'stats'));
    }

    /**
     * Show form to create issued product
     */
    public function issuedCreate()
    {
        $products = Product::where('stock_quantity', '>', 0)
            ->orderBy('part_number')
            ->get();
        
        return view('admin.warehouse.issued-create', compact('products'));
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
            'notes' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        
        try {
            $product = Product::findOrFail($request->product_id);
            $quantity = (int) $request->quantity;

            // Check stock availability
            if ($product->stock_quantity < $quantity) {
                return back()
                    ->withInput()
                    ->withErrors(['quantity' => "Insufficient stock. Available: {$product->stock_quantity} units"]);
            }
            
            // 1. Create warehouse transaction
            $transaction = WarehouseTransaction::create([
                'product_id' => $product->id,
                'type' => 'issued',
                'quantity' => $quantity,
                'destination' => $request->destination,
                'notes' => $request->notes,
                'transaction_by' => auth()->id(),
            ]);

            // 2. Update product stock
            $product->decrement('stock_quantity', $quantity);

            DB::commit();

            return redirect()
                ->route('admin.warehouse.issued.index')
                ->with('success', "Product issued successfully! {$quantity} units to {$request->destination}");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to process: ' . $e->getMessage()]);
        }
    }
}