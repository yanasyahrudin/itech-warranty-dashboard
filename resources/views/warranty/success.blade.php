<!-- filepath: resources/views/warranty/success.blade.php -->
<x-guest-layout>
    <div class="text-center">
        <!-- Success Icon -->
        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
            <svg class="h-10 w-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <!-- Success Message -->
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Registration Submitted Successfully!</h2>
        <p class="text-gray-600 mb-6">
            Your warranty registration has been submitted and is now under review.
        </p>

        <!-- Info Box -->
        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg text-left">
            <div class="flex">
                <svg class="h-5 w-5 text-blue-400 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-blue-800 mb-2">What happens next?</p>
                    <ul class="text-sm text-blue-700 space-y-2">
                        <li class="flex items-start">
                            <span class="mr-2">1.</span>
                            <span>Our admin team will verify your registration within <strong>3 business days</strong></span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">2.</span>
                            <span>You will receive an email notification about the approval status</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">3.</span>
                            <span>Once approved, your warranty will be activated automatically</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">4.</span>
                            <span>You can check your warranty status anytime using your serial number</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Email Notice -->
        <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
            <div class="flex items-center justify-center">
                <svg class="h-5 w-5 text-yellow-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <p class="text-sm text-yellow-800">
                    <strong>Check your email!</strong> We've sent a confirmation to your email address.
                </p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-3">
            <a href="{{ route('warranty.check') }}" class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition duration-150">
                Check Warranty Status
            </a>
            <a href="{{ route('warranty.register') }}" class="block w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-4 rounded-lg transition duration-150">
                Register Another Product
            </a>
        </div>

        <!-- Support -->
        <div class="mt-6 pt-6 border-t border-gray-200">
            <p class="text-sm text-gray-600">
                Have questions? Contact our support team for assistance.
            </p>
        </div>
    </div>
</x-guest-layout>