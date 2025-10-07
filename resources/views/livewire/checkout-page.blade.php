<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
        Checkout
    </h1>

    <form wire:submit.prevent="placeOrder">
        <div class="grid grid-cols-12 gap-4">

            <!-- Left side -->
            <div class="md:col-span-12 lg:col-span-8 col-span-12">
                <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">

                    <!-- Shipping Address -->
                    <div class="mb-6">
                        <h2 class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                            Shipping Address
                        </h2>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- First Name -->
                            <div>
                                <label for="first_name" class="block text-gray-700 dark:text-white mb-1">
                                    First Name
                                </label>
                                <input wire:model="first_name" id="first_name" type="text"
                                    @class([ 'w-full rounded-lg py-2 px-3 dark:bg-gray-700 dark:text-white'
                                    , 'border-red-500 border'=> $errors->has('first_name'),
                                'border dark:border-none' => !$errors->has('first_name'),
                                ]) />
                                @error('first_name')
                                <div class="text-red-500 text-sm">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <!-- Last Name -->
                            <div>
                                <label for="last_name" class="block text-gray-700 dark:text-white mb-1">
                                    Last Name
                                </label>
                                <input wire:model="last_name" id="last_name" type="text"
                                    @class([ 'w-full rounded-lg py-2 px-3 dark:bg-gray-700 dark:text-white'
                                    , 'border-red-500 border'=> $errors->has('last_name'),
                                'border dark:border-none' => !$errors->has('last_name'),
                                ]) />
                                @error('last_name')
                                <div class="text-red-500 text-sm">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="mt-4">
                            <label for="phone" class="block text-gray-700 dark:text-white mb-1">
                                Phone
                            </label>
                            <input wire:model="phone" id="phone" type="text"
                                @class([ 'w-full rounded-lg py-2 px-3 dark:bg-gray-700 dark:text-white'
                                , 'border-red-500 border'=> $errors->has('phone'),
                            'border dark:border-none' => !$errors->has('phone'),
                            ]) />
                            @error('phone')
                            <div class="text-red-500 text-sm">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="mt-4">
                            <label for="address" class="block text-gray-700 dark:text-white mb-1">
                                Address
                            </label>
                            <input wire:model="street_address" id="address" type="text"
                                @class([ 'w-full rounded-lg py-2 px-3 dark:bg-gray-700 dark:text-white'
                                , 'border-red-500 border'=> $errors->has('street_address'),
                            'border dark:border-none' => !$errors->has('street_address'),
                            ]) />
                            @error('street_address')
                            <div class="text-red-500 text-sm">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- City -->
                        <div class="mt-4">
                            <label for="city" class="block text-gray-700 dark:text-white mb-1">
                                City
                            </label>
                            <input wire:model="city" id="city" type="text"
                                @class([ 'w-full rounded-lg py-2 px-3 dark:bg-gray-700 dark:text-white'
                                , 'border-red-500 border'=> $errors->has('city'),
                            'border dark:border-none' => !$errors->has('city'),
                            ]) />
                            @error('city')
                            <div class="text-red-500 text-sm">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- State & ZIP -->
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <label for="state" class="block text-gray-700 dark:text-white mb-1">
                                    State
                                </label>
                                <input wire:model="state" id="state" type="text"
                                    @class([ 'w-full rounded-lg py-2 px-3 dark:bg-gray-700 dark:text-white'
                                    , 'border-red-500 border'=> $errors->has('state'),
                                'border dark:border-none' => !$errors->has('state'),
                                ]) />
                                @error('state')
                                <div class="text-red-500 text-sm">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div>
                                <label for="zip_code" class="block text-gray-700 dark:text-white mb-1">
                                    ZIP Code
                                </label>
                                <input wire:model="zip_code" id="zip_code" type="text"
                                    @class([ 'w-full rounded-lg py-2 px-3 dark:bg-gray-700 dark:text-white'
                                    , 'border-red-500 border'=> $errors->has('zip_code'),
                                'border dark:border-none' => !$errors->has('zip_code'),
                                ]) />
                                @error('zip_code')
                                <div class="text-red-500 text-sm">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-4">
                        Select Payment Method
                    </div>

                    <ul class="grid w-full gap-6 md:grid-cols-2">
                        <li>
                            <input wire:model="payment_method" type="radio" id="cod" value="cod" class="hidden peer" />
                            <label for="cod"
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">Cash on Delivery</div>
                                </div>
                                <svg aria-hidden="true" class="w-5 h-5 ms-3 rtl:rotate-180" fill="none"
                                    viewBox="0 0 14 10" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2"></path>
                                </svg>
                            </label>
                        </li>

                        <li>
                            <input wire:model="payment_method" type="radio" id="stripe" value="stripe"
                                class="hidden peer" />
                            <label for="stripe"
                                class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">Stripe</div>
                                </div>
                                <svg aria-hidden="true" class="w-5 h-5 ms-3 rtl:rotate-180" fill="none"
                                    viewBox="0 0 14 10" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 5h12m0 0L9 1m4 4L9 9" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2"></path>
                                </svg>
                            </label>
                        </li>
                    </ul>

                    @error('payment_method')
                    <div class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <!-- Right side -->
            <div class="md:col-span-12 lg:col-span-4 col-span-12">
                <div class="bg-white rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                        ORDER SUMMARY
                    </div>

                    <div class="flex justify-between mb-2 font-bold text-gray-700 dark:text-white">
                        <span>Subtotal</span>
                        <span>{{ Number::currency($grand_total, 'USD') }}</span>
                    </div>

                    <div class="flex justify-between mb-2 font-bold text-gray-700 dark:text-white">
                        <span>Taxes</span>
                        <span>{{ Number::currency(0, 'USD') }}</span>
                    </div>

                    <div class="flex justify-between mb-2 font-bold text-gray-700 dark:text-white">
                        <span>Shipping Cost</span>
                        <span>{{ Number::currency(0, 'USD') }}</span>
                    </div>

                    <hr class="bg-slate-400 my-4 h-1 rounded">

                    <div class="flex justify-between mb-2 font-bold text-gray-700 dark:text-white">
                        <span>Grand Total</span>
                        <span>{{ Number::currency($grand_total, 'USD') }}</span>
                    </div>
                </div>

                <button type="submit"
                    class="bg-green-500 mt-4 w-full p-3 rounded-lg text-lg text-white hover:bg-green-600">
                    Place Order
                </button>

                <!-- Basket Summary -->
                <div class="bg-white mt-4 rounded-xl shadow p-4 sm:p-7 dark:bg-slate-900">
                    <div class="text-xl font-bold underline text-gray-700 dark:text-white mb-2">
                        BASKET SUMMARY
                    </div>

                    <ul class="divide-y divide-gray-200 dark:divide-gray-700" role="list">
                        @foreach($cart_items as $ci)
                        <li class="py-3 sm:py-4" wire:key="{{ $ci['product_id'] }}">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <img src="{{ url('storage', $ci['image']) }}" alt="{{ $ci['name'] }}"
                                        class="w-12 h-12 rounded-full">
                                </div>

                                <div class="flex-1 min-w-0 ms-4">
                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                        {{ $ci['name'] }}
                                    </p>
                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                        Quantity: {{ $ci['quantity'] }}
                                    </p>
                                </div>

                                <div
                                    class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                    {{ Number::currency($ci['total_amount'], 'USD') }}
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </form>
</div>