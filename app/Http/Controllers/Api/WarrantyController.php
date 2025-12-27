<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\WarrantyRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class WarrantyController extends Controller
{
    protected function verifyCaptcha(string $token): bool
    {
        $secret = config('services.recaptcha.secret'); // GANTI dari env() ke config()

        \Log::info('=== Captcha Verification Start ===');
        \Log::info('Secret exists: ' . (!empty($secret) ? 'YES' : 'NO'));
        \Log::info('Secret value: ' . substr($secret ?? 'NULL', 0, 20));

        if (!$secret) {
            \Log::error('RECAPTCHA_SECRET_KEY not configured');
            return false;
        }

        if (!$token) {
            \Log::error('Captcha token is empty');
            return false;
        }

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secret,
            'response' => $token,
        ]);

        $result = $response->json();
        \Log::info('Google response:', $result);

        $success = $response->ok() && ($result['success'] ?? false) === true;
        \Log::info('Verification result: ' . ($success ? 'SUCCESS' : 'FAILED'));

        return $success;
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', Rule::exists('products', 'id')],
            'serial_number' => ['required', 'string', 'max:100', 'regex:/^[A-Z0-9\-]+$/i', 'unique:warranty_registrations,serial_number'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['nullable', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'purchase_date' => ['nullable', 'date', 'before_or_equal:today'],
            'additional_info' => ['nullable', 'string', 'max:1000'],
            'invoice' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'captcha_token' => ['required', 'string'],
        ], [
            'serial_number.regex' => 'Serial number hanya boleh mengandung huruf, angka, dan tanda (-).',
            'serial_number.unique' => 'Serial number sudah terdaftar. Gunakan serial number lain.',
        ]);

        if (!$this->verifyCaptcha($data['captcha_token'])) {
            return response()->json(['message' => 'Captcha verification failed'], 422);
        }

        $serial = strtoupper($data['serial_number']);

        if (Schema::hasTable('product_serials')) {
            $exists = DB::table('product_serials')
                ->where('product_id', $data['product_id'])
                ->where('serial_number', $serial)
                ->exists();
            if (!$exists) {
                return response()->json(['message' => 'Serial number not found for selected product'], 422);
            }
        }

        $path = $request->file('invoice')->store('invoices', 'public');

        $wr = WarrantyRegistration::create([
            'product_id' => $data['product_id'],
            'serial_number' => $serial,
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'] ?? null,
            'customer_phone' => $data['customer_phone'],
            'purchase_date' => $data['purchase_date'] ?? null,
            'additional_info' => $data['additional_info'] ?? null,
            'invoice_path' => $path,
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Warranty registration submitted. Waiting for admin verification (max 3 work days).',
            'registration_id' => $wr->id,
        ], 201);
    }

    public function status($serial)
    {
        $wr = WarrantyRegistration::with('product')
            ->where('serial_number', strtoupper($serial))
            ->first();

        if (!$wr) {
            return response()->json(['exists' => false, 'message' => 'Serial number tidak ditemukan'], 404);
        }

        return response()->json([
            'exists' => true,
            'registration_id' => $wr->id,
            'status' => $wr->status,
            'serial_number' => $wr->serial_number,
            'customer_name' => $wr->customer_name,
            'customer_phone' => $wr->customer_phone,
            'customer_email' => $wr->customer_email,
            'purchase_date' => $wr->purchase_date,
            'invoice_path' => $wr->invoice_path,
            'additional_info' => $wr->additional_info,
            'product' => [
                'id' => $wr->product->id,
                'name' => $wr->product->name,
                'type' => $wr->product->type,
                'part_number' => $wr->product->part_number,
                'warranty_period_months' => $wr->product->warranty_period_months,
            ],
            'approved_at' => $wr->approved_at,
            'warranty_start_date' => $wr->warranty_start_date,
            'warranty_end_date' => $wr->warranty_end_date,
            'rejection_reason' => $wr->rejection_reason,
        ]);
    }

    public function resubmit(Request $request, $id)
    {
        try {
            $warranty = WarrantyRegistration::find($id);
            if (!$warranty) return response()->json(['message' => 'Warranty not found'], 404);
            if ($warranty->status !== 'rejected') {
                return response()->json(['message' => 'Only rejected warranties can be resubmitted'], 422);
            }

            $data = $request->validate([
                'product_id'      => 'required|numeric',
                'serial_number'   => 'required|string|max:100',
                'customer_name'   => 'required|string|max:255',
                'customer_phone'  => 'required|string|max:20',
                'customer_email'  => 'nullable|email',
                'purchase_date'   => 'nullable|date',
                'additional_info' => 'nullable|string',
                'invoice'         => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
                'captcha_token'   => 'required|string',
            ]);

            if (!$this->verifyCaptcha($data['captcha_token'])) {
                return response()->json(['message' => 'Captcha verification failed'], 422);
            }

            $invoicePath = $warranty->invoice_path;
            if ($request->hasFile('invoice')) {
                if ($invoicePath && Storage::disk('public')->exists($invoicePath)) {
                    Storage::disk('public')->delete($invoicePath);
                }
                $invoicePath = $request->file('invoice')->store('invoices', 'public');
            }

            $warranty->update([
                'product_id'      => $data['product_id'],
                'serial_number'   => strtoupper($data['serial_number']),
                'customer_name'   => $data['customer_name'],
                'customer_email'  => $data['customer_email'] ?? null,
                'customer_phone'  => $data['customer_phone'],
                'purchase_date'   => $data['purchase_date'] ?? null,
                'invoice_path'    => $invoicePath,
                'additional_info' => $data['additional_info'] ?? null,
                'status'          => 'pending',
                'rejection_reason' => null,
            ]);

            return response()->json([
                'message' => 'Warranty resubmitted successfully',
                'registration_id' => $warranty->id,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
