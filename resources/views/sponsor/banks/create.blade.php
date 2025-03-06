<x-layouts.app-layout title="New Bank Accounts" is-sidebar-open="true">
    <div
        class="flex flex-col items-center justify-between space-y-2 text-center sm:flex-row sm:space-y-0 sm:text-left mt-6">
        <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
            New Bank Accounts
        </h2>

        <a href="{{ route('sponsors.banks.index') }}"
            class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                class="bi bi-chevron-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
            </svg>
            <span> Back </span>
        </a>
    </div>

    @include('partials.alert')


    <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6 mt-8">
        <div class="col-span-12 grid lg:col-span-9">
            <div class="card p-4 sm:p-5">
                <form action="{{ route('sponsors.banks.store') }}" method="post">
                    @csrf
                    <div class="mt-4 space-y-5">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <label class="block">
                                <span class="font-medium text-slate-600 dark:text-navy-100">Account Holder Name</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Account Holder Name" type="text" name="account_holder_name"
                                        value="{{ old('account_holder_name') }}" required />
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-solid fa-user text-base"></i>
                                    </span>
                                </span>
                            </label>
                            @error('account_holder_name')
                                <span class="text-xs text-error">{{ $message }}</span>
                            @enderror
                            <label class="block">
                                <span class="font-medium text-slate-600 dark:text-navy-100">Routing Number</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Routing Number" type="text" name="routing_number"
                                        value="{{ old('routing_number') }}" required />
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-solid fa-map-marked-alt text-base"></i>
                                    </span>
                                </span>
                            </label>
                            @error('routing_number')
                                <span class="text-xs text-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <label class="block">
                                <span class="font-medium text-slate-600 dark:text-navy-100">Account Number</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                        placeholder="Account Number" type="text" name="account_number"
                                        value="{{ old('account_number') }}" required />
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-solid fa-city text-base"></i>
                                    </span>
                                </span>
                            </label>
                            @error('account_number')
                                <span class="text-xs text-error">{{ $message }}</span>
                            @enderror

                            <label class="block">
                                <span class="font-medium text-slate-600 dark:text-navy-100">Account Type</span>
                                <span class="relative mt-1.5 flex">
                                    <select
                                        class="form-select peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent z-50"
                                        name="account_type" required>
                                        <option value="">Select Account Type</option>
                                        <option value="checking" @selected(old('account_type') == 'checking')>
                                            Checking</option>
                                        <option value="savings" @selected(old('account_type') == 'savings')>
                                            Savings</option>
                                    </select>
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-solid fa-flag-usa text-base"></i>
                                    </span>
                                </span>
                            </label>
                            @error('account_type')
                                <span class="text-xs text-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1">
                            <label class="block">
                                <span class="font-medium text-slate-600 dark:text-navy-100">Account Holder Type</span>
                                <span class="relative mt-1.5 flex">
                                    <select
                                        class="form-select peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent z-50"
                                        name="account_holder_type" required>
                                        <option value="">Select Account Holder Type</option>
                                        <option value="individual" @selected(old('account_holder_type') == 'individual')>
                                            Individual</option>
                                        <option value="company" @selected(old('account_holder_type') == 'company')>
                                            Company</option>
                                    </select>
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-solid fa-flag-usa text-base"></i>
                                    </span>
                                </span>
                            </label>
                            @error('account_holder_type')
                                <span class="text-xs text-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-center mt-6">
                        <button type="submit"
                            class="btn space-x-2 bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            <span>Save Bank Account</span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</x-layouts.app-layout>
