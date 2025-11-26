<div class="fixed inset-0 flex items-center justify-center z-50" wire:keydown.enter="save" tabindex="0">
    {{-- 背景オーバーレイ --}}
    <div class="absolute inset-0 bg-black/30 dark:bg-black/60 backdrop-blur-sm" wire:click="$set('showModal', false)">
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
            <input type="password" wire:model.defer="password_confirmation" placeholder="Confirm Password"
                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-2 text-gray-800 dark:text-gray-100 bg-white dark:bg-gray-700">
            @error('password_confirmation')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        {{-- 2FA Fields --}}
        @elseif ($field === "2fa")
        <div class="mt-4 p-4 border rounded-lg bg-white dark:bg-slate-800 flex flex-col items-center">

            {{-- Already Enabled --}}
            @if ($twoFactorEnabled)
            <div class="max-w-sm p-4 bg-white dark:bg-gray-800 rounded-lg shadow flex flex-col space-y-3">
                <!-- 上段：ステータスとボタン -->
                <div class="flex items-center justify-between">
                    <!-- ステータス -->
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-green-500 font-semibold">2FA Enabled</span>
                    </div>

                    <!-- ボタン -->
                    <button wire:click="disableTwoFactor"
                        class="flex items-center px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Disable
                    </button>
                </div>

                <!-- 下段：注釈 -->
                <p class="text-gray-500 text-xs">
                    Disabling MFA will make your account less secure.
                </p>
                </d @else {{-- QR Code and setup instructions --}} @if (!$show2faInput) <p
                    class="text-sm text-gray-700 dark:text-gray-300 mb-2 text-center">
                Scan this QR code with your authentication app:
                </p>
                <div class="mb-4">
                    {!! $qrCode !!}
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-4 text-center">
                    After scanning the QR code, enter the 6-digit code from your authenticator app.
                </p>
                <button wire:click="$set('show2faInput', true)"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm">
                    Enter 6-digit Code
                </button>
                @endif

                {{-- OTP Input --}}
                @if ($show2faInput)
                <div class="w-full mt-4">
                    <input type="text" wire:model.defer="twoFactorCode" maxlength="6"
                        placeholder="Enter the 6-digit code"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-2 text-gray-800 dark:text-gray-100 bg-white dark:bg-gray-700 text-center">
                    @error('twoFactorCode')
                    <p class="text-red-500 text-xs mt-1 text-center">{{ $message }}</p>
                    @enderror

                    <button wire:click="confirmTwoFactor"
                        class="w-full mt-3 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm">
                        Confirm 2FA Setup
                    </button>
                </div>
                @endif
                @endif

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
            @if($field !== '2fa')
            <div class="flex justify-end gap-2">
                <button wire:click="$dispatch('close-modal')"
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
            @endif
        </div>
    </div>