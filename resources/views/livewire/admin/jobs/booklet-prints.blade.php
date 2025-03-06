<div class="mt-10">
    <div class="flex items-center justify-between">
        <h2 class="text-base font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
            Booklets Print Requests
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
                            User
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            Booklet Title
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            Booklet Number
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            Coupons
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
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        </th>
                    </tr>
                </thead>
                @forelse ($requests as $item)
                    <tbody x-data="{ expanded: false }">
                        <tr class="border-y border-transparent">
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                {{ $loop->iteration + $requests->firstItem() - 1 }}</td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                <div class="flex items-center space-x-3">
                                    <div class="avatar">
                                        <img class="rounded-full" src="{{ asset($item->user?->avatar) }}"
                                            alt="{{ $item->user?->name }}" />
                                    </div>
                                    <div class="flex flex-col">
                                        <span>{{ $item->user?->name }}</span>
                                        <span>{{ $item->user?->email }}</span>
                                    </div>
                                </div>

                            </td>
                            <td
                                class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                {{ $item->booklet?->title }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                {{ $item->booklet?->number }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                {{ $item->booklet?->coupons?->count() ?? 0 }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                <div class="flex space-x-2">
                                    <div class="badge rounded-full border border-info text-info capitalize">
                                        {{ $item->status }}
                                    </div>
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                <a href="{{ route('admin.jobs.booklet-prints.shipment.index', $item) }}"
                                    class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                    @if ($item->shipment)
                                        <span> Details </span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8" />
                                        </svg>
                                    @else
                                        <span> Shipment </span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
                                            <path
                                                d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5zm1.294 7.456A2 2 0 0 1 4.732 11h5.536a2 2 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456M12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2" />
                                        </svg>
                                    @endif

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
                                                    <tr
                                                        class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                        <td
                                                            class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                            Request At
                                                        </td>
                                                        <td class="whitespace-nowrap px-4 py-3 sm:px-5 capitalize">
                                                            {{ $item->created_at->format('F j, Y h:i:A') }}
                                                        </td>
                                                    </tr>
                                                    @if ($item->shipment)
                                                        <tr
                                                            class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                            <td
                                                                class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                                Tracking Number
                                                            </td>
                                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5 capitalize">
                                                                {{ $item->shipment->tracking_number }}
                                                            </td>
                                                        </tr>
                                                        <tr
                                                            class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                            <td
                                                                class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                                Tracking Status
                                                            </td>
                                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5 capitalize">
                                                                {{ str_replace('_', ' ', $item->shipment->tracking_status) }}
                                                            </td>
                                                        </tr>
                                                        <tr
                                                            class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                            <td
                                                                class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                                Tracking URL
                                                            </td>
                                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5 capitalize">
                                                                <a href="{{ $item->shipment->tracking_url }}"
                                                                    class="text-xs text-primary"
                                                                    target="_blank">{{ $item->shipment->tracking_url }}</a>
                                                            </td>
                                                        </tr>
                                                        <tr
                                                            class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                            <td
                                                                class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                                Shipping Date
                                                            </td>
                                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5 capitalize">
                                                                {{ $item->shipment->ship_date->format('F j, Y') }}
                                                            </td>
                                                        </tr>
                                                        <tr
                                                            class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                            <td
                                                                class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                                Created At
                                                            </td>
                                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5 capitalize">
                                                                {{ $item->shipment->created_at->format('F j, Y h:i:A') }}
                                                            </td>
                                                        </tr>
                                                    @endif

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
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5" colspan="6">No booklet print request
                            </td>
                        </tr>
                    </tbody>
                @endforelse

            </table>
        </div>

        <div class="px-4 py-4">
            {{ $requests->links() }}
        </div>
    </div>
</div>
