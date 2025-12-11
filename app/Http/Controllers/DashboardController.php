<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\WarrantyRegistration;
use App\Models\WarehouseLog;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display user dashboard.
     */
    public function index(): View
    {
        return view('dashboard');
    }

    /**
     * Display admin dashboard.
     */
    public function adminDashboard(): View
    {
        $stats = [
            'total_products' => Product::count(),
            'total_registrations' => WarrantyRegistration::count(),
            'pending_registrations' => WarrantyRegistration::where('status', 'pending')->count(),
            'approved_registrations' => WarrantyRegistration::where('status', 'approved')->count(),
            'rejected_registrations' => WarrantyRegistration::where('status', 'rejected')->count(),
            'warehouse_logs' => WarehouseLog::count(),
        ];

        $recent_registrations = WarrantyRegistration::with('product', 'createdByUser')
            ->latest()
            ->limit(5)
            ->get();

        $recent_warehouse_logs = WarehouseLog::with('product', 'receivedByUser')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_registrations', 'recent_warehouse_logs'));
    }
}