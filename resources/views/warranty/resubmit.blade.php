<!-- filepath: resources/views/warranty/resubmit.blade.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Ulang Garansi - Itech Smart Choice</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body class="bg-gradient-to-r from-gray-400 to-gray-600">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-sm border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <div class="flex items-center">
                    <div class="text-2xl font-bold text-gray-600">
                        <img src="https://res.cloudinary.com/dcbryptkx/image/upload/v1765004406/itech-warranty-qr/LogoItech_z57jdx.png" alt="" class="h-14 w-auto">
                    </div>
                    <span class="hidden lg:block ml-2 text-gray-600">Sistem Garansi</span>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('warranty.detail', $warranty) }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm">
                        Kembali ke Detail
                    </a>
                    <a href="{{ route('warranty.check') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm">
                        Cek Garansi
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full">

            <!-- Page Title -->
            <div class="text-center mb-8 text-white">
                <h1 class="text-4xl font-bold mb-4">Ajukan Ulang Garansi</h1>
                <p class="text-lg">Perbaiki informasi yang salah dan ajukan ulang pendaftaran garansi Anda</p>
            </div>

            <!-- Rejection Reason Notice -->
            @if($warranty->rejection_reason)
            <div class="mb-6 p-4 bg-red-50 border-2 border-red-200 rounded-xl">
                <h3 class="font-semibold text-red-900 mb-2 flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Alasan Penolakan:
                </h3>
                <p class="text-sm text-red-800">{{ $warranty->rejection_reason }}</p>
                <p class="text-xs text-red-600 mt-3">
                    Silakan perbaiki informasi di bawah sesuai dengan alasan penolakan di atas.
                </p>
            </div>
            @endif

            <!-- Success Message -->
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                <div class="flex">
                    <svg class="h-5 w-5 text-green-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm text-green-800">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            <!-- Error Message -->
            @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                <div class="flex">
                    <svg class="h-5 w-5 text-red-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <p class="text-sm text-red-800">{{ session('error') }}</p>
                </div>
            </div>
            @endif

            <!-- Resubmission Form -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <form method="POST" action="{{ route('warranty.resubmit.update', $warranty) }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Step 1: Product Selection -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            <span class="flex items-center justify-center w-8 h-8 bg-indigo-600 text-white rounded-full mr-3">1</span>
                            Pilih Produk Anda
                        </h2>

                        <div class="mb-4">
                            <label for="product_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Produk <span class="text-red-500">*</span>
                            </label>
                            <select name="product_id" id="product_id"
                                class="rounded-xl w-full px-3 py-2 shadow-[0_2px_4px_rgba(0,0,0,0.15)] @error('product_id') border-red-500 @enderror"
                                required>
                                <option value="">-- Pilih Produk --</option>
                                @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ (old('product_id', $warranty->product_id) == $product->id) ? 'selected' : '' }}>
                                    {{ $product->name }} ({{ $product->part_number }})
                                </option>
                                @endforeach
                            </select>
                            @error('product_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Pilih produk yang ingin Anda daftarkan garansinya</p>
                        </div>

                        <!-- Product Info Display -->
                        <div id="productInfo" class="mt-4 p-4 bg-indigo-50 border border-indigo-200 rounded-xl {{ old('product_id', $warranty->product_id) ? '' : 'hidden' }}">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-indigo-700 font-semibold">Part Number</p>
                                    <p class="text-sm text-indigo-900" id="partNumber">{{ $warranty->product->part_number ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-indigo-700 font-semibold">Periode Garansi</p>
                                    <p class="text-sm text-indigo-900" id="warrantyPeriod">{{ $warranty->product->warranty_period_months ?? '-' }} bulan</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Serial Number & Purchase Info -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            <span class="flex items-center justify-center w-8 h-8 bg-indigo-600 text-white rounded-full mr-3">2</span>
                            Nomor Seri & Informasi Pembelian
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Serial Number -->
                            <div>
                                <label for="serial_number" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nomor Seri <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="serial_number" id="serial_number"
                                    value="{{ old('serial_number', $warranty->serial_number) }}"
                                    class="rounded-xl w-full px-3 py-2 shadow-[inset_0_2px_4px_rgba(0,0,0,0.15)] @error('serial_number') border-red-500 @enderror uppercase"
                                    placeholder="e.g., CASE-FULL-TOWER-01-00001"
                                    style="text-transform: uppercase;"
                                    required>
                                @error('serial_number')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Ditemukan pada label produk atau kode QR</p>
                            </div>

                            <!-- Purchase Date -->
                            <div>
                                <label for="purchase_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tanggal Pembelian <span class="text-red-500">*</span>
                                </label>

                                <input type="date" name="purchase_date" id="purchase_date"
                                    value="{{ old('purchase_date', $warranty->purchase_date?->format('Y-m-d')) }}"
                                    class="rounded-xl w-full px-3 py-2 shadow-[0_2px_4px_rgba(0,0,0,0.15)] @error('purchase_date') border-red-500 @enderror"
                                    required>
                                @error('purchase_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Tanggal Anda membeli produk ini</p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Customer Information -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            <span class="flex items-center justify-center w-8 h-8 bg-indigo-600 text-white rounded-full mr-3">3</span>
                            Informasi Anda
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Name -->
                            <div>
                                <label for="customer_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Lengkap/Nama Perusahaan <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="customer_name" id="customer_name"
                                    value="{{ old('customer_name', $warranty->customer_name) }}"
                                    class="rounded-xl w-full px-3 py-2 shadow-[inset_0_2px_4px_rgba(0,0,0,0.15)] @error('customer_name') border-red-500 @enderror"
                                    placeholder="Nama lengkap Anda/Nama perusahaan"
                                    required>
                                @error('customer_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="customer_phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nomor Handphone <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" name="customer_phone" id="customer_phone"
                                    value="{{ old('customer_phone', $warranty->customer_phone) }}"
                                    class="rounded-xl w-full px-3 py-2 shadow-[inset_0_2px_4px_rgba(0,0,0,0.15)] @error('customer_phone') border-red-500 @enderror"
                                    placeholder="+62 XXX-XXXX-XXXX"
                                    required>
                                @error('customer_phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="md:col-span-2">
                                <label for="customer_email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email Address
                                </label>
                                <input type="email" name="customer_email" id="customer_email"
                                    value="{{ old('customer_email', $warranty->customer_email) }}"
                                    class="rounded-xl w-full px-3 py-2 shadow-[inset_0_2px_4px_rgba(0,0,0,0.15)] @error('customer_email') border-red-500 @enderror"
                                    placeholder="email.anda@contoh.com">
                                @error('customer_email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Invoice Upload -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            <span class="flex items-center justify-center w-8 h-8 bg-indigo-600 text-white rounded-full mr-3">4</span>
                            Unggah Invoice Pembelian
                        </h2>

                        <!-- Current Invoice Info -->
                        @if($warranty->invoice_path)
                        <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                            <p class="text-sm text-blue-900 font-semibold mb-2">Invoice Saat Ini:</p>
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span class="text-sm text-blue-800">{{ basename($warranty->invoice_path) }}</span>
                                <a href="{{ Storage::url($warranty->invoice_path) }}" target="_blank" class="ml-4 text-sm text-blue-600 hover:text-blue-900 underline">
                                    Lihat File
                                </a>
                            </div>
                            <p class="text-xs text-blue-700 mt-2">Biarkan kosong jika tidak ingin mengganti invoice</p>
                        </div>
                        @endif

                        <div class="mb-4">
                            <label for="invoice" class="block text-sm font-semibold text-gray-700 mb-2">
                                Dokumen Invoice {{ $warranty->invoice_path ? '(Opsional - Unggah hanya jika ingin mengganti)' : '' }} <span class="text-red-500">{{ !$warranty->invoice_path ? '*' : '' }}</span>
                            </label>

                            <!-- File Upload Area -->
                            <div class="border-2 border-dashed rounded-xl p-6 text-center hover:border-indigo-500 transition"
                                id="uploadArea">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                <p class="text-sm text-gray-600 mb-2">Seret dan lepas invoice Anda di sini, atau klik untuk memilih</p>
                                <input type="file" name="invoice" id="invoice"
                                    class="hidden"
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    {{ !$warranty->invoice_path ? 'required' : '' }}>
                                <p class="text-xs text-gray-500">Format yang didukung: PDF, JPG, PNG (Maks 5MB)</p>
                            </div>

                            @error('invoice')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <!-- File Preview -->
                            <div id="filePreview" class="mt-4 hidden">
                                <p class="text-sm font-semibold text-gray-700 mb-2">File yang Dipilih:</p>
                                <div class="flex items-center p-3 bg-indigo-50 border border-indigo-200 rounded-xl">
                                    <svg class="h-6 w-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-900" id="fileName">-</p>
                                        <p class="text-xs text-gray-600" id="fileSize">-</p>
                                    </div>
                                    <button type="button" onclick="clearFile()" class="text-red-600 hover:text-red-900">
                                        ✕
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                       <!-- Invoice Info -->
                        <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <h4 class="font-semibold text-blue-900 mb-2">Persyaratan Invoice:</h4>
                            <ul class="text-sm text-blue-800 space-y-1 list-disc list-inside">
                                <li>Invoice harus menunjukkan detail pembelian produk</li>
                                <li>Tanggal dan jumlah pembelian harus terlihat</li>
                                <li>Struk/bukti pembelian dapat diterima</li>
                                <li>Gambar harus jelas dan dapat dibaca</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Step 5: Additional Information -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            <span class="flex items-center justify-center w-8 h-8 bg-indigo-600 text-white rounded-full mr-3">5</span>
                            Informasi Tambahan (Opsional)
                        </h2>

                        <div>
                            <label for="additional_info" class="block text-sm font-semibold text-gray-700 mb-2">
                                Komentar atau Catatan
                            </label>
                            <textarea name="additional_info" id="additional_info" rows="4"
                                class="rounded-xl w-full px-3 py-2 shadow-[inset_0_2px_4px_rgba(0,0,0,0.15)] @error('additional_info') border-red-500 @enderror"
                                placeholder="Informasi tambahan tentang produk atau garansi Anda...">{{ old('additional_info', $warranty->additional_info) }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Opsional: Tambahkan detail tambahan apa pun</p>
                        </div>
                    </div>

                    <!-- reCAPTCHA -->
                    <div class="mt-4 w-full">
                        <div class="flex justify-center">
                            <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                        </div>

                        @error('g-recaptcha-response')
                        <div class="mt-2 text-sm text-red-600 dark:text-red-400 text-center">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-between pt-6">
                        <a href="{{ route('warranty.detail', $warranty) }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm">
                            ← Kembali ke Detail
                        </a>
                        <button type="submit"
                            class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-8 rounded-xl transition duration-150">
                            Ajukan Ulang Pendaftaran
                        </button>
                    </div>
                </form>
            </div>

            <!-- Info Section -->
            <div class="mt-8 p-6 bg-yellow-50 border border-yellow-200 rounded-lg">
                <h3 class="font-semibold text-yellow-900 mb-2 flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Apa yang Terjadi Selanjutnya?
                </h3>
                <p class="text-sm text-yellow-800 mb-3">
                    Setelah Anda mengirimkan ulang pendaftaran garansi, tim kami akan memverifikasi informasi yang telah diperbaiki dalam 1-2 hari kerja.
                </p>
                <ul class="text-sm text-yellow-800 space-y-1 list-disc list-inside">
                    <li>Pastikan Anda telah memperbaiki informasi sesuai alasan penolakan</li>
                    <li>Kami akan memverifikasi ulang invoice dan nomor seri Anda</li>
                    <li>Anda akan menerima konfirmasi email setelah disetujui</li>
                    <li>Status garansi Anda dapat diperiksa kapan saja</li>
                </ul>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gradient-to-r from-gray-100 to-gray-300 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Tentang Itech Warranty Dashboard</h3>
                        <p class="text-sm text-gray-600">Sistem manajemen garansi profesional untuk produk berkualitas</p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Tautan Cepat</h3>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li><a href="{{ route('warranty.register') }}" class="hover:text-indigo-600">Daftar Garansi</a></li>
                            <li><a href="{{ route('warranty.check') }}" class="hover:text-indigo-600">Periksa Garansi</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Dukungan</h3>
                        <p class="text-sm text-gray-600">Email: xxx@xxx.com</p>
                        <p class="text-sm text-gray-600">Telepon: +62 811-7531-881</p>
                    </div>
                </div>
                <div class="border-gray-200 mt-8 pt-4 text-center text-sm text-gray-600">
                    <p>&copy; {{ date('Y') }} PT. Itech Persada Nusantara. Semua Hak Dilindungi Undang-Undang.</p>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Auto uppercase serial number
        document.getElementById('serial_number').addEventListener('input', function(e) {
            this.value = this.value.toUpperCase();
        });

        // File upload handling
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('invoice');
        const filePreview = document.getElementById('filePreview');

        uploadArea.addEventListener('click', () => fileInput.click());

        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('border-indigo-500', 'bg-indigo-50');
        });

        uploadArea.addEventListener('dragleave', () => {
            uploadArea.classList.remove('border-indigo-500', 'bg-indigo-50');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('border-indigo-500', 'bg-indigo-50');
            fileInput.files = e.dataTransfer.files;
            updateFilePreview();
        });

        fileInput.addEventListener('change', updateFilePreview);

        function updateFilePreview() {
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                document.getElementById('fileName').textContent = file.name;
                document.getElementById('fileSize').textContent = (file.size / 1024 / 1024).toFixed(2) + ' MB';
                filePreview.classList.remove('hidden');
            }
        }

        function clearFile() {
            fileInput.value = '';
            filePreview.classList.add('hidden');
        }

        // Product info display
        document.getElementById('product_id').addEventListener('change', function() {
            const option = this.options[this.selectedIndex];
            if (this.value) {
                document.getElementById('productInfo').classList.remove('hidden');
            } else {
                document.getElementById('productInfo').classList.add('hidden');
            }
        });
    </script>
</body>

</html>
