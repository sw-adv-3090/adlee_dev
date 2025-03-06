<div class="mt-10">
    <div class="flex items-center justify-between">
        <h2 class="text-base font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
            Booklets
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

    <a id="bulkActivate"
        class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 mt-3 hidden">
        <span> Bulk Activate </span>
    </a>

    <div class="card mt-3" x-data="{ warnModal: false }">
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
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            Template
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            Title
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
                            Coupons
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            Actions
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            View Coupons
                        </th>
                        <th
                            class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            More
                        </th>
                    </tr>
                </thead>

                @forelse ($booklets as $booklet)


                @php
                $wizard_status = $booklet->prints_count == 0 ? 'printing' : ($booklet->activated_count == 0 ? 'activate' : 'completed');
                @endphp

                <tbody x-data="{ expanded: false }">
                    <tr class="border-y border-transparent">
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            {{-- {{ $loop->iteration }} --}}
                            <input
                                class="form-checkbox is-basic size-5 rounded border-slate-400/70 checked:bg-slate-500 checked:border-slate-500 hover:border-slate-500 focus:border-slate-500 dark:border-navy-400 dark:checked:bg-navy-400 disabled:opacity-50 disabled:cursor-default all-check"
                                type="checkbox" value="{{ $booklet->id }}" />
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            <div class="avatar flex">
                                <img class="rounded-full" src="{{ asset($booklet->template->preview) }}"
                                    alt="{{ $booklet->template->title }}" />
                            </div>
                        </td>
                        <td
                            class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                            {{ $booklet->title }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            {{ $booklet->number }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            ${{ $booklet->amount }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            {{ $booklet->coupons_count }}
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            @if($wizard_status != 'completed')

                            <a href="{{ route('sponsors.booklets.create',['booklet'=>$booklet,'wizard_view' => $wizard_status]) }}"
                                class="text-primary flex h-8 items-center space-x-3 px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-primary focus:bg-slate-100 focus:text-primary dark:hover:bg-navy-600 dark:hover:text-primary dark:focus:bg-navy-600 dark:focus:text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z" />
                                </svg>
                                <span> Continue</span></a>

                            @endif
                        </td>

                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            <a href="{{ route('sponsors.booklets.show', $booklet) }}"
                                class="text-primary flex h-8 items-center space-x-3 px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-primary focus:bg-slate-100 focus:text-primary dark:hover:bg-navy-600 dark:hover:text-primary dark:focus:bg-navy-600 dark:focus:text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                    height="14" fill="currentColor" class="bi bi-eye"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                    <path
                                        d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                </svg>
                                <?php /* <span> View booklet coupons</span> */ ?>
                            </a>
                            <?php /*
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
                                                <a href="{{ route('sponsors.booklets.show', $booklet) }}"
                                                    class="text-primary flex h-8 items-center space-x-3 px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-primary focus:bg-slate-100 focus:text-primary dark:hover:bg-navy-600 dark:hover:text-primary dark:focus:bg-navy-600 dark:focus:text-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                                        height="14" fill="currentColor" class="bi bi-eye"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                                        <path
                                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                                    </svg>
                                                    <span> View booklet coupons</span></a>
                                            </li>
                                            @if($wizard_status != 'completed')
                                            <li>
                                                <a href="{{ route('sponsors.booklets.create',['booklet'=>$booklet,'wizard_view' => $wizard_status]) }}"
                                                    class="text-primary flex h-8 items-center space-x-3 px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-primary focus:bg-slate-100 focus:text-primary dark:hover:bg-navy-600 dark:hover:text-primary dark:focus:bg-navy-600 dark:focus:text-primary">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z" />
                                                    </svg>
                                                    <span> Continue</span></a>
                                            </li>
                                            @endif

                                            {{--
                                                <li>
                                                    <a href="{{ route('sponsors.booklets.activate.index', $booklet) }}"
                                            class="text-info flex h-8 items-center space-x-3 px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-info focus:bg-slate-100 focus:text-info dark:hover:bg-navy-600 dark:hover:text-info dark:focus:bg-navy-600 dark:focus:text-info">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                height="16" fill="currentColor" class="bi bi-check-lg"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425z" />
                                            </svg>
                                            <span> Activate Booklet</span></a>
                                            </li>
                                            --}}

                                            
                                                <li>
                                                    {{-- wire:click="print({{ $booklet->id }})" --}}
                                                    <button type="button"
                                                        wire:click="hanldePrintClick({{ $booklet->id }})"
                                                        @click="warnModal = true; isShowPopper = false;"
                                                        {{-- wire:confirm="You are going to print booklet. If you are free resources remain in your free booklet print for this month then you will not be charged but if free limit exceeded then you will be charged first then booklet will be printed." --}}
                                                        class="text-success flex h-8 items-center space-x-3 px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-success focus:bg-slate-100 focus:text-success dark:hover:bg-navy-600 dark:hover:text-success dark:focus:bg-navy-600 dark:focus:text-success w-full disabled:opacity-50 disabled:text-gray-400"
                                                        @disabled($booklet->prints_count != 0)>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor" class="bi bi-printer"
                                                            viewBox="0 0 16 16">
                                                            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1" />
                                                            <path
                                                                d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1" />
                                                        </svg>
                                                        <span> Print Booklet</span></button>
                                                </li>
                                               


                                            {{-- @if ($booklet->prints_count > 0) --}}
                                            {{-- @if ($booklet->shipments)
                                                    <li>
                                                        <a href="{{ route('sponsors.booklets.shipments', $booklet) }}"
                                            class="text-warning flex h-8 items-center space-x-3 px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-warning focus:bg-slate-100 focus:text-warning dark:hover:bg-navy-600 dark:hover:text-warning dark:focus:bg-navy-600 dark:focus:text-warning w-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                height="16" fill="currentColor"
                                                class="bi bi-truck" viewBox="0 0 16 16">
                                                <path
                                                    d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5zm1.294 7.456A2 2 0 0 1 4.732 11h5.536a2 2 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456M12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2" />
                                            </svg>
                                            <span> Shipments Status</span>
                                            </a>
                                            </li>
                                            @endif --}}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            */
                            ?>

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
                                                        Book Number
                                                    </td>
                                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                        {{ $booklet->number }}
                                                    </td>
                                                </tr>
                                                <tr
                                                    class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <td
                                                        class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                        Total Coupons
                                                    </td>
                                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                        {{ $booklet->coupons_count }}
                                                    </td>
                                                </tr>
                                                <tr
                                                    class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <td
                                                        class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                        Activated Coupons
                                                    </td>
                                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                        {{ $booklet->activated_count }}
                                                    </td>
                                                </tr>
                                                <tr
                                                    class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <td
                                                        class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                        Unactivated Coupons
                                                    </td>
                                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                        {{ $booklet->coupons_count - $booklet->activated_count }}
                                                    </td>
                                                </tr>
                                                <tr
                                                    class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <td
                                                        class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                        Allocated Coupons (Send to BBO)
                                                    </td>
                                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                        {{ $booklet->allocated_count }}
                                                    </td>
                                                </tr>
                                                <tr
                                                    class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <td
                                                        class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                        Redeemed Coupons
                                                    </td>
                                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                        {{ $booklet->redeemeds_count }}
                                                    </td>
                                                </tr>
                                                <tr
                                                    class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <td
                                                        class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                        Paid Out Coupons
                                                    </td>
                                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                        {{ $booklet->paids_count }}
                                                    </td>
                                                </tr>
                                                <tr
                                                    class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <td
                                                        class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                        Language
                                                    </td>
                                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5 capitalize">
                                                        {{ $booklet->language }}
                                                    </td>
                                                </tr>
                                                <tr
                                                    class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <td
                                                        class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                        Payout Deadline
                                                    </td>
                                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                        {{ $booklet->payout_deadline }} days
                                                    </td>
                                                </tr>
                                                <tr
                                                    class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <td
                                                        class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                        Created On
                                                    </td>
                                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                        {{ $booklet->created_at->format('m-d-Y h:i:A') ?? '-' }}
                                                    </td>
                                                </tr>
                                                @foreach ($booklet->prints as $job)
                                                <tr
                                                    class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <th class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5"
                                                        colspan="2">
                                                        Prints Job {{ $loop->iteration }}
                                                    </th>
                                                </tr>
                                                <tr
                                                    class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <td
                                                        class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                        Amount Paid For Printing
                                                    </td>
                                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                        ${{ $job->amount_paid }}
                                                    </td>
                                                </tr>
                                                <tr
                                                    class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <td
                                                        class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                        Type
                                                    </td>
                                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5 capitalize">
                                                        {{ $job->type }}
                                                    </td>
                                                </tr>
                                                <tr
                                                    class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <td
                                                        class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                        Status
                                                    </td>
                                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5 capitalize">
                                                        {{ $job->status }}
                                                    </td>
                                                </tr>
                                                <tr
                                                    class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                    <td
                                                        class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                        Print Initiated At
                                                    </td>
                                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5 capitalize">
                                                        {{ $job->created_at->format('F j, Y h:i:A') }}
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
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5" colspan="8">No booklet</td>
                    </tr>
                </tbody>
                @endforelse



            </table>
        </div>

        <template x-teleport="#x-teleport-target">
            <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                x-show="warnModal" role="dialog" @keydown.window.escape="warnModal = false">
                <div class="absolute inset-0 bg-slate-900/60 transition-opacity duration-300"
                    @click="warnModal = false" x-show="warnModal" x-transition:enter="ease-out"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"></div>
                <div class="relative w-full max-w-2xl origin-bottom rounded-lg bg-white pb-4 transition-all duration-300 dark:bg-navy-700"
                    x-show="warnModal" x-transition:enter="easy-out" x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="easy-in"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                    <div class="flex justify-between rounded-t-lg bg-slate-200 px-4 py-3 dark:bg-navy-800 sm:px-5">
                        <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">

                        </h3>
                        <button @click="warnModal = false"
                            class="btn -mr-1.5 size-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25 z-[9999]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12">
                                </path>
                            </svg>
                        </button>
                    </div>

                    <div class="p-4 sm:p-5">
                        <div class="text-center">
                            <p class="text-sm font-normal text-slate-600 mb-4">
                                @if ($data['isOnBasicPlan'])
                                {{ __('You are on basic plan which does not include any free booklet print. In order to print this booklet you will be charged for $' . $data['bookletFee'] . '.') }}
                                @elseif ($data['bookletRemaining'] == 0)
                                {{ __("You have no more free booklets left this month. In order to proceed with printing your booklet and shipping it to you, you will be charged $" . $data['bookletFee'] . '.') }}
                                @else
                                <?php /* {{ __('You are left ' . $data['bookletRemaining'] . " free booklet print for this month. In order to print and ship this booklet to you, you will be charged for $0") }} */ ?>
                                {{ __("You have no more free booklets left this month. In order to proceed with printing your booklet and shipping it to you, you will be charged $" . $data['bookletFee'] . '.') }}
                                @endif
                            </p>



                            <div class="flex items-center justify-center gap-3 flex-wrap mt-10"
                                x-data="{ isDisabled: false }">
                                @if ($data['isOnBasicPlan'])
                                <a href="{{ route('sponsors.plans.index') }}"
                                    class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-70 disabled:cursor-not-allowed">
                                    <span>Upgrade Plan</span>
                                </a>
                                @endif
                                <button type="button" wire:click="print"
                                    class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-70 disabled:cursor-not-allowed"
                                    x-bind:disabled="isDisabled" @click="isDisabled = true">
                                    <span>Continue Printing</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" fill="currentColor"
                                        class="bi bi-chevron-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708" />
                                    </svg>
                                </button>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </template>

        {{-- <div
            class="flex flex-col justify-between space-y-4 px-4 py-4 sm:flex-row sm:items-center sm:space-y-0 sm:px-5">
            <div class="text-xs+">1 - 10 of 10 entries</div>

            <ol class="pagination">
                <li class="rounded-l-full bg-slate-150 dark:bg-navy-500">
                    <a href="#"
                        class="flex size-8 items-center justify-center rounded-full text-slate-500 transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:text-navy-200 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                </li>
                <li class="bg-slate-150 dark:bg-navy-500">
                    <a href="#"
                        class="flex h-8 min-w-[2rem] items-center justify-center rounded-full px-3 leading-tight transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">1</a>
                </li>
                <li class="bg-slate-150 dark:bg-navy-500">
                    <a href="#"
                        class="flex h-8 min-w-[2rem] items-center justify-center rounded-full bg-primary px-3 leading-tight text-white transition-colors hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">2</a>
                </li>
                <li class="bg-slate-150 dark:bg-navy-500">
                    <a href="#"
                        class="flex h-8 min-w-[2rem] items-center justify-center rounded-full px-3 leading-tight transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">3</a>
                </li>
                <li class="bg-slate-150 dark:bg-navy-500">
                    <a href="#"
                        class="flex h-8 min-w-[2rem] items-center justify-center rounded-full px-3 leading-tight transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">4</a>
                </li>
                <li class="bg-slate-150 dark:bg-navy-500">
                    <a href="#"
                        class="flex h-8 min-w-[2rem] items-center justify-center rounded-full px-3 leading-tight transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">5</a>
                </li>
                <li class="rounded-r-full bg-slate-150 dark:bg-navy-500">
                    <a href="#"
                        class="flex size-8 items-center justify-center rounded-full text-slate-500 transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:text-navy-200 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </li>
            </ol>
        </div> --}}
    </div>
</div>