<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <h1 class="text-4xl font-bold text-slate-500 dark:text-slate-100 mb-8">My Page</h1>

    <div class="grid md:grid-cols-3 gap-6">

        <!-- Sidebar -->
        <aside class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl p-6 shadow-sm">
            <div class="flex flex-col items-center mb-6">
                <div class="relative">
                    <!-- 画像プレビュー -->
                    <img src="{{ $photo ? url('storage', $photo) : url('storage/default/default-avatar.png') }}"
                        alt="Profile"
                        class="w-24 h-24 rounded-full object-cover mb-3 border border-gray-300 dark:border-gray-700">

                    <!-- 編集アイコン -->
                    <label for="photo-upload"
                        class="absolute bottom-0 right-0 bg-gray-800 text-white text-xs px-2 py-1 rounded cursor-pointer hover:bg-gray-700">
                        Edit
                    </label>
                    <input id="photo-upload" type="file" wire:model="photo" class="hidden" accept="image/*">
                </div>

                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mt-2">{{ $user->name }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
            </div>

            <nav class="space-y-2">
                <a wire:navigate href="/my-page"
                    class="flex items-center gap-x-3 px-4 py-2 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-slate-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Overview
                </a>
                <a wire:navigate href="/my-orders"
                    class="flex items-center gap-x-3 px-4 py-2 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-slate-700 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 7h18M3 12h18M3 17h18" />
                    </svg>
                    My Orders
                </a>
                <a wire:navigate href="/wishlist"
                    class="flex items-center gap-x-3 px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                    </svg>
                    Wishlist
                </a>
                <a wire:navigate href="/my-addresses"
                    class="flex items-center gap-x-3 px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z" />
                    </svg>
                    Address Book
                </a>
                <a wire:navigate href="/account-settings"
                    class="flex items-center gap-x-3 px-4 py-2 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Account Settings
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <section
            class="md:col-span-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm p-6">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Overview</h2>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div
                    class="p-5 bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-lg text-center">
                    <h3 class="text-sm text-gray-600 dark:text-gray-300">Total Orders</h3>
                    <p class="text-3xl font-bold text-blue-500 mt-1">{{ $orders_count }}</p>
                </div>
                <div
                    class="p-5 bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-lg text-center">
                    <h3 class="text-sm text-gray-600 dark:text-gray-300">Wishlist Items</h3>
                    <p class="text-3xl font-bold text-rose-600 mt-1">0</p>
                    {{-- <p class="text-3xl font-bold text-rose-600 mt-1">{{ $wishlist_count }}</p> --}}
                </div>
                <div
                    class="p-5 bg-gray-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-lg text-center">
                    <h3 class="text-sm text-gray-600 dark:text-gray-300">Saved Addresses</h3>
                    <p class="text-3xl font-bold text-green-600 mt-1">0</p>
                    {{-- <p class="text-3xl font-bold text-green-600 mt-1">{{ $addresses_count }}</p> --}}
                </div>
            </div>

            <div class="mt-8">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-3">Recent Orders</h3>

                <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-slate-700">
                    <table class="min-w-full text-sm text-left text-gray-800 dark:text-gray-200">
                        <thead class="bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-200">
                            <tr>
                                <th class="px-4 py-3 font-medium uppercase">Order</th>
                                <th class="px-4 py-3 font-medium uppercase">Date</th>
                                <th class="px-4 py-3 font-medium uppercase">Status</th>
                                <th class="px-4 py-3 font-medium uppercase text-end">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recent_orders as $order)
                            <tr
                                class="border-t border-gray-200 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700/50">
                                <td class="px-4 py-3">{{ $order->id }}</td>
                                <td class="px-4 py-3">{{ $order->created_at->format('d M Y') }}</td>
                                <td class="px-4 py-3">
                                    <x-status-badge type="order" :status="$order->status" />
                                </td>
                                <td class="px-4 py-3 text-end font-medium">
                                    {{ Number::currency($order->grand_total, 'USD') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>

@livewireAlerts