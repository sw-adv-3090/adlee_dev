<x-layouts.app-layout title="Ship From Address" is-sidebar-open="true">
    <div
        class="mt-6 flex flex-col items-center justify-between space-y-2 text-center sm:flex-row sm:space-y-0 sm:text-left">
        <div class="flex items-center space-x-1">
            <h2 class="text-xl font-medium text-slate-700 line-clamp-1 dark:text-navy-50">
                Ship From Address
            </h2>
        </div>
    </div>

    @include('partials.alert')

    <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6 mt-8">
        <div class="col-span-12 grid lg:col-span-8">
            <div class="card p-4 sm:p-5">
                <div class="">
                    <h3 class="font-medium text-slate-600 dark:text-navy-100 text-lg">Shipengine Address</h3>
                    <p class="my-1.5">Write down shipment from address that will be apply to every created label on
                        shipengine.
                    </p>
                </div>
                <form action="{{ route('admin.settings.ship-from-address.update') }}" method="post">
                    @csrf
                    <div class="space-y-5 mt-4">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <label class="block">
                                <span class="font-medium text-slate-600 dark:text-navy-100">Name</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Name" type="text" name="ship_from_name"
                                        value="{{ old('ship_from_name', settings('ship_from_name')) }}" required />
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-regular fa-user text-base"></i>
                                    </span>
                                </span>
                            </label>
                            @error('ship_from_name')
                                <span class="text-xs text-error">{{ $message }}</span>
                            @enderror
                            <label class="block">
                                <span class="font-medium text-slate-600 dark:text-navy-100">Company Name</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Company Name" type="text" name="ship_from_company_name"
                                        value="{{ old('ship_from_company_name', settings('ship_from_company_name')) }}"
                                        required />
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-regular fa-building text-base"></i>
                                    </span>
                                </span>
                            </label>
                            @error('ship_from_company_name')
                                <span class="text-xs text-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <label class="block">
                                <span class="font-medium text-slate-600 dark:text-navy-100">Address (Line 1)</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Address line 1" type="text" name="ship_from_address"
                                        value="{{ old('ship_from_address', settings('ship_from_address')) }}"
                                        required />
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-solid fa-map-marker-alt text-base"></i>
                                    </span>
                                </span>
                            </label>
                            @error('ship_from_address')
                                <span class="text-xs text-error">{{ $message }}</span>
                            @enderror
                            <label class="block">
                                <span class="font-medium text-slate-600 dark:text-navy-100">Postal Code</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Postal Code" type="text" name="ship_from_postal_code"
                                        value="{{ old('ship_from_postal_code', settings('ship_from_postal_code')) }}"
                                        required />
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-solid fa-map-marked-alt text-base"></i>
                                    </span>
                                </span>
                            </label>
                            @error('ship_from_postal_code')
                                <span class="text-xs text-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <label class="block">
                                <span class="font-medium text-slate-600 dark:text-navy-100">City</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="City/Town" type="text" name="ship_from_city"
                                        value="{{ old('ship_from_city', settings('ship_from_city')) }}" required />
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-solid fa-city text-base"></i>
                                    </span>
                                </span>
                            </label>
                            @error('ship_from_city')
                                <span class="text-xs text-error">{{ $message }}</span>
                            @enderror

                            <label class="block">
                                <span class="font-medium text-slate-600 dark:text-navy-100">State</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="State" type="text" name="ship_from_state"
                                        value="{{ old('ship_from_state', settings('ship_from_state')) }}" required />
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-solid fa-flag"></i>
                                    </span>
                                </span>
                            </label>
                            @error('ship_from_state')
                                <span class="text-xs text-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <label class="block">
                                <span class="font-medium text-slate-600 dark:text-navy-100">Country</span>
                                <span class="relative mt-1.5 flex">

                                    <select
                                        class="form-select peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent z-50"
                                        name="ship_from_country" required>
                                        <option value="">Select Country</option>
                                        @foreach (countries() as $country)
                                            <option value="{{ $country->code_2 }}" @selected(old('ship_from_country', settings('ship_from_country')) == $country->code_2)>
                                                {{ $country->name }}</option>
                                        @endforeach

                                    </select>
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-solid fa-flag-usa text-base"></i>
                                    </span>
                                </span>
                            </label>
                            @error('ship_from_country')
                                <span class="text-xs text-error">{{ $message }}</span>
                            @enderror
                            <label class="block">
                                <span class="font-medium text-slate-600 dark:text-navy-100">Phone Number</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Phone Number" type="text" name="ship_from_phone"
                                        value="{{ old('ship_from_phone', settings('ship_from_phone')) }}" required />
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa fa-phone"></i>
                                    </span>
                                </span>
                            </label>
                            @error('ship_from_phone')
                                <span class="text-xs text-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="text-center mt-8">
                        <button type="submit"
                            class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            Save
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-layouts.app-layout>
