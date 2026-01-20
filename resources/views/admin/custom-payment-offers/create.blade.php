<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء عرض دفع مخصص - لوحة التحكم</title>
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
                <h1 class="text-3xl font-bold text-gray-900 mt-4">إنشاء عرض دفع مخصص</h1>
                <p class="text-gray-600 mt-2">أنشئ رابط دفع فريد لإرساله للعميل</p>
            </div>

            <!-- Form -->
            <div class="bg-white shadow rounded-lg">
                <form action="{{ route('admin.custom-payment-offers.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <!-- Customer Name -->
                    <div>
                        <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">اسم العميل</label>
                        <input 
                            type="text"
                            id="customer_name"
                            name="customer_name"
                            value="{{ old('customer_name') }}"
                            placeholder="أدخل اسم العميل الكامل"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('customer_name') border-red-500 @enderror"
                            required
                        >
                        @error('customer_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Customer Email -->
                    <div>
                        <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-2">البريد الإلكتروني</label>
                        <input 
                            type="email"
                            id="customer_email"
                            name="customer_email"
                            value="{{ old('customer_email') }}"
                            placeholder="أدخل البريد الإلكتروني للعميل"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('customer_email') border-red-500 @enderror"
                            required
                        >
                        @error('customer_email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Customer Phone -->
                    <div>
                        <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-2">رقم الهاتف</label>
                        <input 
                            type="tel"
                            id="customer_phone"
                            name="customer_phone"
                            value="{{ old('customer_phone') }}"
                            placeholder="+966501234567"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('customer_phone') border-red-500 @enderror"
                            required
                        >
                        @error('customer_phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Amount -->
                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">المبلغ (ريال)</label>
                        <input 
                            type="number"
                            id="amount"
                            name="amount"
                            value="{{ old('amount') }}"
                            placeholder="أدخل المبلغ"
                            step="0.01"
                            min="0.01"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('amount') border-red-500 @enderror"
                            required
                        >
                        @error('amount')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">الوصف</label>
                        <textarea 
                            id="description"
                            name="description"
                            placeholder="أدخل وصف العرض (مثل: رحلة إلى دبي، دورة تدريبية، إلخ)"
                            rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                            required
                        >{{ old('description') }}</textarea>
                        @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4 pt-6">
                        <button 
                            type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition"
                        >
                            إنشاء عرض الدفع
                        </button>
                        <a 
                            href="{{ route('admin.custom-payment-offers.index') }}"
                            class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition text-center"
                        >
                            إلغاء
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
