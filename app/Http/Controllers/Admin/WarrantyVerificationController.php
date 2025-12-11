<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WarrantyRegistration;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WarrantyVerificationController extends Controller
{
    /**
     * Display list of warranty registrations
     */
    public function index()
    {
        $registrations = WarrantyRegistration::with('product')
            ->latest()
            ->paginate(15);

        $stats = [
            'pending' => WarrantyRegistration::where('status', 'pending')->count(),
            'approved' => WarrantyRegistration::where('status', 'approved')->count(),
            'rejected' => WarrantyRegistration::where('status', 'rejected')->count(),
            'total' => WarrantyRegistration::count(),
        ];

        return view('admin.warranty.index', compact('registrations', 'stats'));
    }

    /**
     * Show detail warranty registration
     */
    public function show(WarrantyRegistration $registration)
    {
        $registration->load('product', 'approvedByUser', 'rejectedByUser');
        
        return view('admin.warranty.show', compact('registration'));
    }

    /**
     * Approve warranty registration
     */
    public function approve(Request $request, WarrantyRegistration $registration)
    {
        // Validasi status
        if ($registration->status !== 'pending') {
            return back()->with('error', 'Only pending registrations can be approved.');
        }

        $product = $registration->product;
        
        // Calculate warranty dates
        $warrantyStartDate = now()->toDateString();
        $warrantyEndDate = now()
            ->addMonths($product->warranty_period_months)
            ->toDateString();

        // Update registration
        $registration->update([
            'status' => 'approved',
            'warranty_start_date' => $warrantyStartDate,
            'warranty_end_date' => $warrantyEndDate,
            'approved_at' => now(),
            'approved_by' => auth()->id(),
        ]);

        return redirect()->route('admin.warranty.index')
            ->with('success', 'Warranty registration approved successfully. Warranty period: ' . $product->warranty_period_months . ' months');
    }

    /**
     * Reject warranty registration
     */
    public function reject(Request $request, WarrantyRegistration $registration)
    {
        // Validasi status
        if ($registration->status !== 'pending') {
            return back()->with('error', 'Only pending registrations can be rejected.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|min:10|max:1000',
        ]);

        // Update registration
        $registration->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'rejected_at' => now(),
            'rejected_by' => auth()->id(),
        ]);

        return redirect()->route('admin.warranty.index')
            ->with('success', 'Warranty registration rejected.');
    }
}