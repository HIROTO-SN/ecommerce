<div class="w-full max-w-6xl py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <h1 class="text-4xl font-bold text-slate-500 dark:text-slate-100 mb-8 text-center">MY PAGE</h1>

    <!-- Grid layout: Sidebar + Main Content -->
    <div class="grid md:grid-cols-3 gap-8">

        <!-- Sidebar -->
        <aside class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl p-6 shadow-sm">
            <div class="flex flex-col items-center mb-6">
                <div class="relative">
                    <!-- Profile photo preview -->
                    <img src="{{ $photo ? url('storage', $photo) : url('storage/default/default-avatar.png') }}"
                        alt="Profile"
                        class="w-24 h-24 rounded-full object-cover mb-3 border border-gray-300 dark:border-gray-700">

                    <!-- Edit button for photo -->
                    <label for="photo-upload"
                        class="absolute bottom-0 right-0 bg-gray-800 text-white text-xs px-2 py-1 rounded cursor-pointer hover:bg-gray-700">
                        Edit
                    </label>
                    <input id="photo-upload" type="file" wire:model="photo" class="hidden" accept="image/*">

                    <!-- Loading spinner when uploading -->
                    <div wire:loading wire:target="photo"
                        class="absolute inset-0 flex items-center justify-center bg-black/40 rounded-full">
                        <svg class="animate-spin h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                    </div>
                </div>

                <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mt-2">{{ $user->name }}</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
            </div>

            <!-- Sidebar navigation -->
            <nav class="space-y-2 w-full">
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
            class="md:col-span-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm p-8">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-8">LOGIN AND SECURITY</h2>

            <div class="space-y-5">

                <!-- Name -->
                <div
                    class="flex justify-between items-center p-5 border rounded-lg bg-gray-50 dark:bg-slate-700 dark:border-slate-600">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-100">Name</h3>
                        <p class="text-gray-700 dark:text-gray-300">{{ $user->name }}</p>
                    </div>
                    <button wire:click="edit('name')"
                        class="text-blue-600 hover:underline font-medium text-sm cursor-pointer">
                        EDIT
                    </button>

                </div>

                <!-- Email -->
                <div
                    class="flex justify-between items-center p-5 border rounded-lg bg-gray-50 dark:bg-slate-700 dark:border-slate-600">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-100">Email</h3>
                        <p class="text-gray-700 dark:text-gray-300">{{ $user->email }}</p>
                    </div>
                    <button wire:click="edit('email')"
                        class="text-blue-600 hover:underline font-medium text-sm cursor-pointer">EDIT</button>
                </div>

                <!-- Phone -->
                <div
                    class="flex justify-between items-center p-5 border rounded-lg bg-gray-50 dark:bg-slate-700 dark:border-slate-600">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-100">Mobile Phone Number</h3>
                        <p class="text-gray-700 dark:text-gray-300">{{ $user->phone }}</p>
                    </div>
                    <button wire:click="edit('phone')"
                        class="text-blue-600 hover:underline font-medium text-sm cursor-pointer">EDIT</button>
                </div>

                <!-- Password -->
                <div
                    class="flex justify-between items-center p-5 border rounded-lg bg-gray-50 dark:bg-slate-700 dark:border-slate-600">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-100">Password</h3>
                        <p class="text-gray-700 dark:text-gray-300">**********</p>
                    </div>
                    <button wire:click="edit('password')"
                        class="text-blue-600 hover:underline font-medium text-sm cursor-pointer">EDIT</button>
                </div>

                <!-- Passkey -->
                <div
                    class="flex justify-between items-center p-5 border rounded-lg bg-gray-50 dark:bg-slate-700 dark:border-slate-600">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-100">Passkey</h3>
                        <p class="text-gray-700 dark:text-gray-300">Not set </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Enhance security by setting up a
                            passkey for passwordless login.</p>
                    </div>
                    <button wire:click="edit('passkey')"
                        class="text-blue-600 hover:underline font-medium text-sm cursor-pointer">SETTING</button>
                </div>

                <!-- Two-Factor Authentication -->
                <div
                    class="flex justify-between items-center p-5 border rounded-lg bg-gray-50 dark:bg-slate-700 dark:border-slate-600">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-100">Two-factor-authentication
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300">+81 80-7521-0476</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">You can sign in securely by entering an
                            authentication code in addition to your password.</p>
                    </div>
                    <button wire:click="edit('2fa')"
                        class="text-blue-600 hover:underline font-medium text-sm cursor-pointer">SETTING</button>
                </div>

                <!-- Security notice -->
                <div
                    class="flex justify-between items-center p-5 border rounded-lg bg-gray-50 dark:bg-slate-700 dark:border-slate-600">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-100">Has your account been
                            accessed illegally?</h3>
                        <p class="text-gray-700 dark:text-gray-300">You can sign out from all locations.
                        </p>
                    </div>
                    <button class="text-blue-600 hover:underline font-medium text-sm cursor-pointer">SETTING</button>
                </div>
                <!-- モーダル -->
                @if ($showModal)
                <div class="fixed inset-0 flex items-center justify-center z-50" wire:keydown.enter="save" tabindex="0">
                    {{-- 背景オーバーレイ --}}
                    <div class="absolute inset-0 bg-black/30 dark:bg-black/60 backdrop-blur-sm"
                        wire:click="$set('showModal', false)">
                    </div>

                    {{-- モーダル本体 --}}
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 w-[400px] relative z-10">
                        <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">
                            @if ($field === 'passkey')
                            Manage Passkeys
                            @else
                            Edit {{ ucfirst(str_replace('_', ' ', $field)) }}
                            @endif
                        </h2>

                        {{-- ✅ Passkey fields --}}
                        @if ($field === 'passkey')
                        @if ($passkeys && count($passkeys) > 0)
                        <div class="space-y-3 mb-4 max-h-48 overflow-y-auto">
                            @foreach ($passkeys as $key)
                            <div
                                class="flex justify-between items-center border border-gray-300 dark:border-gray-600 rounded-lg p-2 bg-gray-50 dark:bg-gray-700">
                                <div>
                                    <p class="text-gray-800 dark:text-gray-100 text-sm font-medium">
                                        {{ $key['name'] ?? 'Registered Passkey' }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Added on {{ $key['created_at'] ?? 'N/A' }}
                                    </p>
                                </div>
                                <button wire:click="deletePasskey('{{ $key['id'] }}')"
                                    class="text-red-500 text-sm hover:underline">Remove</button>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-gray-600 dark:text-gray-300 mb-4 text-sm">
                            No passkeys registered yet.
                        </p>
                        @endif

                        {{-- ✅ Password fields --}}
                        @elseif ($field === 'password')
                        <div class="mb-3">
                            <input type="password" wire:model.defer="value" placeholder="New Password"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-2 text-gray-800 dark:text-gray-100 bg-white dark:bg-gray-700">
                            @error('value')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <input type="password" wire:model.defer="password_confirmation"
                                placeholder="Confirm Password"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-2 text-gray-800 dark:text-gray-100 bg-white dark:bg-gray-700">
                            @error('password_confirmation')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- ✅ Other fields --}}
                        @else
                        <div class="mb-4">
                            <input type="text" wire:model.defer="value"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-2 text-gray-800 dark:text-gray-100 bg-white dark:bg-gray-700">
                            @error('value')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        @endif

                        {{-- ✅ Buttons --}}
                        <div class="flex justify-end gap-2">
                            <button wire:click="$set('showModal', false)"
                                class="px-4 py-2 text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-gray-100 cursor-pointer">
                                Cancel
                            </button>

                            @if ($field === 'passkey')
                            <button wire:click="addPasskey"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg cursor-pointer">
                                Add New Passkey
                            </button>
                            @else
                            <button wire:click="save"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg cursor-pointer">
                                Save
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </section>
    </div>
</div>

@livewireAlerts