<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - تلال الرمال</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <h1 class="text-xl font-bold">لوحة التحكم - تلال الرمال</h1>
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

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div class="mr-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">الخدمات</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['services'] ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                            </div>
                            <div class="mr-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">المدن</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['cities'] ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div class="mr-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">الرحلات</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['trips'] ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                            </div>
                            <div class="mr-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">التقييمات</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['testimonials'] ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-4">روابط الإدارة السريعة</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="http://localhost:8000/api/services?lang=ar" target="_blank" 
                       class="block p-4 border border-gray-300 rounded-lg hover:bg-gray-50">
                        <h3 class="font-bold text-lg mb-2">الخدمات</h3>
                        <p class="text-gray-600 text-sm">عرض وإدارة الخدمات</p>
                    </a>
                    <a href="http://localhost:8000/api/trips?lang=ar" target="_blank" 
                       class="block p-4 border border-gray-300 rounded-lg hover:bg-gray-50">
                        <h3 class="font-bold text-lg mb-2">الرحلات</h3>
                        <p class="text-gray-600 text-sm">عرض وإدارة الرحلات</p>
                    </a>
                    <a href="http://localhost:8000/api/cities?lang=ar" target="_blank" 
                       class="block p-4 border border-gray-300 rounded-lg hover:bg-gray-50">
                        <h3 class="font-bold text-lg mb-2">المدن</h3>
                        <p class="text-gray-600 text-sm">عرض وإدارة المدن</p>
                    </a>
                    <a href="http://localhost:8000/api/testimonials?lang=ar" target="_blank" 
                       class="block p-4 border border-gray-300 rounded-lg hover:bg-gray-50">
                        <h3 class="font-bold text-lg mb-2">التقييمات</h3>
                        <p class="text-gray-600 text-sm">عرض وإدارة التقييمات</p>
                    </a>
                    <a href="http://localhost:8000/api/products?lang=ar" target="_blank" 
                       class="block p-4 border border-gray-300 rounded-lg hover:bg-gray-50">
                        <h3 class="font-bold text-lg mb-2">المنتجات</h3>
                        <p class="text-gray-600 text-sm">عرض وإدارة المنتجات</p>
                    </a>

                </div>
            </div>
        </div>
    </div>
</body>
</html>
