<div class="mt-10">
    @php
        $ids = $coupons->pluck('uuid');
    @endphp
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

    {{-- <div class="mt-3">
        @if (count($selected) > 0)
            <a href="{{ route('sponsors.coupons.activate.bulk.index', ['coupons' => $selected]) }}"
                class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                <span> Bulk Activate </span>
            </a>
        @endif
    </div> --}}

    <a id="bulkActivate"
        class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 mt-3 hidden">
        <span> Bulk Activate </span>
    </a>
    <a id="bulkPayout"
        class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 mt-3 hidden">
        <span> Bulk Payout </span>
    </a>

    <div class="card mt-3">
        <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr>
                        <th
                            class="whitespace-nowrap rounded-tl-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            {{-- # --}}
                            <input
                                class="form-checkbox is-basic size-5 rounded border-slate-400/70 checked:bg-slate-500 checked:border-slate-500 hover:border-slate-500 focus:border-slate-500 dark:border-navy-400 dark:checked:bg-navy-400"
                                type="checkbox" id="select-all" />
                            {{-- wire:click="toggleSelect('all',{{ $ids }})" --}}
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
                                {{-- {{ $loop->iteration }} --}}
                                <input
                                    class="form-checkbox is-basic size-5 rounded border-slate-400/70 checked:bg-slate-500 checked:border-slate-500 hover:border-slate-500 focus:border-slate-500 dark:border-navy-400 dark:checked:bg-navy-400 disabled:opacity-50 disabled:cursor-default all-check"
                                    type="checkbox" value="{{ $coupon->uuid }}" />
                                {{-- wire:click="toggleSelect('id',{{ $coupon->uuid }})"  @checked(in_array($coupon->uuid, $selected)) --}}
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
                                    <button
                                        class="btn space-x-2 bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90"
                                        x-ref="popperRef" @click="isShowPopper = !isShowPopper">
                                        <span>Actions</span>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="size-4 transition-transform duration-200"
                                            :class="isShowPopper && 'rotate-180'" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div x-ref="popperRoot" class="popper-root" :class="isShowPopper && 'show'">
                                        <div
                                            class="popper-box rounded-md border border-slate-150 bg-white py-1.5 font-inter dark:border-navy-500 dark:bg-navy-700">
                                            <ul>
                                                <li>
                                                    <a href="{{ route('template.preview1', $coupon->template) }}?coupon={{ $coupon->id}}" target="_blank"
                                                        class="flex h-8 items-center space-x-3 px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="mt-px size-4.5"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                            stroke-width="1.5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                        <span> View Coupon</span></a>
                                                </li>
                                                @if (!is_null($coupon->task?->template_id))
                                                    <li>
                                                        <a href="{{ route('template.preview1', ['template' => $coupon->template]) }}"
                                                            class="flex h-8 items-center space-x-3 px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="size-5 rotate-45" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                                            </svg>
                                                            <span> View Task</span></a>
                                                    </li>
                                                @endif
                                                
                                                <li
                                                    class="{{ !is_null($coupon->activated_at) ? 'pointer-events-none cursor-default text-gray-300' : '' }}">
                                                    <a href="{{ route('sponsors.coupons.activate.index', $coupon) }}"
                                                        class="flex h-8 items-center space-x-3 px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor" class="bi bi-check-lg"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z" />
                                                        </svg>
                                                        <span> Activate Coupon</span></a>
                                                </li>

                                                <li
                                                    class="{{ !is_null($coupon->redeemed_at) || is_null($coupon->activated_at) ? 'pointer-events-none cursor-default text-gray-300' : '' }}">
                                                    <a href="{{ route('sponsors.coupons.deactivate.index', $coupon) }}"
                                                        class="flex h-8 items-center space-x-3 px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor" class="bi bi-x"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                                        </svg>
                                                        <span> Deactivate Coupon</span></a>
                                                </li>

                                                <li
                                                    class="{{ $coupon->redeemed_by || $coupon->booklet_id ? 'pointer-events-none cursor-default text-gray-300' : '' }}">
                                                    <a href="{{ route('sponsors.coupons.send.index', $coupon) }}"
                                                        class="flex h-8 items-center space-x-3 px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                            height="14" fill="currentColor" class="bi bi-send"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76z" />
                                                        </svg>
                                                        <span> Send Coupon</span></a>
                                                </li>

                                                <li
                                                    class="{{ $coupon->redeemed_by ? 'pointer-events-none cursor-default text-gray-300' : '' }}">
                                                    <a href="{{ route('sponsors.coupons.activate.index', $coupon) }}"
                                                        class="flex h-8 items-center space-x-3 px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                            height="14" fill="currentColor"
                                                            class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                            <path
                                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                            <path fill-rule="evenodd"
                                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                                        </svg>
                                                        <span> Edit Coupon</span></a>
                                                </li>

                                                <li
                                                    class="{{ is_null($coupon->payout_on) || $coupon->payout_at ? 'pointer-events-none cursor-default text-gray-300' : '' }}">
                                                    <a href="{{ route('sponsors.coupons.payout.extend.index', $coupon) }}"
                                                        class="flex h-8 items-center space-x-3 px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100 w-full">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                            height="14" fill="currentColor"
                                                            class="bi bi-patch-plus" viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd"
                                                                d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5" />
                                                            <path
                                                                d="m10.273 2.513-.921-.944.715-.698.622.637.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01.622-.636a2.89 2.89 0 0 1 4.134 0l-.715.698a1.89 1.89 0 0 0-2.704 0l-.92.944-1.32-.016a1.89 1.89 0 0 0-1.911 1.912l.016 1.318-.944.921a1.89 1.89 0 0 0 0 2.704l.944.92-.016 1.32a1.89 1.89 0 0 0 1.912 1.911l1.318-.016.921.944a1.89 1.89 0 0 0 2.704 0l.92-.944 1.32.016a1.89 1.89 0 0 0 1.911-1.912l-.016-1.318.944-.921a1.89 1.89 0 0 0 0-2.704l-.944-.92.016-1.32a1.89 1.89 0 0 0-1.912-1.911z" />
                                                        </svg>
                                                        <span> Modify Payout Deadline</span></a>
                                                </li>

                                                <li
                                                    class="{{ is_null($coupon->task?->signed_at) || is_null($coupon->task->printed_at) || $coupon->payout_at ? 'pointer-events-none cursor-default text-gray-300' : '' }}">
                                                    <a href="{{ route('sponsors.coupons.payout.index', $coupon) }}"
                                                        class="flex h-8 items-center space-x-3 px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100 w-full">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                            height="14" fill="currentColor" class="bi bi-coin"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518z" />
                                                            <path
                                                                d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                            <path
                                                                d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11m0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12" />
                                                        </svg>
                                                        <span> Payout</span></a>
                                                </li>

                                                <li>
                                                    <form method="POST"
                                                        action="{{ route('sponsors.coupons.destroy', $coupon) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure to delete coupon?')">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit"
                                                            class="flex h-8 items-center space-x-3 px-3 pr-8 font-medium tracking-wide text-error outline-none transition-all hover:bg-error/20 focus:bg-error/20 disabled:pointer-events-none disabled:cursor-default disabled:text-gray-300 w-full"
                                                            @disabled(!is_null($coupon->activated_at))>
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor" stroke-width="1.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                            <span> Delete Coupon</span></button>
                                                    </form>

                                                </li>
                                            </ul>
                                        </div>
                                    </div>
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
                                                    @if (is_null($coupon->task?->signed_at) || is_null($coupon->task->printed_at))
                                                        <tr
                                                            class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                            <td class="whitespace-nowrap px-3 py-3 font-semibold  text-red-600 lg:px-5 text-center"
                                                                colspan="2">
                                                                You can't make payment until an Ad Space Owner has
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
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5" colspan="9">No coupon</td>
                        </tr>
                    </tbody>
                @endforelse

            </table>
        </div>

        {{-- {{ $coupons->links('pagination') }} --}}
        <div class="px-4 py-4">
            {{ $coupons->links() }}
        </div>
    </div>
</div>
