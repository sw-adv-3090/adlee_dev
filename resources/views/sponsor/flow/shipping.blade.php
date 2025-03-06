<x-layouts.app-layout title="Business Address" is-header-blur="true">

    <div class="flex items-center space-x-4 py-5 lg:py-6">
        <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
            Business Address
        </h2>
    </div>

    <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
        <x-sponsor-flow-steps :step3="true" :step4="true" />

        <div class="col-span-12 grid lg:col-span-9">
            <div class="card p-4 sm:p-5">
                @session('error')
                    <div class="alert flex space-x-2 rounded-lg border border-error px-4 py-4 text-error my-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <p> {{ $value }}</p>
                    </div>
                @endsession

                <p class="text-base font-medium text-slate-700 dark:text-navy-100">
                    Business Address
                </p>
                <form action="{{ route('sponsors.basic-settings.address.store') }}" method="post">
                    @csrf
                    <div class="mt-4 space-y-5">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <label class="block">
                                <span class="font-medium text-slate-600 dark:text-navy-100">Address (Line 1)</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Address line 1" type="text" name="address"
                                        value="{{ old('address', $sponsor?->address) }}" required />
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-solid fa-map-marker-alt text-base"></i>
                                    </span>
                                </span>
                            </label>
                            @error('address')
                                <span class="text-xs text-error">{{ $message }}</span>
                            @enderror
                            <label class="block">
                                <span class="font-medium text-slate-600 dark:text-navy-100">Postal Code</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Postal Code" type="text" name="postal_code"
                                        value="{{ old('postal_code', $sponsor?->postal_code) }}" required />
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-solid fa-map-marked-alt text-base"></i>
                                    </span>
                                </span>
                            </label>
                            @error('postal_code')
                                <span class="text-xs text-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <label class="block">
                                <span class="font-medium text-slate-600 dark:text-navy-100">City</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Your City/Town" type="text" name="city"
                                        value="{{ old('city', $sponsor?->city) }}" required />
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-solid fa-city text-base"></i>
                                    </span>
                                </span>
                            </label>
                            @error('city')
                                <span class="text-xs text-error">{{ $message }}</span>
                            @enderror

                            <label class="block">
                                <span class="font-medium text-slate-600 dark:text-navy-100">State</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Your State" type="text" name="state"
                                        value="{{ old('state', $sponsor?->state) }}" required />
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-solid fa-flag"></i>
                                    </span>
                                </span>
                            </label>
                            @error('state')
                                <span class="text-xs text-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Country</span>
                            <span class="relative mt-1.5 flex">
                                {{-- <input
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="Your Country" type="text" name="country"
                                    value="{{ old('country', $sponsor?->country) }}" required /> --}}
                                <select
                                    class="form-select peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent z-50"
                                    name="country" required>
                                    <option value="">Select Country</option>
                                    @foreach (countries() as $country)
                                        <option value="{{ $country->code_2 }}" @selected(old('country', $sponsor?->country) == $country->code_2)>
                                            {{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <span
                                    class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                    <i class="fa-solid fa-flag-usa text-base"></i>
                                </span>
                            </span>
                        </label>
                        @error('country')
                            <span class="text-xs text-error">{{ $message }}</span>
                        @enderror

                        <div x-data="{ sameBillingAddress: true }">
                            <div class="flex-wrap items-start space-y-2 pt-2 sm:flex sm:space-y-0 sm:space-x-5">
                                <label class="inline-flex items-center space-x-2">
                                    <input x-model="sameBillingAddress"
                                        class="form-checkbox is-basic size-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                        type="checkbox" />
                                    <span>Same is Shipping Address</span>
                                </label>
                                <div>
                                    <button @click="sameBillingAddress = false" type="button"
                                        class="border-b border-dotted border-current pb-0.5 font-medium text-primary outline-none transition-colors duration-300 hover:text-primary/70 focus:text-primary/70 dark:text-accent-light dark:hover:text-accent-light/70 dark:focus:text-accent-light/70">
                                        Add Shipping Address
                                    </button>
                                </div>
                            </div>
                            <div x-show="!sameBillingAddress" x-collapse>
                                <div class="mt-4 space-y-5">
                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                        <label class="block">
                                            <span class="font-medium text-slate-600 dark:text-navy-100">Address (Line
                                                1)</span>
                                            <span class="relative mt-1.5 flex">
                                                <input
                                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                    placeholder="Address line 1" type="text" name="shipping_address"
                                                    value="{{ old('shipping_address', $sponsor?->shipping_address) }}"
                                                    :required="!sameBillingAddress" />
                                                <span
                                                    class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                                    <i class="fa-solid fa-map-marker-alt text-base"></i>
                                                </span>
                                            </span>
                                        </label>
                                        @error('shipping_address')
                                            <span class="text-xs text-error">{{ $message }}</span>
                                        @enderror
                                        <label class="block">
                                            <span class="font-medium text-slate-600 dark:text-navy-100">Postal
                                                Code</span>
                                            <span class="relative mt-1.5 flex">
                                                <input
                                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                    placeholder="Postal Code" type="text"
                                                    name="shipping_postal_code"
                                                    value="{{ old('shipping_postal_code', $sponsor?->shipping_postal_code) }}"
                                                    :required="!sameBillingAddress" />
                                                <span
                                                    class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                                    <i class="fa-solid fa-map-marked-alt text-base"></i>
                                                </span>
                                            </span>
                                        </label>
                                        @error('shipping_postal_code')
                                            <span class="text-xs text-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                        <label class="block">
                                            <span class="font-medium text-slate-600 dark:text-navy-100">City</span>
                                            <span class="relative mt-1.5 flex">
                                                <input
                                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                    placeholder="City/Town" type="text" name="shipping_city"
                                                    value="{{ old('shipping_city', $sponsor?->shipping_city) }}"
                                                    :required="!sameBillingAddress" />
                                                <span
                                                    class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                                    <i class="fa-solid fa-city text-base"></i>
                                                </span>
                                            </span>
                                        </label>
                                        @error('shipping_city')
                                            <span class="text-xs text-error">{{ $message }}</span>
                                        @enderror
                                        <label class="block">
                                            <span class="font-medium text-slate-600 dark:text-navy-100">State</span>
                                            <span class="relative mt-1.5 flex">
                                                <input
                                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                    placeholder="State" type="text" name="shipping_state"
                                                    value="{{ old('shipping_state', $sponsor?->shipping_state) }}"
                                                    :required="!sameBillingAddress" />
                                                <span
                                                    class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                                    <i class="fa-solid fa-flag"></i>
                                                </span>
                                            </span>
                                        </label>
                                        @error('shipping_state')
                                            <span class="text-xs text-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <label class="block">
                                        <span class="font-medium text-slate-600 dark:text-navy-100">Country</span>
                                        <span class="relative mt-1.5 flex">
                                            {{-- <input
                                                class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                placeholder="Country" type="text" name="shipping_country"
                                                value="{{ old('shipping_country', $sponsor?->shipping_country) }}" /> --}}
                                            <select
                                                class="form-select peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent z-50"
                                                name="shipping_country" :required="!sameBillingAddress">
                                                <option value="">Select Country</option>
                                                @foreach (countries() as $country)
                                                    <option value="{{ $country->code_2 }}"
                                                        @selected(old('shipping_country', $sponsor?->shipping_country) == $country->code_2)>
                                                        {{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                            <span
                                                class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                                <i class="fa-solid fa-flag-usa text-base"></i>
                                            </span>
                                        </span>
                                    </label>
                                    @error('shipping_country')
                                        <span class="text-xs text-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-center mt-6">
                        <button type="submit"
                            class="btn space-x-2 bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            <span>Save Address</span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</x-layouts.app-layout>
