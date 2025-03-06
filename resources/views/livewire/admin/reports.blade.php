<div class="col-span-12">
    <div class="mb-5 flex items-center justify-center gap-5">
        <label class="relative flex">
            <input x-init="$el._x_flatpickr = flatpickr($el)"
                class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                placeholder="Start Date" type="text" wire:model.live="start" />
            <span
                class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 transition-colors duration-200" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </span>
        </label>
        <label class="relative flex">
            <input x-init="$el._x_flatpickr = flatpickr($el)"
                class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                placeholder="End Date" type="text" wire:model.live="end" />
            <span
                class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 transition-colors duration-200" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </span>
        </label>
    </div>

    <div class="card px-4 pb-4 sm:px-5 mt-3">
        <div class="my-3 flex h-8 items-center justify-between">
            <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                Payment Processed
            </h2>
            <h2 class="tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base font-semibold">
                ${{ number_abbreviate($transactions->sum('paid_amount')) }}
            </h2>
        </div>
        <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                        <th
                            class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                            #
                        </th>
                        <th
                            class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                            Receiver
                        </th>
                        <th
                            class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                            Coupon
                        </th>
                        <th
                            class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                            Amount
                        </th>
                        <th
                            class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                            Credit Card Transaction Fee
                        </th>
                        <th
                            class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                            Service Fee
                        </th>
                        <th
                            class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                            Amount Paid
                        </th>
                        <th
                            class="whitespace-nowrap px-3 py-3 font-semibold uppercase text-slate-800 dark:text-navy-100 lg:px-5">
                            Date
                        </th>
                    </tr>
                </thead>
                @forelse ($transactions as $payment)
                    <tbody x-data="{ expanded: false }">
                        <tr class="border-y border-transparent">
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                {{ $loop->iteration + $transactions->firstItem() - 1 }}
                            </td>
                            <td class="whitespace-nowrap flex items-center gap-2 px-4 py-3 sm:px-5">
                                <div class="avatar flex">
                                    <img class="rounded-full" src="{{ asset($payment->receiver?->avatar) }}"
                                        alt="ٰImage" />
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm">{{ $payment->receiver?->name }}</span>
                                    <span>{{ $payment->receiver?->email }}</span>
                                </div>
                            </td>
                            <td
                                class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                {{ $payment->coupon->number }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5 text-center">
                                ${{ number_format($payment->amount, 2) }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5 text-center">
                                ${{ number_format($payment->transaction_fee, 2) }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5 text-center">
                                ${{ number_format($payment->service_fee, 2) }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5 text-center">
                                ${{ number_format($payment->paid_amount, 2) }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                {{ $payment->created_at->format('F j, Y h:i:A') }}
                            </td>
                        </tr>
                    </tbody>
                @empty
                    <tbody>
                        <tr class="border-y border-transparent">
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5" colspan="8">No payment yet</td>
                        </tr>
                    </tbody>
                @endforelse

            </table>
        </div>

        <div class="px-4 py-4">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
