<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عرض الدفع - لوحة التحكم</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold">لوحة التحكم</a>
                    </div>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-700 ml-4">{{ auth()->user()->name }}</span>
                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800">تسجيل الخروج</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-2xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('admin.custom-payment-offers.index') }}" class="text-blue-600 hover:text-blue-900">← العودة</a>
                <h1 class="text-3xl font-bold text-gray-900 mt-4">عرض الدفع</h1>
            </div>

            <!-- Success Message -->
            @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
            @endif

            <!-- Offer Details -->
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600">اسم العميل</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $customPaymentOffer->customer_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">البريد الإلكتروني</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $customPaymentOffer->customer_email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">رقم الهاتف</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $customPaymentOffer->customer_phone }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">المبلغ</p>
                        <p class="text-lg font-semibold text-gray-900">{{ number_format($customPaymentOffer->amount, 2) }} ر.س</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-sm text-gray-600">الوصف</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $customPaymentOffer->description }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">الحالة</p>
                        <div>
                            @if($customPaymentOffer->payment_status === 'pending')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">قيد الانتظار</span>
                            @elseif($customPaymentOffer->payment_status === 'completed')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">مكتمل</span>
                            @elseif($customPaymentOffer->payment_status === 'failed')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">فشل</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">التاريخ</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $customPaymentOffer->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Payment Link Section -->
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">رابط الدفع</h2>
                <p class="text-gray-600 mb-4">انسخ هذا الرابط وأرسله للعميل:</p>
                
                <div class="flex gap-2 mb-4">
                    <input 
                        type="text"
                        id="payment-link"
                        value="{{ $paymentLink }}"
                        readonly
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-sm"
                    >
                    <button 
                        onclick="copyToClipboard()"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition"
                    >
                        نسخ
                    </button>
                </div>

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm text-blue-800">
                        <strong>ملاحظة:</strong> عندما ينقر العميل على هذا الرابط، سيرى صفحة الدفع مع جميع التفاصيل وسيتمكن من الدفع مباشرة عبر Moyasar.
                    </p>
                </div>
            </div>

            <!-- Transaction ID (if paid) -->
            @if($customPaymentOffer->payment_status === 'completed' && $customPaymentOffer->moyasar_transaction_id)
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">معلومات الدفع</h2>
                <p class="text-sm text-gray-600">معرف المعاملة</p>
                <p class="text-lg font-semibold text-gray-900">{{ $customPaymentOffer->moyasar_transaction_id }}</p>
            </div>
            @endif

            <!-- Actions -->
            <div class="flex gap-4">
                @if($customPaymentOffer->payment_status === 'pending')
                    <a 
                        href="{{ route('admin.custom-payment-offers.edit', $customPaymentOffer->id) }}"
                        class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition text-center"
                    >
                        تعديل
                    </a>
                    <form 
                        action="{{ route('admin.custom-payment-offers.destroy', $customPaymentOffer->id) }}"
                        method="POST"
                        class="flex-1"
                        onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف هذا العرض؟');"
                    >
                        @csrf
                        @method('DELETE')
                        <button 
                            type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition"
                        >
                            حذف
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard() {
            const link = document.getElementById('payment-link');
            link.select();
            document.execCommand('copy');
            alert('تم نسخ الرابط إلى الحافظة!');
        }
    </script>
</body>
</html>
