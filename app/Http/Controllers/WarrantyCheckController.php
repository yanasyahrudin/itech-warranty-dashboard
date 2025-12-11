<?php

namespace App\Http\Controllers;

use App\Models\WarrantyRegistration;
use Illuminate\Http\Request;

class WarrantyCheckController extends Controller
{
    /**
     * Display warranty check form
     */
    public function index()
    {
        return view('warranty.check');
    }

    /**
     * Search warranty by serial number
     */
    public function search(Request $request)
    {
        $request->validate([
            'serial_number' => 'required|string|min:3',
        ], [
            'serial_number.required' => 'Please enter a serial number',
            'serial_number.min' => 'Serial number must be at least 3 characters',
        ]);

        $serialNumber = strtoupper($request->input('serial_number'));

        // Search for warranty registration
        $warranty = WarrantyRegistration::with('product')
            ->where('serial_number', 'LIKE', '%' . $serialNumber . '%')
            ->first();

        // If searching via AJAX
        if ($request->wantsJson()) {
            if (!$warranty) {
                return response()->json([
                    'found' => false,
                    'message' => 'No warranty found for this serial number',
                ], 404);
            }

            return response()->json([
                'found' => true,
                'warranty' => [
                    'serial_number' => $warranty->serial_number,
                    'status' => $warranty->status,
                    'product_name' => $warranty->product->name,
                    'product_type' => $warranty->product->type,
                    'part_number' => $warranty->product->part_number,
                    'warranty_start_date' => $warranty->warranty_start_date?->format('d M Y'),
                    'warranty_end_date' => $warranty->warranty_end_date?->format('d M Y'),
                    'is_active' => $warranty->isActive(),
                    'is_expired' => $warranty->isExpired(),
                    'customer_name' => $warranty->customer_name,
                    'rejection_reason' => $warranty->rejection_reason,
                ]
            ]);
        }

        // Regular request - redirect to detail
        if ($warranty) {
            return redirect()->route('warranty.detail', ['warranty' => $warranty->id]);
        }

        return back()->withErrors(['serial_number' => 'Serial number not found']);
    }

    /**
     * Display warranty detail by serial number
     */
    public function detail(WarrantyRegistration $warranty)
    {
        $warranty->load('product');

        // Determine warranty status
        $warrantyStatus = match($warranty->status) {
            'pending' => [
                'label' => 'Pending Verification',
                'badge_class' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                'icon' => '⏳',
                'description' => 'Your warranty registration is waiting for verification.',
            ],
            'approved' => [
                'label' => $warranty->isActive() ? 'Active Warranty' : 'Warranty Expired',
                'badge_class' => $warranty->isActive() 
                    ? 'bg-green-100 text-green-800 border-green-200'
                    : 'bg-red-100 text-red-800 border-red-200',
                'icon' => $warranty->isActive() ? '✅' : '❌',
                'description' => $warranty->isActive()
                    ? 'Your warranty is currently active and valid.'
                    : 'Your warranty has expired.',
            ],
            'rejected' => [
                'label' => 'Registration Rejected',
                'badge_class' => 'bg-red-100 text-red-800 border-red-200',
                'icon' => '❌',
                'description' => 'Your warranty registration was not approved.',
            ],
            default => [
                'label' => 'Unknown Status',
                'badge_class' => 'bg-gray-100 text-gray-800 border-gray-200',
                'icon' => '❓',
                'description' => 'Unable to determine warranty status.',
            ],
        };

        // Calculate warranty duration (days remaining)
        $daysRemaining = null;
        if ($warranty->warranty_end_date) {
            $daysRemaining = max(0, now()->diffInDays($warranty->warranty_end_date, false));
        }

        return view('warranty.detail', compact('warranty', 'warrantyStatus', 'daysRemaining'));
    }
}