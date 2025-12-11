<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // SQLite doesn't support RENAME COLUMN directly in older versions
        // We'll use a workaround
        
        // Add new columns
        if (!Schema::hasColumn('warranty_registrations', 'verified_by')) {
            Schema::table('warranty_registrations', function (Blueprint $table) {
                $table->foreignId('verified_by')->nullable()->after('status');
                $table->timestamp('verified_at')->nullable()->after('verified_by');
            });
            
            // Copy data from approved_by/approved_at to verified_by/verified_at
            DB::statement('UPDATE warranty_registrations SET verified_by = approved_by, verified_at = approved_at WHERE status = "approved"');
            DB::statement('UPDATE warranty_registrations SET verified_by = rejected_by, verified_at = rejected_at WHERE status = "rejected"');
        }
        
        // Add purchase_date if not exists
        if (!Schema::hasColumn('warranty_registrations', 'purchase_date')) {
            Schema::table('warranty_registrations', function (Blueprint $table) {
                $table->date('purchase_date')->nullable()->after('customer_phone');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warranty_registrations', function (Blueprint $table) {
            if (Schema::hasColumn('warranty_registrations', 'verified_by')) {
                $table->dropColumn(['verified_by', 'verified_at']);
            }
        });
    }
};