<?php

namespace App\Http\Controllers;

use App\Models\WarrantyRegistration;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

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
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'purchase_date' => 'required|date|before_or_equal:today',
            'invoice' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
            'additional_info' => 'nullable|string|max:1000',
            'g-recaptcha-response' => 'required',
        ], [
            'product_id.required' => 'Please select a product',
            'product_id.exists' => 'Selected product is invalid',
            'serial_number.required' => 'Serial number is required',
            'serial_number.unique' => 'This serial number has already been registered',
            'customer_name.required' => 'Please enter your name',
            'customer_email.email' => 'Please enter a valid email address',
            'customer_phone.required' => 'Please enter your phone number',
            'purchase_date.required' => 'Please enter the purchase date',
            'purchase_date.before_or_equal' => 'Purchase date cannot be in the future',
            'invoice.required' => 'Please upload an invoice',
            'invoice.file' => 'Invoice must be a file',
            'invoice.mimes' => 'Invoice must be a PDF or image (JPG, PNG)',
            'invoice.max' => 'Invoice file cannot be larger than 5MB',
            'g-recaptcha-response.required' => 'Please complete the reCAPTCHA verification',
        ]);


        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!($response->json()['success'] ?? false)) {
            return back()->withErrors([
                'g-recaptcha-response' => 'Verifikasi reCAPTCHA gagal. Coba lagi.'
            ])->withInput();
        }

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
            ->with('success', 'Pendaftaran garansi berhasil diajukan! Kami akan memprosesnya dalam waktu 3 hari kerja.');
    }

    /**
     * Show form to resubmit rejected warranty
     */
    public function edit(WarrantyRegistration $warranty)
    {
        // Only allow editing rejected warranties
        if ($warranty->status !== 'rejected') {
            return redirect()->route('warranty.detail', $warranty)
                ->with('error', 'Anda hanya dapat mengajukan ulang garansi yang ditolak.');
        }

        $products = Product::orderBy('part_number')->get();

        return view('warranty.resubmit', compact('warranty', 'products'));
    }

    /**
     * Update and resubmit rejected warranty
     */
    public function update(Request $request, WarrantyRegistration $warranty)
    {
        // Only allow updating rejected warranties
        if ($warranty->status !== 'rejected') {
            return redirect()->route('warranty.detail', $warranty)
                ->with('error', 'Anda hanya dapat mengajukan ulang garansi yang ditolak.');
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'serial_number' => 'required|string|unique:warranty_registrations,serial_number,' . $warranty->id,
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'nullable|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'purchase_date' => 'required|date|before_or_equal:today',
            'invoice' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // Optional for resubmission
            'additional_info' => 'nullable|string|max:1000',
            'g-recaptcha-response' => 'required',
        ], [
            'product_id.required' => 'Silakan pilih produk',
            'product_id.exists' => 'Produk yang dipilih tidak valid',
            'serial_number.required' => 'Nomor seri wajib diisi',
            'serial_number.unique' => 'Nomor seri ini sudah terdaftar',
            'customer_name.required' => 'Silakan masukkan nama Anda',
            'customer_email.email' => 'Silakan masukkan alamat email yang valid',
            'customer_phone.required' => 'Silakan masukkan nomor telepon Anda',
            'purchase_date.required' => 'Silakan masukkan tanggal pembelian',
            'purchase_date.before_or_equal' => 'Tanggal pembelian tidak boleh di masa depan',
            'invoice.file' => 'Invoice harus berupa file',
            'invoice.mimes' => 'Invoice harus berupa PDF atau gambar (JPG, PNG)',
            'invoice.max' => 'Ukuran file invoice tidak boleh lebih dari 5MB',
            'g-recaptcha-response.required' => 'Silakan selesaikan verifikasi reCAPTCHA',
        ]);

        // Verify reCAPTCHA
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!($response->json()['success'] ?? false)) {
            return back()->withErrors([
                'g-recaptcha-response' => 'Verifikasi reCAPTCHA gagal. Coba lagi.'
            ])->withInput();
        }

        // Update invoice if new file uploaded
        $invoicePath = $warranty->invoice_path;
        if ($request->hasFile('invoice')) {
            // Delete old invoice
            if ($invoicePath && Storage::disk('public')->exists($invoicePath)) {
                Storage::disk('public')->delete($invoicePath);
            }
            // Store new invoice
            $invoicePath = $request->file('invoice')->store('invoices', 'public');
        }

        // Update warranty registration
        $warranty->update([
            'product_id' => $request->product_id,
            'serial_number' => strtoupper($request->serial_number),
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'purchase_date' => $request->purchase_date,
            'invoice_path' => $invoicePath,
            'additional_info' => $request->additional_info,
            'status' => 'pending',
            'rejection_reason' => null,
            'rejected_at' => null,
            'rejected_by' => null,
        ]);

        return redirect()->route('warranty.detail', $warranty)
            ->with('success', 'Pengajuan garansi berhasil diajukan ulang! Kami akan memprosesnya dalam waktu 3 hari kerja.');
    }
}
