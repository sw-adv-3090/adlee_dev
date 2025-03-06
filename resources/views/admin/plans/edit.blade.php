<x-layouts.app-layout title="Update Plan" is-sidebar-open="true">
    <div
        class="mt-6 flex flex-col items-center justify-between space-y-2 text-center sm:flex-row sm:space-y-0 sm:text-left">
        <div class="flex items-center space-x-1">
            <h2 class="text-xl font-medium text-slate-700 line-clamp-1 dark:text-navy-50">
                Update Plan
            </h2>
        </div>
        <a href="{{ route('admin.plans.index') }}"
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

    <div class="grid grid-cols-12 mt-8">
        <div class="col-span-12 lg:col-span-8">
            <div class="card">
                <div class="tabs flex flex-col">
                    <div class="tab-content p-4 sm:p-5">
                        <form action="{{ route('admin.plans.update', $plan) }}" method="post">
                            @csrf
                            @method('put')

                            <div class="space-y-5" x-data="{ show: '{{ old('type', $plan->type) === 'sponsor' ? true : false }}' }">
                                {{-- plan type --}}
                                <label class="block">
                                    <span class="font-medium text-slate-600 dark:text-navy-100">Plan Type</span>
                                    <select
                                        class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                                        name="type" required
                                        x-on:change="show = $event.target.value != 'ad-space-owner'">
                                        <option value="">Choose Plan Type</option>
                                        @foreach ($types as $type)
                                            <option value="{{ $type->value }}" @selected($plan->type === $type->value)>
                                                {{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </label>
                                @error('type')
                                    <span class="text-xs text-error">{{ $message }}</span>
                                @enderror

                                {{-- plan name --}}
                                <label class="block">
                                    <span class="font-medium text-slate-600 dark:text-navy-100">Name</span>
                                    <input
                                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent "
                                        placeholder="Enter plan name" type="text" name="name"
                                        value="{{ old('name', $plan->name) }}" required />
                                </label>
                                @error('name')
                                    <span class="text-xs text-error">{{ $message }}</span>
                                @enderror

                                {{-- plan price --}}
                                <div>
                                    <span class="font-medium text-slate-600 dark:text-navy-100">Plan Price</span>
                                    <label class="mt-1.5 flex -space-x-px">
                                        <div
                                            class="flex items-center justify-center rounded-l-lg border border-slate-300 px-3.5 font-inter dark:border-navy-450">
                                            <span class="-mt-1">$</span>
                                        </div>
                                        <input
                                            class="form-input w-full rounded-r-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Plan Price" type="text" name="price"
                                            value="{{ old('price', $plan->price) }}" required />
                                    </label>
                                    @error('price')
                                        <span class="text-xs text-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- ach transaction fee --}}
                                <div x-show="show">
                                    <span class="font-medium text-slate-600 dark:text-navy-100">ACH Transaction
                                        Fee</span>
                                    <label class="mt-1.5 flex -space-x-px">
                                        <div
                                            class="flex items-center justify-center rounded-l-lg border border-slate-300 px-3.5 font-inter  dark:border-navy-450">
                                            <span class="-mt-1">%</span>
                                        </div>
                                        <input
                                            class="form-input w-full rounded-r-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="ACH Transaction Percentage" type="text"
                                            name="ach_transaction_fee"
                                            value="{{ old('ach_transaction_fee', $plan->ach_transaction_fee) }}" />
                                    </label>
                                    @error('ach_transaction_fee')
                                        <span class="text-xs text-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- credit card transaction fee --}}
                                <div x-show="show">
                                    <span class="font-medium text-slate-600 dark:text-navy-100">Credit Card Transaction
                                        Fee</span>
                                    <label class="mt-1.5 flex -space-x-px">
                                        <div
                                            class="flex items-center justify-center rounded-l-lg border border-slate-300 px-3.5 font-inter  dark:border-navy-450">
                                            <span class="-mt-1">%</span>
                                        </div>
                                        <input
                                            class="form-input w-full rounded-r-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Credit Card Transaction Percentage" type="text"
                                            name="credit_card_transaction_fee"
                                            value="{{ old('credit_card_transaction_fee', $plan->credit_card_transaction_fee) }}" />
                                    </label>
                                    @error('credit_card_transaction_fee')
                                        <span class="text-xs text-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- transaction service fee --}}
                                <div x-show="show">
                                    <span class="font-medium text-slate-600 dark:text-navy-100">Transaction Service
                                        Fee</span>
                                    <label class="mt-1.5 flex -space-x-px">
                                        <div
                                            class="flex items-center justify-center rounded-l-lg border border-slate-300 px-3.5 font-inter  dark:border-navy-450">
                                            <span class="-mt-1">%</span>
                                        </div>
                                        <input
                                            class="form-input w-full rounded-r-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Transaction Service Fee Percentage" type="text"
                                            name="transaction_service_fee"
                                            value="{{ old('transaction_service_fee', $plan->transaction_service_fee) }}" />
                                    </label>
                                    @error('transaction_service_fee')
                                        <span class="text-xs text-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- template limit for each category --}}
                                <label class="block" x-show="show">
                                    <span class="font-medium text-slate-600 dark:text-navy-100">Template Limit</span>
                                    <p class="my-1.5">
                                        {{ __('Enter amount of templates allowed per category. If you want unlimited, put a very high number like 10000.') }}
                                    </p>
                                    <input
                                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent "
                                        placeholder="Enter free booklets offer in plan, please write 0 if offer no booklet"
                                        type="number" name="template_limit"
                                        value="{{ old('template_limit', $plan->template_limit) }}" />
                                </label>
                                @error('template_limit')
                                    <span class="text-xs text-error">{{ $message }}</span>
                                @enderror

                                {{-- free booklet --}}
                                <label class="block" x-show="show">
                                    <span class="font-medium text-slate-600 dark:text-navy-100">Free Booklets</span>
                                    <input
                                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent "
                                        placeholder="Enter free booklets offer in plan, please write 0 if offer no booklet"
                                        type="number" name="free_booklets"
                                        value="{{ old('free_booklets', $plan->free_booklets) }}" />
                                </label>
                                @error('free_booklets')
                                    <span class="text-xs text-error">{{ $message }}</span>
                                @enderror

                                {{-- booklet price and pages --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" x-show="show">
                                    <div>
                                        <label class="block">
                                            <span class="font-medium text-slate-600 dark:text-navy-100">Booklet
                                                Pages</span>
                                            <input
                                                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent "
                                                placeholder="Enter booklet pages" type="number" name="booklet_pages"
                                                value="{{ old('booklet_pages', $plan->booklet_pages) }}"
                                                step="50" />
                                        </label>
                                        @error('booklet_pages')
                                            <span class="text-xs text-error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <span class="font-medium text-slate-600 dark:text-navy-100">Booklet Fee</span>
                                        <label class="mt-1.5 flex -space-x-px">
                                            <div
                                                class="flex items-center justify-center rounded-l-lg border border-slate-300 px-3.5 font-inter dark:border-navy-450">
                                                <span class="-mt-1">$</span>
                                            </div>
                                            <input
                                                class="form-input w-full rounded-r-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                placeholder="Booklet Fee" type="text" name="booklet_fee"
                                                value="{{ old('booklet_fee', $plan->booklet_fee) }}" />
                                        </label>
                                        @error('booklet_fee')
                                            <span class="text-xs text-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="flex justify-center space-x-2 pt-4">
                                    <a href="{{ route('admin.plans.index') }}"
                                        class="btn min-w-[7rem] border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                        Cancel
                                    </a>
                                    <button type="submit"
                                        class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app-layout>
