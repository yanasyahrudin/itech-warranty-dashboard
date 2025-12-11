<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\WarrantyRegistration;
use Illuminate\Http\Request;

class WarrantyController extends Controller
{
    public function register()
    {
        $products = Product::where('stock_quantity', '>', 0)
            ->select('id', 'part_number', 'name', 'type', 'warranty_period_months')
            ->get();
        
        return view('warranty.register', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'serial_number' => 'required|unique:warranty_registrations|regex:/^[A-Z0-9\-]+$/i',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'additional_info' => 'nullable|string|max:1000',
            'invoice' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'serial_number.unique' => 'Serial number sudah terdaftar. Gunakan serial number yang lain.',
            'serial_number.regex' => 'Serial number hanya boleh mengandung huruf, angka, dan tanda (-)',
        ]);

        $invoice = $request->file('invoice');
        $invoicePath = $invoice->store('invoices', 'public');

        WarrantyRegistration::create([
            'product_id' => $validated['product_id'],
            'serial_number' => strtoupper($validated['serial_number']),
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'additional_info' => $validated['additional_info'],
            'invoice_path' => $invoicePath,
            'status' => 'pending',
        ]);

        return redirect()->route('warranty.success');
    }

    public function check()
    {
        return view('warranty.check');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'serial_number' => 'required|string',
        ]);

        $registration = WarrantyRegistration::where('serial_number', $request->serial_number)->first();

        if (!$registration) {
            return back()->with('error', 'Serial number not found');
        }

        return redirect()->route('warranty.status', $registration);
    }

    public function status(WarrantyRegistration $registration)
    {
        return view('warranty.status', compact('registration'));
    }

    public function success()
    {
        return view('warranty.success');
    }
}