<div class="mt-10">
    <div class="flex items-center justify-between">
        <h2 class="text-base font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
            Coupons
        </h2>
        <div class="flex space-x-3">
            <div class="flex items-center" x-data="{ isInputActive: false }">
                <label class="block">
                    <input x-effect="isInputActive === true && $nextTick(() => { $el.focus()});"
                        :class="isInputActive ? 'w-32 lg:w-48' : 'w-0'"
                        class="form-input bg-transparent px-1 text-right transition-all duration-100 placeholder:text-slate-500 dark:placeholder:text-navy-200"
                        placeholder="Search here..." type="text" wire:model.live="search" />
                </label>
                <button @click="isInputActive = !isInputActive"
                    class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
            <div class="flex items-center space-x-2 text-xs+">
                <span>Show</span>
                <label class="block">
                    <select
                        class="form-select rounded-full border border-slate-300 bg-white px-2 py-1 pr-6 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                        wire:model.live="limit">
                        <option value="10">10</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                    </select>
                </label>
                <span>entries</span>
            </div>
        </div>
    </div>

    <div class="card mt-3">
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
                            Number
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

                $status = 'Activated';
                if (!is_null($coupon->activated_at)) {
                $status = 'Activated';
                }

                if (!is_null($coupon->redeemed_at)) {
                $status = 'Redeemed';
                }

                if (!is_null($coupon->task?->signed_at)) {
                $status = 'Signed';
                }

                if (!is_null($coupon->task?->printed_at)) {
                $status = 'Printed';
                }

                if ($paidAmount != 0) {
                $status = 'Partial Paid Out';
                }

                if (!is_null($coupon->payout_at)) {
                $status = 'Paid Out';
                }
                @endphp
                <tbody x-data="{ expanded: false }">
                    <tr class="border-y border-transparent">
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{ $loop->iteration }}</td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            {{ $coupon->number }}
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
                            <div x-data="usePopper({ placement: 'bottom-start', offset: 4 })" @click.outside="if(isShowPopper) isShowPopper = false"
                                class="inline-flex" wire:ignore>
                                @if(!is_null($coupon->task?->printed_at))
                                <a href="{{ route('ad-space-owner.coupons.sign.download', $coupon) }}"
                                    class="btn space-x-2 bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor" class="bi bi-check-lg"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z" />
                                                    </svg> -->
                                    <span> Download Agreement</span></a>
                                @else
                                <a href="{{ route('ad-space-owner.coupons.redeem.index', $coupon) }}"
                                    class="btn space-x-2 bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor" class="bi bi-check-lg"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z" />
                                                    </svg> -->
                                    <span> Redeem Coupon</span></a>
                                @endif
                                
                                <?php
                                /*
                                <!-- <button
                                    class="btn space-x-2 bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90"
                                    x-ref="popperRef" @click="isShowPopper = !isShowPopper">
                                    <span>Actions</span>
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="size-4 transition-transform duration-200"
                                        :class="isShowPopper && 'rotate-180'" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button> -->
                                <!-- <div x-ref="popperRoot" class="popper-root" :class="isShowPopper && 'show'">
                                    <div
                                        class="popper-box rounded-md border border-slate-150 bg-white py-1.5 font-inter dark:border-navy-500 dark:bg-navy-700">
                                        <ul>

                                            @if (!is_null($coupon->task?->template_id))
                                            <li>
                                                <a href="{{ route('template.preview1', ['template' => $coupon->template, 'coupon' => $coupon->id]) }}"
                                                    class="flex h-8 items-center space-x-3 px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="size-5 rotate-45" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                                    </svg>
                                                    <span> View Template</span></a>
                                            </li>
                                            @endif

                                            <li
                                                class="{{ !is_null($coupon->redeemed_at) ? 'pointer-events-none cursor-default text-gray-300' : '' }}">
                                                <a href="{{ route('ad-space-owner.coupons.redeem.index', $coupon) }}"
                                                    class="flex h-8 items-center space-x-3 px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                        height="16" fill="currentColor" class="bi bi-check-lg"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z" />
                                                    </svg>
                                                    <span> Redeem Coupon</span></a>
                                            </li>

                                            <li
                                                class="{{ !is_null($coupon->task?->signed_at) || is_null($coupon->redeemed_at) ? 'pointer-events-none cursor-default text-gray-300' : '' }}">
                                                <a href="{{ route('ad-space-owner.coupons.sign.index', $coupon) }}"
                                                    class="flex h-8 items-center space-x-3 px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                        height="14" fill="currentColor" class="bi bi-pen"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z" />
                                                    </svg>
                                                    <span> E-sign Task</span></a>
                                            </li>

                                            <li>
                                                <form method="POST"
                                                    action="{{ route('ad-space-owner.coupons.task.print', $coupon) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="flex h-8 items-center space-x-3 px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100 w-full disabled:pointer-events-none disabled:cursor-default disabled:text-gray-300 disabled:opacity-50"
                                                        @disabled(is_null($coupon->task?->signed_at) || !is_null($coupon->task?->printed_at))>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                            height="14" fill="currentColor"
                                                            class="bi bi-printer" viewBox="0 0 16 16">
                                                            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1" />
                                                            <path
                                                                d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1" />
                                                        </svg>
                                                        <span> Print Template</span></button>
                                                </form>

                                            </li>

                                            <li
                                                class="{{ is_null($coupon->task?->signed_at) ? 'pointer-events-none cursor-default text-gray-300' : '' }}">
                                                <a href="{{ route('ad-space-owner.coupons.sign.download', $coupon) }}"
                                                    class="flex h-8 items-center space-x-3 px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                        height="14" fill="currentColor" class="bi bi-download"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                                                        <path
                                                            d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z" />
                                                    </svg>
                                                    <span> Downoad the agreement file</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div> -->
                                */
                                ?>
                            </div>
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
                                                        {{ $coupon->payout_deadline }} days after redemption
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
                                                @if (is_null($coupon->task?->signed_at) || is_null($coupon->task->printed_at))
                                                <tr
                                                    class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <td class="whitespace-nowrap px-3 py-3 font-semibold  text-red-600 lg:px-5 text-center"
                                                        colspan="2">
                                                        You can't get payment until an you have
                                                        finished signing and printing the template.
                                                    </td>
                                                </tr>
                                                @endif
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
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5" colspan="7">No coupon</td>
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