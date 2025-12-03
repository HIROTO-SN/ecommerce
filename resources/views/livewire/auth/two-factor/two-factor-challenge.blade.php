<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="flex h-full items-center">
        <main class="w-full max-w-md mx-auto p-6">
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="p-4 sm:p-7">
                    <div class="text-center">
                        <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Two-Factor Authentication
                        </h1>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Please enter the authentication code from your authenticator app.
                        </p>
                    </div>

                    <hr class="my-5 border-slate-300">

                    <!-- Form -->
                    <form wire:submit.prevent="submit">
                        @if(session('error'))
                        <div class="mt-2 mb-4 bg-red-500 text-sm text-white rounded-lg p-4">
                            {{ session('error') }}
                        </div>
                        @endif

                        <div class="grid gap-y-4">

                            <!-- Auth Code -->
                            <div>
                                <label for="code" class="block text-sm mb-2 dark:text-white">Authentication Code</label>
                                <input id="code" type="text" wire:model="code" class="py-3 px-4 block w-full border border-gray-200 rounded-lg text-sm 
                                           focus:border-blue-500 focus:ring-blue-500 
                                           dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400" />
                                @error('code')
                                <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit -->
                            <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold 
                                       rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                                Verify
                            </button>

                        </div>
                    </form>
                    <!-- End Form -->

                </div>
            </div>
        </main>
    </div>
</div>