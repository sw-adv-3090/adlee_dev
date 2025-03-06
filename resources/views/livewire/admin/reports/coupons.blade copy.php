<div class="col-span-12">
    <div class="mb-5 flex items-center flex-wrap gap-5">
        <label class="block">
            <select
                class="form-select w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                wire:model.live="value">
                <option>Select Filter Type</option>
                @foreach ($filters as $item)
                    <option value="{{ $item['value'] }}">{{ $item['text'] }}</option>
                @endforeach

            </select>
        </label>
        @if (isset($filter['type']) && $filter['type'] === 'select')
            <label class="block">
                <select
                    class="form-select w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent min-w-[300px]"
                    wire:model.live="search">
                    <option>Please choose a option</option>
                    @foreach ($filter['options'] as $option)
                        <option value="{{ $option['value'] }}">{{ $option['text'] }}</option>
                    @endforeach

                </select>
            </label>
        @endif

        @if (isset($filter['type']) && $filter['type'] === 'input')
            @if (isset($filter['options']))
                <label class="block">
                    <select
                        class="form-select w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent min-w-[300px]"
                        wire:model.live="operator">
                        <option>Please choose a operator</option>
                        @foreach ($filter['options'] as $option)
                            <option value="{{ $option['value'] }}">{{ $option['text'] }}</option>
                        @endforeach

                    </select>
                </label>
            @endif

            @if (!empty($operator) && $operator === 'between')
                <label class="block">
                    <input
                        class="form-input w-full rounded-lg border border-slate-300 px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent bg-white min-w-[300px]"
                        placeholder="Start" type="text" wire:model.live="start" />
                </label>
                <label class="block">
                    <input
                        class="form-input w-full rounded-lg border border-slate-300 px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent bg-white min-w-[300px]"
                        placeholder="End" type="text" wire:model.live="end" />
                </label>
            @else
                <label class="block">
                    <input
                        class="form-input w-full rounded-lg border border-slate-300 px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent bg-white min-w-[300px]"
                        placeholder="Search..." type="text" wire:model.live="search" />
                </label>
            @endif


        @endif

        @if (isset($filter['type']) && $filter['type'] === 'date')
            <label class="block">
                <select
                    class="form-select w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent min-w-[300px]"
                    wire:model.live="operator">
                    <option>Please choose a operator</option>
                    @foreach ($filter['options'] as $option)
                        <option value="{{ $option['value'] }}">{{ $option['text'] }}</option>
                    @endforeach

                </select>
            </label>
            @if (!empty($operator) && $operator === 'between')
                <label class="relative flex">
                    <input x-init="$el._x_flatpickr = flatpickr($el)"
                        class="form-input peer w-full rounded-lg border border-slate-300 bg-white px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent min-w-[300px]"
                        placeholder="Start Date" type="text" wire:model.live="start" />
                    <span
                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 transition-colors duration-200"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </span>
                </label>
                <label class="relative flex">
                    <input x-init="$el._x_flatpickr = flatpickr($el)"
                        class="form-input peer w-full rounded-lg border border-slate-300 bg-white px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent min-w-[300px]"
                        placeholder="End Date" type="text" wire:model.live="end" />
                    <span
                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 transition-colors duration-200"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </span>
                </label>
            @else
                <label class="relative flex">
                    <input x-init="$el._x_flatpickr = flatpickr($el)"
                        class="form-input peer w-full rounded-lg border border-slate-300 bg-white px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent min-w-[300px]"
                        placeholder="Please select date" type="text" wire:model.live="search" />
                    <span
                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 transition-colors duration-200"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </span>
                </label>
            @endif

        @endif
        {{-- <label class="relative flex">
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
        </label> --}}

        {{-- <label class="relative flex">
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
        </label> --}}
    </div>

    <div class="card px-4 pb-4 sm:px-5 mt-3">
        <div class="my-3 flex h-8 items-center justify-between">
            <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                Coupons
            </h2>
            {{-- <h2 class="tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base font-semibold">
                ${{ number_abbreviate($transactions->sum('paid_amount')) }}
            </h2> --}}
        </div>
        <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr>
                        <th
                            class="whitespace-nowrap rounded-tl-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            #
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            Sponsor
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            Template
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            Name
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            Number
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            Type
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            Amount
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            Paid
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            Status
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            Action
                        </th>
                        <th
                            class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            More
                        </th>
                    </tr>
                </thead>
                @forelse ($coupons as $coupon)
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
                    <tbody x-data="{ expanded: false }">
                        <tr class="border-y border-transparent">
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                {{ $loop->iteration + $coupons->firstItem() - 1 }}

                            </td>
                            <td class="whitespace-nowrap flex items-center gap-2 px-4 py-3 sm:px-5">
                                <div class="avatar flex">
                                    <img class="rounded-full" src="{{ asset($coupon->sponsor?->company_logo) }}"
                                        alt="ٰImage" />
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm">{{ $coupon->sponsor?->company_name }}</span>
                                    <span>{{ $coupon->user?->email }}</span>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                <div class="avatar flex">
                                    <img class="rounded-full" src="{{ asset($coupon->template->preview) }}"
                                        alt="{{ $coupon->template->title }}" />
                                </div>
                            </td>
                            <td
                                class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                {{ $coupon->title }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                {{ $coupon->number }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                {{ is_null($coupon->booklet_id) ? 'Virtual' : 'Physical' }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                ${{ $coupon->amount }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                ${{ $paidAmount }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                <div class="flex space-x-2">
                                    <div class="badge rounded-full border border-info text-info">
                                        {{ $status }}
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                <a href="{{ route('admin.coupons.show', $coupon) }}"
                                    class="text-primary cursor-pointer disabled:text-gray-300 disabled:cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                        <path
                                            d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                                    </svg>
                                </a>

                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                <button @click="expanded = !expanded"
                                    class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                    <i :class="expanded && '-rotate-180'"
                                        class="fas fa-chevron-down text-sm transition-transform"></i>
                                </button>
                            </td>
                        </tr>
                        <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                            <td colspan="100" class="p-0">
                                <div x-show="expanded" x-collapse>
                                    <div class="px-4 pb-4 sm:px-5">
                                        <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                                            <table class="is-hoverable w-full text-left">
                                                <tbody>
                                                    @if ($coupon->booklet)
                                                        <tr
                                                            class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                            <td
                                                                class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                                Booklet
                                                            </td>
                                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                                {{ $coupon->booklet->title }}
                                                                ({{ $coupon->booklet->number }})
                                                            </td>
                                                        </tr>
                                                    @endif

                                                    <tr
                                                        class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                        <td
                                                            class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                            Language
                                                        </td>
                                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5 capitalize">
                                                            {{ $coupon->language }}
                                                        </td>
                                                    </tr>
                                                    <tr
                                                        class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                        <td
                                                            class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                            Payout Deadline
                                                        </td>
                                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                            {{ $coupon->payout_deadline }} days
                                                        </td>
                                                    </tr>
                                                    <tr
                                                        class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                        <td
                                                            class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-red-600 dark:text-navy-100 lg:px-5">
                                                            Payout Scheduled For
                                                        </td>
                                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5 text-red-600">
                                                            {{ $coupon->payout_on?->format('m-d-Y') ?? '-' }}
                                                        </td>
                                                    </tr>
                                                    <tr
                                                        class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                        <td
                                                            class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                            Shorten URL For Activation
                                                        </td>
                                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                            {{ $coupon->shorten_url_activate }}
                                                        </td>
                                                    </tr>
                                                    <tr
                                                        class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                        <td
                                                            class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                            Shorten URL For Redeem
                                                        </td>
                                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                            {{ $coupon->shorten_url_redeem }}
                                                        </td>
                                                    </tr>
                                                    <tr
                                                        class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                        <td
                                                            class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                            Created On
                                                        </td>
                                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                            {{ $coupon->created_at->format('m-d-Y h:i:A') ?? '-' }}
                                                        </td>
                                                    </tr>
                                                    <tr
                                                        class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                        <td
                                                            class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                            Activated On
                                                        </td>
                                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                            {{ $coupon->activated_at?->format('m-d-Y h:i:A') ?? '-' }}
                                                        </td>
                                                    </tr>
                                                    <tr
                                                        class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                        <td
                                                            class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                            Redeemed At
                                                        </td>
                                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                            {{ $coupon->redeemed_at?->format('m-d-Y h:i:A') ?? '-' }}
                                                        </td>
                                                    </tr>
                                                    <tr
                                                        class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                        <td
                                                            class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                            Signed At
                                                        </td>
                                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                            {{ $coupon->task?->signed_at?->format('m-d-Y h:i:A') ?? '-' }}
                                                        </td>
                                                    </tr>
                                                    <tr
                                                        class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                        <td
                                                            class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                            Printed At
                                                        </td>
                                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                            {{ $coupon->task?->printed_at?->format('m-d-Y h:i:A') ?? '-' }}
                                                        </td>
                                                    </tr>
                                                    <tr
                                                        class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                        <td
                                                            class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-red-600 dark:text-navy-100 lg:px-5">
                                                            Payout Completed At
                                                        </td>
                                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5 text-red-600">
                                                            {{ $coupon->payout_at?->format('m-d-Y h:i:A') ?? '-' }}
                                                        </td>
                                                    </tr>

                                                    @foreach ($coupon->transactions as $transaction)
                                                        <tr
                                                            class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                            <td
                                                                class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                                Payout {{ $loop->iteration }} of
                                                                ${{ $transaction->amount }} at
                                                            </td>
                                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                                {{ $transaction->created_at->format('m-d-Y h:i:A') }}
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-right">
                                            <button @click="expanded = false"
                                                class="btn mt-2 h-8 rounded px-3 text-xs+ font-medium text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                                                Hide
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                @empty
                    <tbody>
                        <tr class="border-y border-transparent">
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5" colspan="11">No coupon</td>
                        </tr>
                    </tbody>
                @endforelse

            </table>
        </div>

        <div class="px-4 py-4">
            {{ $coupons->links() }}
        </div>
    </div>
</div>
