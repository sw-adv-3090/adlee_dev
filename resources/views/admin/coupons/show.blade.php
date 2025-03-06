<x-layouts.app-layout title="Coupon Detail" is-sidebar-open="true" main="false">
    <!-- Main Content Wrapper -->
    <main class="main-content w-full pb-8">
        <div class="mt-4 px-[var(--margin-x)] sm:mt-5">
            <div
                class="flex flex-col items-center justify-between space-y-2 text-center sm:flex-row sm:space-y-0 sm:text-left mt-6">
                <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                    Coupon Details
                </h2>

                <a href="{{ route('admin.coupons.index') }}"
                    class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                        class="bi bi-chevron-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
                    </svg>
                    <span> Back </span>
                </a>
            </div>

            @php
                $paidAmount = $coupon->transactions_sum_amount ?? 0;

                $status = 'Created';
                if ($coupon->redeemed_by) {
                    $status = 'Invited to Redeem';
                }

                if ($coupon->activated_at) {
                    $status = 'Activated';
                }

                if ($coupon->redeemed_at) {
                    $status = 'Redeemed';
                }

                if ($coupon->task?->signed_at) {
                    $status = 'Signed';
                }

                if ($coupon->task?->printed_at) {
                    $status = 'Printed';
                }

                if ($paidAmount != 0) {
                    $status = 'Partial Paid Out';
                }

                if ($coupon->payout_at) {
                    $status = 'Paid Out';
                }

            @endphp

            <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6 mt-5">
                <div class="col-span-12">
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
                                            Language
                                        </th>
                                        <td
                                            class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5 capitalize">
                                            {{ $coupon->language }}
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
                                                {{ $coupon->booklet->title }}
                                                ({{ $coupon->booklet->number }})
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th
                                            class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                            Payout Scheduled For
                                        </th>
                                        <td
                                            class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5 text-red-600">
                                            {{ $coupon->payout_on?->format('m-d-Y') ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <td
                                            class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                            Shorten URL For Activation
                                        </td>
                                        <td
                                            class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                            {{ $coupon->shorten_url_activate }}
                                        </td>
                                    </tr>
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
                                            Payout Deadline
                                        </th>
                                        <td
                                            class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                            {{ $coupon->payout_deadline }} days
                                        </td>
                                    </tr>

                                    <tr class="">
                                        <td
                                            class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                            Shorten URL For Redeem
                                        </td>
                                        <td
                                            class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                            {{ $coupon->shorten_url_redeem }}
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <td
                                            class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                            Created On
                                        </td>
                                        <td
                                            class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                            {{ $coupon->created_at->format('m-d-Y h:i:A') ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <td
                                            class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                            Activated On
                                        </td>
                                        <td
                                            class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                            {{ $coupon->activated_at?->format('m-d-Y h:i:A') ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <td
                                            class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                            Redeemed At
                                        </td>
                                        <td
                                            class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                            {{ $coupon->redeemed_at?->format('m-d-Y h:i:A') ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <td
                                            class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                            Signed At
                                        </td>
                                        <td
                                            class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                            {{ $coupon->task?->signed_at?->format('m-d-Y h:i:A') ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <td
                                            class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                            Printed At
                                        </td>
                                        <td
                                            class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                            {{ $coupon->task?->printed_at?->format('m-d-Y h:i:A') ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr class="">
                                        <td
                                            class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                            Payout Completed At
                                        </td>
                                        <td
                                            class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5 text-red-600">
                                            {{ $coupon->payout_at?->format('m-d-Y h:i:A') ?? '-' }}
                                        </td>
                                    </tr>
                                    @foreach ($coupon->transactions as $transaction)
                                        <tr class="">
                                            <td
                                                class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                                Payout {{ $loop->iteration }} of
                                                ${{ $transaction->amount }} at
                                            </td>
                                            <td
                                                class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                                {{ $transaction->created_at->format('m-d-Y h:i:A') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th
                                            class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                            Status
                                        </th>
                                        <td
                                            class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                            <div class="badge rounded-full border border-info text-info">
                                                {{ $status }}
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
</x-layouts.app-layout>
