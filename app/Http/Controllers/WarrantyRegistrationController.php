<?php

namespace App\Http\Controllers;

use App\Models\WarrantyRegistration;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WarrantyRegistrationController extends Controller
{
    /**
     * Display warranty registration form
     */
    public function create()
    {
        $products = Product::orderBy('part_number')->get();
        
        return view('warranty.register', compact('products'));
    }

    /**
     * Store warranty registration
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'serial_number' => 'required|string|unique:warranty_registrations,serial_number',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'purchase_date' => 'required|date|before_or_equal:today',
            'invoice' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
            'additional_info' => 'nullable|string|max:1000',
        ], [
            'product_id.required' => 'Please select a product',
            'product_id.exists' => 'Selected product is invalid',
            'serial_number.required' => 'Serial number is required',
            'serial_number.unique' => 'This serial number has already been registered',
            'customer_name.required' => 'Please enter your name',
            'customer_email.required' => 'Please enter your email',
            'customer_email.email' => 'Please enter a valid email address',
            'customer_phone.required' => 'Please enter your phone number',
            'purchase_date.required' => 'Please enter the purchase date',
            'purchase_date.before_or_equal' => 'Purchase date cannot be in the future',
            'invoice.required' => 'Please upload an invoice',
            'invoice.file' => 'Invoice must be a file',
            'invoice.mimes' => 'Invoice must be a PDF or image (JPG, PNG)',
            'invoice.max' => 'Invoice file cannot be larger than 5MB',
        ]);

        // Store invoice file
        $invoicePath = $request->file('invoice')->store('invoices', 'public');

        // Create warranty registration
        $warranty = WarrantyRegistration::create([
            'product_id' => $request->product_id,
            'serial_number' => strtoupper($request->serial_number),
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'purchase_date' => $request->purchase_date,
            'invoice_path' => $invoicePath,
            'additional_info' => $request->additional_info,
            'status' => 'pending',
        ]);

        return redirect()->route('warranty.register')
            ->with('success', 'Warranty registration submitted successfully! Please check your email for confirmation.');
    }
}