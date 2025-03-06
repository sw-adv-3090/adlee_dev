<x-layouts.app-layout title="Deactivate Coupon" is-sidebar-open="true">
    <div
        class="flex flex-col items-center justify-between space-y-2 text-center sm:flex-row sm:space-y-0 sm:text-left mt-6">
        <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
            Deactivate Coupon
        </h2>

        <a href="{{ coupon_return_url($coupon) }}"
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

    <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6 mt-8" x-data="{ showModal: false }">
        <div class="col-span-12 grid lg:col-span-8">
            <div class="card p-4 sm:p-5">

                <div
                    class="is-scrollbar-hidden min-w-full overflow-x-auto rounded-lg border border-slate-200 dark:border-navy-500">
                    <table class="w-full text-left">
                        <tbody>
                            <tr>
                                <th
                                    class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                    Sponsor
                                </th>
                                <td
                                    class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                    {{ $coupon->sponsor?->company_name }}
                                </td>
                            </tr>
                            @if ($coupon->redeem)
                                <tr>
                                    <th
                                        class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                        Assign To
                                    </th>
                                    <td
                                        class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                        {{ $coupon->redeem?->name }} ({{ $coupon->redeem?->email }})
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <th
                                    class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                    Title
                                </th>
                                <td
                                    class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                    {{ $coupon->title }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                    Coupon Number
                                </th>
                                <td
                                    class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                    {{ $coupon->number }}
                                </td>
                            </tr>
                            @if ($coupon->booklet)
                                <tr>
                                    <th
                                        class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                        Booklet Number
                                    </th>
                                    <td
                                        class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                        {{ $coupon->booklet->number }}
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <th
                                    class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                    Amount
                                </th>
                                <td
                                    class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                    ${{ $coupon->amount }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                    Activated At
                                </th>
                                <td
                                    class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                    {{ $coupon->activated_at->format('F j, Y h:i:A') }}
                                </td>
                            </tr>


                        </tbody>
                    </table>
                </div>
                <div class="mt-5 text-center">
                    <button type="button" @click="showModal = true"
                        class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-70 disabled:cursor-not-allowed"
                        @disabled(!is_null($coupon->redeemed_at))>
                        <span>Deactivate Coupon </span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-x-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                            <path
                                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                        </svg>
                    </button>

                    <template x-teleport="#x-teleport-target">
                        <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
                            <div class="absolute inset-0 bg-slate-900/60 transition-opacity duration-300"
                                @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"></div>
                            <div class="relative w-full max-w-2xl origin-bottom rounded-lg bg-white pb-4 transition-all duration-300 dark:bg-navy-700"
                                x-show="showModal" x-transition:enter="easy-out"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="easy-in"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95">
                                <div
                                    class="flex justify-between rounded-t-lg bg-slate-200 px-4 py-3 dark:bg-navy-800 sm:px-5">
                                    <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                                        Deactivate Coupon
                                    </h3>
                                    <button @click="showModal = !showModal"
                                        class="btn -mr-1.5 size-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>

                                <div class="p-4 sm:p-5">

                                    <div class="text-center mt-3">
                                        <p class="text-sm font-normal text-slate-600 mb-4">Are you sure to deactivate
                                            coupon?
                                        </p>
                                        <form action="{{ route('sponsors.coupons.deactivate.store', $coupon) }}"
                                            method="post">
                                            @csrf
                                            <button type="submit"
                                                class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-70 disabled:cursor-not-allowed"
                                                @disabled(!is_null($coupon->redeemed_at))>
                                                <span>Dectivate Coupon</span>
                                            </button>
                                        </form>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </template>

                </div>
            </div>
        </div>
    </div>

</x-layouts.app-layout>
