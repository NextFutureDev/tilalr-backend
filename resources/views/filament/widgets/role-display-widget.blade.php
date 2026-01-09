<div class="p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200 dark:from-gray-900 dark:to-gray-800 dark:border-gray-700">
    @php
        $roleInfo = $this->getRoleInfo();
    @endphp
    
    @if($roleInfo)
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">Your Role</h3>
                <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400 mt-2">
                    {{ $roleInfo['role_name'] }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                    📋 {{ $roleInfo['permissions_count'] }} permissions assigned
                </p>
            </div>
            <div class="text-right">
                <div class="inline-block px-3 py-1 bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300 text-xs font-semibold rounded-full">
                    Active
                </div>
            </div>
        </div>
    @else
        <div class="text-gray-500 dark:text-gray-400">
            No role information available
        </div>
    @endif
</div>
