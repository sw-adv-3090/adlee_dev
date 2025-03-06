<div class="col-span-12">
    <div class="mb-5 flex items-center flex-wrap gap-5">
        <label class="hidden">
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
    </div>

    {{-- revenue --}}
    @php
        $paymentsAmount = $data['paymentAmount'];
        $transactionsAmount = $data['trnasactionAmount'];
        $totalRevenue = $paymentsAmount + $transactionsAmount;
    @endphp
    <div class="mt-10">
        <div class="my-3 flex h-8 items-center justify-between">
            <h3 class="font-semibold tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-xl">Total
                Revenue
            </h3>
            <h2 class="tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base font-semibold">
                ${{ number_abbreviate($totalRevenue) }}
            </h2>
        </div>
        <div class="card px-4 pb-4 sm:px-5 mt-3">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Subscription/Booklet Print
                </h2>
                <h2 class="tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base font-semibold">
                    ${{ number_abbreviate($paymentsAmount) }}
                </h2>
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
                                <span>Type</span>
                                <label class="block">
                                    <select
                                        class="form-select h-9 mt-1.5 rounded border border-slate-300 bg-white px-4 py-2 hover:border-slate-400 focus:border-slate-200 dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-slate-200"
                                        wire:model.live="payment_type">
                                        <option value="all">All</option>
                                        <option value="Sponsor Basic">Sponsor Basic</option>
                                        <option value="Sponsor Premier">Sponsor Premier</option>
                                        <option value="Sponsor All">Sponsor All</option>
                                        <option value="Ad Space Owner">Ad Space Owner</option>
                                        <option value="Booklet Print">Booklet Print</option>
                                    </select>
                                </label>
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                User
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Amount
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Created On
                            </th>
                        </tr>
                    </thead>
                    @forelse ($data['payments'] as $payment)
                        <tbody>
                            <tr class="border-y border-transparent">
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ page_number($loop->iteration, $data['payments']) }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5 capitalize">
                                    {{ is_null($payment->stripe_price) ? 'booklet print' : $payment->plan?->name }}

                                </td>
                                <td class="whitespace-nowrap flex items-center gap-2 px-4 py-3 sm:px-5">
                                    <div class="avatar flex">
                                        <img class="rounded-full" src="{{ asset($payment->user?->avatar) }}"
                                            alt="ٰImage" />
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm">{{ $payment->user?->name }}</span>
                                        <span>{{ $payment->user?->email }}</span>
                                    </div>
                                </td>
                                <td
                                    class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                    ${{ number_abbreviate($payment->amount) }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ $payment->created_at->format('Y-m-d H:i A') }}
                                </td>
                            </tr>
                        </tbody>
                    @empty
                        <tbody>
                            <tr class="border-y border-transparent">
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5" colspan="5">No payment</td>
                            </tr>
                        </tbody>
                    @endforelse

                </table>
            </div>
            <div class="px-4 py-4">
                {{ $data['payments']->links() }}
            </div>
        </div>
        <div class="card px-4 pb-4 sm:px-5 mt-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Coupon Transactions
                </h2>
                <h2 class="tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base font-semibold">
                    ${{ number_abbreviate($transactionsAmount) }}
                </h2>
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
                                Coupon
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Ad Space Owner
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                <span>Type</span>
                                <label class="block">
                                    <select
                                        class="form-select h-9 mt-1.5 rounded border border-slate-300 bg-white px-4 py-2 hover:border-slate-400 focus:border-slate-200 dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-slate-200"
                                        wire:model.live="transaction_type">
                                        <option value="all">All</option>
                                        <option value="ach">ACH</option>
                                        <option value="credit-card">Credit Card</option>
                                    </select>
                                </label>
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Coupon Amount
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Transaction Fee
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Service Fee
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Amount Paid
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                <span>Commission Paid By</span>
                                <label class="block">
                                    <select
                                        class="form-select h-9 mt-1.5 rounded border border-slate-300 bg-white px-4 py-2 hover:border-slate-400 focus:border-slate-200 dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-slate-200"
                                        wire:model.live="paid_by">
                                        <option value="all">All</option>
                                        <option value="Sponsor">Sponsor</option>
                                        <option value="Ad Space Owner">Ad Space Owner</option>
                                    </select>
                                </label>
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Created On
                            </th>
                        </tr>
                    </thead>
                    @forelse ($data['transactions'] as $item)
                        <tbody>
                            <tr class="border-y border-transparent">
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ page_number($loop->iteration, $data['transactions']) }}
                                </td>
                                <td class="whitespace-nowrap flex items-center gap-2 px-4 py-3 sm:px-5">
                                    <div class="avatar flex">
                                        <img class="rounded-full" src="{{ asset($item->sponsor?->company_logo) }}"
                                            alt="ٰImage" />
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm">{{ $item->sponsor?->company_name }}</span>
                                        <span>{{ $item->sender?->email }}</span>
                                    </div>
                                </td>

                                <td
                                    class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                    {{ $item->coupon?->number }}
                                </td>
                                <td class="whitespace-nowrap flex items-center gap-2 px-4 py-3 sm:px-5">
                                    <div class="avatar flex">
                                        <img class="rounded-full" src="{{ asset($item->company?->company_logo) }}"
                                            alt="ٰImage" />
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm">{{ $item->company?->company_name }}</span>
                                        <span>{{ $item->receiver?->email }}</span>
                                    </div>
                                </td>
                                <td
                                    class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5 capitalize">
                                    {{ str_replace('-', ' ', $item->type) }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                    ${{ number_abbreviate($item->amount) }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                    ${{ number_abbreviate($item->transaction_fee) }}
                                    ({{ $item->transaction_fee_percentage }}%)
                                </td>
                                <td
                                    class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                    ${{ number_abbreviate($item->service_fee) }}
                                    ({{ $item->service_fee_percentage }}%)
                                </td>
                                <td
                                    class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                    ${{ number_abbreviate($item->paid_amount) }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                    {{ $item->commission_paid ? 'Sponsor' : 'Ad Space Owner' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ $item->created_at->format('Y-m-d H:i A') }}
                                </td>
                            </tr>
                        </tbody>
                    @empty
                        <tbody>
                            <tr class="border-y border-transparent">
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5" colspan="11">No payment</td>
                            </tr>
                        </tbody>
                    @endforelse

                </table>
            </div>

            <div class="px-4 py-4">
                {{ $data['transactions']->links() }}
            </div>
        </div>
    </div>

    {{-- account joined --}}
    <div class="mt-10">
        @php
            $sponsorsJoined = $data['sponsorJoinedCount'];
            $bboJoined = $data['bboJoinedCount'];
            $totalJoined = $sponsorsJoined + $bboJoined;
        @endphp
        <div class="my-3 flex h-8 items-center justify-between">
            <h3 class="font-semibold tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-xl">Accounts
                Joined
            </h3>
            <h2 class="tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base font-semibold">
                {{ $totalJoined }}
            </h2>
        </div>
        <div class="card px-4 pb-4 sm:px-5 mt-3">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Sponsors ({{ $sponsorsJoined }})
                </h2>
                <h2 class="tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base font-semibold">
                    Ad Space Owner ({{ $bboJoined }})
                </h2>
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
                                Avatar
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                <span>Type</span>
                                <label class="block">
                                    <select
                                        class="form-select h-9 mt-1.5 rounded border border-slate-300 bg-white px-4 py-2 hover:border-slate-400 focus:border-slate-200 dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-slate-200"
                                        wire:model.live="user_type">
                                        <option value="all">All</option>
                                        <option value="Sponsor">Sponsor</option>
                                        <option value="Ad Space Owner">Ad Space Owner</option>
                                    </select>
                                </label>
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Name
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Email
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                <span>Plan</span>
                                <label class="block">
                                    <select
                                        class="form-select h-9 mt-1.5 rounded border border-slate-300 bg-white px-4 py-2 hover:border-slate-400 focus:border-slate-200 dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-slate-200"
                                        wire:model.live="plan_type_join">
                                        @foreach ($plans as $plan)
                                            <option value="{{ $plan['key'] }}">{{ $plan['value'] }}</option>
                                        @endforeach
                                    </select>
                                </label>
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Joined At
                            </th>
                        </tr>
                    </thead>
                    @forelse ($data['accountsJoined'] as $user)
                        <tbody x-data="{ expanded: false }">
                            <tr class="border-y border-transparent">
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ page_number($loop->iteration, $data['accountsJoined']) }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                    <div class="avatar flex">
                                        <img class="rounded-full" src="{{ asset($user->avatar) }}"
                                            alt="{{ $user->name }}" />
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ role_name($user->role_id) }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ $user->name }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ $user->email }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ $user->plan()?->name ?? '-' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ $user->created_at->format('m-d-Y h:i:A') }}
                                </td>
                            </tr>
                        </tbody>
                    @empty
                        <tbody>
                            <tr class="border-y border-transparent">
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5" colspan="7">No result</td>
                            </tr>
                        </tbody>
                    @endforelse

                </table>
            </div>

            <div class="px-4 py-4">
                {{ $data['accountsJoined']->links() }}
            </div>
        </div>
    </div>

    {{-- account cancellation --}}
    <div class="mt-10">
        @php
            $sponsorsCancelled = $data['sponsorCancelledCount'];
            $bboCancelled = $data['bboCancelledCount'];
            $totalCancelled = $sponsorsCancelled + $bboCancelled;
        @endphp
        <div class="my-3 flex h-8 items-center justify-between">
            <h3 class="font-semibold tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-xl">Accounts
                Cancelled
            </h3>
            <h2 class="tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base font-semibold">
                {{ $totalCancelled }}
            </h2>
        </div>
        <div class="card px-4 pb-4 sm:px-5 mt-3">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Sponsors ({{ $sponsorsCancelled }})
                </h2>
                <h2 class="tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base font-semibold">
                    Ad Space Owner ({{ $bboCancelled }})
                </h2>
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
                                Avatar
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                <span>Type</span>
                                <label class="block">
                                    <select
                                        class="form-select h-9 mt-1.5 rounded border border-slate-300 bg-white px-4 py-2 hover:border-slate-400 focus:border-slate-200 dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-slate-200"
                                        wire:model.live="cancel_type">
                                        <option value="all">All</option>
                                        <option value="Sponsor">Sponsor</option>
                                        <option value="Ad Space Owner">Ad Space Owner</option>
                                    </select>
                                </label>
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Name
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Email
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                <span>Plan</span>
                                <label class="block">
                                    <select
                                        class="form-select h-9 mt-1.5 rounded border border-slate-300 bg-white px-4 py-2 hover:border-slate-400 focus:border-slate-200 dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-slate-200"
                                        wire:model.live="plan_type_cancel">
                                        @foreach ($plans as $plan)
                                            <option value="{{ $plan['key'] }}">{{ $plan['value'] }}</option>
                                        @endforeach
                                    </select>
                                </label>
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Cancel At
                            </th>
                        </tr>
                    </thead>
                    @forelse ($data['accountsCanceled'] as $user)
                        <tbody x-data="{ expanded: false }">
                            <tr class="border-y border-transparent">
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ page_number($loop->iteration, $data['accountsCanceled']) }}
                                </td>
                                <td
                                    class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                                    <div class="avatar flex">
                                        <img class="rounded-full" src="{{ asset($user->avatar) }}"
                                            alt="{{ $user->name }}" />
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ role_name($user->role_id) }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ $user->name }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ $user->email }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ $user->plan()?->name ?? '-' }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ $user->subscription()?->ends_at?->format('m-d-Y h:i:A') }}
                                </td>
                            </tr>
                        </tbody>
                    @empty
                        <tbody>
                            <tr class="border-y border-transparent">
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5" colspan="7">No result</td>
                            </tr>
                        </tbody>
                    @endforelse

                </table>
            </div>

            <div class="px-4 py-4">
                {{ $data['accountsCanceled']->links() }}
            </div>
        </div>
    </div>

    {{-- free booklet  --}}
    @php
        $freeBooklet = $data['freeBooklets']->count();
        $paidBooklet = $data['paidBooklets']->count();
        $totalBooklet = $freeBooklet + $paidBooklet;
    @endphp
    <div class="mt-10">
        <div class="my-3 flex h-8 items-center justify-between">
            <h3 class="font-semibold tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-xl">Booklet
                Prints
            </h3>
            <h2 class="tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base font-semibold">
                {{ $totalBooklet }}
            </h2>
        </div>
        <div class="card px-4 pb-4 sm:px-5 mt-3">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Free Booklets Prints
                </h2>
                <h2 class="tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base font-semibold">
                    {{ $freeBooklet }}
                </h2>
            </div>
            @include('partials.booklet-print', ['booklets' => $data['freeBooklets']])
        </div>
        <div class="card px-4 pb-4 sm:px-5 mt-5">
            <div class="my-3 flex h-8 items-center justify-between">
                <h2 class="font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base">
                    Paid Booklets Prints
                </h2>
                <h2 class="tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-base font-semibold">
                    {{ $paidBooklet }}
                </h2>
            </div>
            @include('partials.booklet-print', ['booklets' => $data['paidBooklets'], 'type' => 'paid'])
        </div>
    </div>
</div>
