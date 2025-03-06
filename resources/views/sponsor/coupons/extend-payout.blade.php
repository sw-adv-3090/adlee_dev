<x-layouts.app-layout title="Extend Coupon Payout Deadline" is-sidebar-open="true">
    <div
        class="flex flex-col items-center justify-between space-y-2 text-center sm:flex-row sm:space-y-0 sm:text-left mt-6">
        <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
            Modify Payout Deadline
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
    @php
    $amount = $coupon->amount;
    $paidAmount = $coupon->transactions_sum_amount ?? 0;
    $remaining = $amount - $paidAmount;
    @endphp

    <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6 mt-8">
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
                            <tr>
                                <th
                                    class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                    Amount
                                </th>
                                <td
                                    class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                    ${{ $amount }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                    Paid Amount
                                </th>
                                <td
                                    class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                    ${{ $paidAmount }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                    Remaining Amount
                                </th>
                                <td
                                    class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                    ${{ $remaining }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                    Payout Deadline
                                </th>
                                <td
                                    class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                    {{ $coupon->payout_on->format('F j, Y h:i:A') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5"
                                    colspan="2">
                                    <form action="{{ route('sponsors.coupons.payout.extend', $coupon) }}" method="post"
                                        class="flex items-center gap-3">
                                        @csrf
                                        <span class="flex-1 relative">
                                            <input x-init="$el._x_flatpickr = flatpickr($el, {
                                            altInput: true,
                                            altFormat: 'F j, Y',
                                            dateFormat: 'Y-m-d',
                                            minDate: '{{  now()->addDay()->format('Y-m-d')}}',
                                        })"
                                                class="form-input mt-1.5 peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                placeholder="Choose date..." type="text" name="days" />
                                            <span
                                                class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="size-5 transition-colors duration-200" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </span>
                                        </span>
                                        <button type="submit"
                                            class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 ">
                                            Modify Deadline
                                        </button>

                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-layouts.app-layout>