<x-layouts.app-layout title="{{ __('Dashboard') }}" is-sidebar-open="true">

    @include('partials.alert')

    <div class="mt-4 grid grid-cols-12 gap-4 sm:mt-5 sm:gap-5 lg:mt-6 lg:gap-6">
        <div class="col-span-12 space-y-4 sm:space-y-5 lg:col-span-8 lg:space-y-6">
            <div class="grid grid-cols-1 space-y-4">
                <div class="card bg-gradient-to-r from-blue-500 to-indigo-600 px-5 pb-5">
                    <div>
                        <div class="ax-transparent-gridline mt-5 w-full">
                            <div x-init="$nextTick(() => {
                                $el._x_chart = new ApexCharts($el, pages.charts.earningWhite);
                                $el._x_chart.render()
                            });"></div>
                        </div>
                        <p class="mt-3 text-base font-medium tracking-wide text-indigo-100">
                            Earnings
                        </p>
                        <p class="mt-4 font-inter text-2xl font-semibold">
                            <span class="text-indigo-100">$</span>
                            <span class="text-white">{{ number_format($data['earned'], 2) }}</span>
                        </p>
                    </div>
                    <div class="absolute bottom-0 right-0 overflow-hidden rounded-lg">
                        <img class="w-24 translate-x-1/4 translate-y-1/4 opacity-50"
                            src="{{ asset('images/illustrations/the-dollar.svg') }}" alt="image" />
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-4 sm:col-span-2 sm:grid-cols-2 sm:gap-5 lg:gap-6">
                    <div class="card justify-center p-4.5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
                                    {{ $data['tickets'] }}
                                </p>
                                <p class="text-xs+ line-clamp-1">Coupons</p>
                            </div>
                            <div class="mask is-star flex size-10 shrink-0 items-center justify-center bg-success">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="card justify-center p-4.5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
                                    {{ $data['paid_out'] }}
                                </p>
                                <p class="text-xs+ line-clamp-1">Paid Coupons</p>
                            </div>
                            <div class="mask is-star flex size-10 shrink-0 items-center justify-center bg-info">
                                <svg class="size-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.5293 18L20.9999 8.40002" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M3 13.2L7.23529 18L17.8235 6" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>

                            </div>
                        </div>
                    </div>
                    <div class="card justify-center p-4.5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
                                    {{ $data['partial_paid_out'] }}
                                </p>
                                <p class="text-xs+ line-clamp-1">Partial Paid Coupons</p>
                            </div>
                            <div class="mask is-star flex size-10 shrink-0 items-center justify-center bg-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="card justify-center p-4.5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-base font-semibold text-slate-700 dark:text-navy-100">
                                    {{ $data['tickets_needs_action'] }}
                                </p>
                                <p class="text-xs+ line-clamp-1">Coupon's Need Action</p>
                            </div>
                            <div class="mask is-star flex size-10 shrink-0 items-center justify-center bg-warning">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-12 lg:col-span-4">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-1 lg:gap-6">
                <div class="card px-4 pb-4 sm:px-5">
                    <div class="my-3 flex h-8 items-center justify-between">
                        <h2 class="font-medium tracking-wide text-slate-700 dark:text-navy-100">
                            Recent Payments
                        </h2>
                        <a href="{{ route('ad-space-owner.transactions') }}"
                            class="border-b border-dotted border-current pb-0.5 text-xs+ font-medium text-primary outline-none transition-colors duration-300 hover:text-primary/70 focus:text-primary/70 dark:text-accent-light dark:hover:text-accent-light/70 dark:focus:text-accent-light/70">View
                            All</a>
                    </div>
                    <div class="space-y-3.5">
                        @forelse ($data['transactions'] as $payment)
                            <div class="flex cursor-pointer items-center justify-between">
                                <div class="flex items-center space-x-3.5">
                                    <div class="avatar">
                                        <img class="rounded-full" src="{{ $payment->sender?->avatar }}"
                                            alt="avatar" />
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-700 dark:text-navy-100">
                                            {{ $payment->sender?->name }}
                                        </p>
                                        <p class="text-xs text-slate-400 line-clamp-1 dark:text-navy-300">
                                            {{ $payment->created_at?->format('F j, Y h:i:A') }}
                                        </p>
                                    </div>
                                </div>
                                <p class="font-medium text-slate-600 dark:text-navy-100">
                                    ${{ number_format($payment->receiver_amount, 2) }}
                                </p>
                            </div>
                        @empty
                            <div class="flex items-center justify-between">
                                <p class="font-medium text-slate-600 dark:text-navy-100">
                                    No payment yet
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- projects --}}
    <div
        class="mt-10 flex flex-col items-center justify-between space-y-2 text-center sm:flex-row sm:space-y-0 sm:text-left">
        <div>
            <h3 class="text-xl font-semibold text-slate-700 dark:text-navy-100">
            Open Coupons
            </h3>
            <p class="mt-1 hidden sm:block">List of your ongoing Coupons</p>
        </div>

    </div>
    <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3 lg:gap-6 xl:grid-cols-4">
        @forelse ($data['tasks'] as $task)
            <a href="{{ !is_null($task->coupon?->uuid) ? route('ad-space-owner.coupons.show', $task->coupon->uuid) : '#' }}"
                class="card shadow-none">
                <div
                    class="flex flex-1 flex-col justify-between rounded-lg bg-success/15 p-4 dark:bg-transparent sm:p-5">
                    <div>
                        <div class="flex items-start justify-between">
                            <img class="size-12 rounded-lg object-cover object-center"
                                src="{{ asset($task->template?->preview) }}" alt="image" />
                            <p class="text-xs+">{{ $task->created_at->format('F j, Y') }}</p>
                        </div>
                        <h3 class="mt-3 font-medium text-slate-700 line-clamp-2 dark:text-navy-100">
                            {{ $task->coupon?->title }}
                        </h3>
                        <p class="text-xs+ capitalize">{{ $task->language ?? $task->coupon?->language }}</p>
                    </div>
                    <div>

                        <div class="mt-5 flex flex-wrap space-x-3">
                            <div class="size-10 hover:z-10">
                                <img class="rounded-full border-1 border-white dark:border-navy-700"
                                    src="{{ asset($task->sponsor?->company_logo) }}" alt="avatar"
                                    class="object-contain" />
                            </div>
                            <p class="font-medium text-slate-600 dark:text-navy-100">
                                {{ $task->sponsor?->company_name }}
                            </p>
                        </div>
                        <div>
                        <h3 class="mt-1 font-medium text-slate-700 line-clamp-2 dark:text-navy-100">
                                Amount: ${{ $task->coupon?->amount ?? 0 }}
                        </h3>
                         
                        </div>
                        <div>
                        <h3 class="mt-1 font-medium text-slate-700 line-clamp-2 dark:text-navy-100">
                                Balance: ${{ max(0, ($task->coupon?->amount ?? 0) - ($task->coupon?->transactions_sum_amount ?? 0)) }}
                        </h3>
                         
                        </div>
                        <div class="mt-4 flex items-center justify-between space-x-2">
                            <div class="badge h-5.5 rounded-full bg-success px-2 text-xs+ text-white">
                                {{ round(now()->diffInDays($task->coupon?->payout_on)) }} days left
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="flex cursor-pointer items-center justify-between">
                <p class="font-medium text-slate-600 dark:text-navy-100">
                    No active project yet
                </p>
            </div>
        @endforelse

    </div>
</x-layouts.app-layout>
