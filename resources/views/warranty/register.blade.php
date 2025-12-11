<!-- filepath: resources/views/warranty/register.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Warranty - iTech</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-50 to-blue-50">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <div class="flex items-center">
                    <div class="text-2xl font-bold text-indigo-600">🔧 iTech</div>
                    <span class="ml-2 text-gray-600">Warranty System</span>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('warranty.check') }}" class="text-indigo-600 hover:text-indigo-900 font-medium text-sm">
                        Check Warranty
                    </a>
                    <a href="/" class="text-gray-600 hover:text-gray-900 font-medium text-sm">
                        Home
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full">
            
            <!-- Page Title -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Register Your Warranty</h1>
                <p class="text-lg text-gray-600">Complete the form below to register your product warranty</p>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex">
                        <svg class="h-5 w-5 text-green-400 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Registration Form -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <form method="POST" action="{{ route('warranty.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Step 1: Product Selection -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            <span class="flex items-center justify-center w-8 h-8 bg-indigo-600 text-white rounded-full mr-3">1</span>
                            Select Your Product
                        </h2>

                        <div class="mb-4">
                            <label for="product_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Product <span class="text-red-500">*</span>
                            </label>
                            <select name="product_id" id="product_id" 
                                class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 @error('product_id') border-red-500 @enderror"
                                required>
                                <option value="">-- Select a Product --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} ({{ $product->part_number }})
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Choose the product you want to register for warranty</p>
                        </div>

                        <!-- Product Info Display -->
                        <div id="productInfo" class="mt-4 p-4 bg-indigo-50 border border-indigo-200 rounded-lg hidden">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-xs text-indigo-700 font-semibold">Part Number</p>
                                    <p class="text-sm text-indigo-900" id="partNumber">-</p>
                                </div>
                                <div>
                                    <p class="text-xs text-indigo-700 font-semibold">Warranty Period</p>
                                    <p class="text-sm text-indigo-900" id="warrantyPeriod">-</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-8">

                    <!-- Step 2: Serial Number & Purchase Info -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            <span class="flex items-center justify-center w-8 h-8 bg-indigo-600 text-white rounded-full mr-3">2</span>
                            Serial Number & Purchase Information
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Serial Number -->
                            <div>
                                <label for="serial_number" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Serial Number <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="serial_number" id="serial_number"
                                    value="{{ old('serial_number') }}"
                                    class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 @error('serial_number') border-red-500 @enderror uppercase"
                                    placeholder="e.g., CASE-FULL-TOWER-01-00001"
                                    style="text-transform: uppercase;"
                                    required>
                                @error('serial_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Found on the product label or QR code</p>
                            </div>

                            <!-- Purchase Date -->
                            <div>
                                <label for="purchase_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Purchase Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="purchase_date" id="purchase_date"
                                    value="{{ old('purchase_date') }}"
                                    class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 @error('purchase_date') border-red-500 @enderror"
                                    required>
                                @error('purchase_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">When you purchased this product</p>
                            </div>
                        </div>
                    </div>

                    <hr class="my-8">

                    <!-- Step 3: Customer Information -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            <span class="flex items-center justify-center w-8 h-8 bg-indigo-600 text-white rounded-full mr-3">3</span>
                            Your Information
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Name -->
                            <div>
                                <label for="customer_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="customer_name" id="customer_name"
                                    value="{{ old('customer_name') }}"
                                    class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 @error('customer_name') border-red-500 @enderror"
                                    placeholder="Your full name"
                                    required>
                                @error('customer_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="customer_email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="customer_email" id="customer_email"
                                    value="{{ old('customer_email') }}"
                                    class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 @error('customer_email') border-red-500 @enderror"
                                    placeholder="your.email@example.com"
                                    required>
                                @error('customer_email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="md:col-span-2">
                                <label for="customer_phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="tel" name="customer_phone" id="customer_phone"
                                    value="{{ old('customer_phone') }}"
                                    class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 @error('customer_phone') border-red-500 @enderror"
                                    placeholder="+62 XXX-XXXX-XXXX"
                                    required>
                                @error('customer_phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr class="my-8">

                    <!-- Step 4: Invoice Upload -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            <span class="flex items-center justify-center w-8 h-8 bg-indigo-600 text-white rounded-full mr-3">4</span>
                            Upload Invoice
                        </h2>

                        <div class="mb-4">
                            <label for="invoice" class="block text-sm font-semibold text-gray-700 mb-2">
                                Invoice Document <span class="text-red-500">*</span>
                            </label>
                            
                            <!-- File Upload Area -->
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-indigo-500 transition"
                                id="uploadArea">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                <p class="text-sm text-gray-600 mb-2">Drag and drop your invoice here, or click to select</p>
                                <input type="file" name="invoice" id="invoice"
                                    class="hidden"
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    required>
                                <p class="text-xs text-gray-500">Supported formats: PDF, JPG, PNG (Max 5MB)</p>
                            </div>

                            @error('invoice')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            <!-- File Preview -->
                            <div id="filePreview" class="mt-4 hidden">
                                <p class="text-sm font-semibold text-gray-700 mb-2">Selected File:</p>
                                <div class="flex items-center p-3 bg-indigo-50 border border-indigo-200 rounded-lg">
                                    <svg class="h-6 w-6 text-indigo-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
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
                            <h4 class="font-semibold text-blue-900 mb-2">📄 Invoice Requirements:</h4>
                            <ul class="text-sm text-blue-800 space-y-1 list-disc list-inside">
                                <li>Invoice must show the product purchase details</li>
                                <li>Date and purchase amount should be visible</li>
                                <li>Receipt/proof of purchase is acceptable</li>
                                <li>Image must be clear and readable</li>
                            </ul>
                        </div>
                    </div>

                    <hr class="my-8">

                    <!-- Step 5: Additional Information -->
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                            <span class="flex items-center justify-center w-8 h-8 bg-indigo-600 text-white rounded-full mr-3">5</span>
                            Additional Information (Optional)
                        </h2>

                        <div>
                            <label for="additional_info" class="block text-sm font-semibold text-gray-700 mb-2">
                                Comments or Notes
                            </label>
                            <textarea name="additional_info" id="additional_info" rows="4"
                                class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                                placeholder="Any additional information about your product or warranty...">{{ old('additional_info') }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Optional: Add any additional details</p>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <a href="/" class="text-gray-600 hover:text-gray-900 font-medium text-sm">
                            Back to Home
                        </a>
                        <button type="submit" 
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-lg transition duration-150">
                            📝 Submit Registration
                        </button>
                    </div>
                </form>
            </div>

            <!-- Info Section -->
            <div class="mt-8 p-6 bg-yellow-50 border border-yellow-200 rounded-lg">
                <h3 class="font-semibold text-yellow-900 mb-2">⏳ What Happens Next?</h3>
                <p class="text-sm text-yellow-800 mb-3">
                    After you submit your warranty registration, our team will verify your information within 1-2 business days. You will receive an email confirmation once your warranty is approved.
                </p>
                <ul class="text-sm text-yellow-800 space-y-1 list-disc list-inside">
                    <li>We'll verify your invoice and serial number</li>
                    <li>You'll get an email confirmation once approved</li>
                    <li>Your warranty status can be checked anytime</li>
                </ul>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">About iTech</h3>
                        <p class="text-sm text-gray-600">Professional warranty management system for quality products</p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Quick Links</h3>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li><a href="{{ route('warranty.register') }}" class="hover:text-indigo-600">Register Warranty</a></li>
                            <li><a href="{{ route('warranty.check') }}" class="hover:text-indigo-600">Check Warranty</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-2">Support</h3>
                        <p class="text-sm text-gray-600">Email: support@itech.com</p>
                        <p class="text-sm text-gray-600">Phone: +62 XXX-XXXX-XXXX</p>
                    </div>
                </div>
                <div class="border-t border-gray-200 mt-8 pt-8 text-center text-sm text-gray-600">
                    <p>&copy; {{ date('Y') }} iTech. All rights reserved.</p>
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