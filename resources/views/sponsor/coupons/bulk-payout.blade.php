<x-layouts.app-layout title="Bulk Payout Coupons" is-sidebar-open="true">
    <div
        class="flex flex-col items-center justify-between space-y-2 text-center sm:flex-row sm:space-y-0 sm:text-left mt-6">
        <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
            Bulk Payout Coupons
        </h2>

        <a href="{{ $data['isBookletCoupons'] ? route('sponsors.booklets.show', $data['bookletId']) : route('sponsors.coupons.index') }}"
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
        <div class="col-span-12 grid lg:col-span-8">
            <div class="card p-4 sm:p-5">
                <form action="{{ route('sponsors.coupons.payout.bulk.send') }}" method="post">
                    @csrf

                    <div
                        class="is-scrollbar-hidden min-w-full overflow-x-auto rounded-lg border border-slate-200 dark:border-navy-500">
                        <table class="w-full text-left">
                            <tbody>
                                <tr>
                                    <th
                                        class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                        Coupons
                                    </th>
                                    <td
                                        class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                        {{ $data['total'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <th
                                        class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                        Already paid out
                                    </th>
                                    <td
                                        class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                        {{ $data['paidOut'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <th
                                        class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                        Coupons not redeemed yet
                                    </th>
                                    <td
                                        class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                        {{ $data['notRedemed'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <th
                                        class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                        Coupons not signed yet
                                    </th>
                                    <td
                                        class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                        {{ $data['notSigned'] }}
                                    </td>
                                </tr>
                                <tr>
                                    <th
                                        class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                        Coupons not printed yet
                                    </th>
                                    <td
                                        class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                        {{ $data['notPrinted'] }}
                                    </td>
                                </tr>

                                <tr>
                                    <th
                                        class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                        Coupons ready to payout
                                    </th>
                                    <td
                                        class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                        {{ count($data['coupons']) }}
                                    </td>
                                </tr>
                                @if (count($data['coupons']) > 0)
                                    @foreach ($data['coupons'] as $coupon)
                                        <tr>
                                            <td class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5"
                                                colspan="2">
                                                <div class="flex flex-wrap items-center justify-between gap-3 mb-2">
                                                    <div class="flex gap-2">
                                                        <span class="font-medium">Coupon Number: </span>
                                                        <span>{{ $coupon['number'] }} </span>
                                                    </div>
                                                    <div class="flex gap-2">
                                                        <span class="font-medium">Amount: </span>
                                                        <span>${{ $coupon['amount'] }} </span>
                                                    </div>
                                                    <div class="flex gap-2">
                                                        <span class="font-medium">Paid: </span>
                                                        <span>${{ $coupon['paid'] }} </span>
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <input type="hidden" name="coupons[{{ $loop->iteration }}][uuid]"
                                                        value="{{ $coupon['uuid'] }}">
                                                    <label class="block">
                                                        <input type="number"
                                                            name="coupons[{{ $loop->iteration }}][amount]"
                                                            class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                            placeholder="Amount to be send" min="1"
                                                            max="{{ $coupon['remaining'] }}" required autofocus />
                                                    </label>
                                                    <span class="text-tiny+ text-slate-400 dark:text-navy-300">
                                                        Sending limit is ${{ $coupon['remaining'] }}
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td class="whitespace-nowrap border border-slate-200 px-3 py-2 dark:border-navy-500 lg:px-5 text-center"
                                            colspan="2">
                                            <button type="submit"
                                                class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                                Send Payment
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-layouts.app-layout>
