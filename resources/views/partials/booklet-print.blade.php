<div class="is-scrollbar-hidden min-w-full overflow-x-auto">
    @php
        $isPaid = isset($type) && $type === 'paid';
    @endphp
    <table class="w-full text-left">
        <thead>
            <tr>
                <th
                    class="whitespace-nowrap rounded-tl-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                    #
                </th>
                <th
                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                    Template
                </th>
                <th <th
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
                @if ($isPaid)
                    <th
                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                        Print Charges
                    </th>
                @endif

                <th
                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                    Printed At
                </th>
            </tr>
        </thead>
        @forelse ($booklets as $item)
            <tbody x-data="{ expanded: false }">
                <tr class="border-y border-transparent">
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                        {{ $loop->iteration }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                        <div class="avatar flex">
                            <img class="rounded-full" src="{{ asset($item->booklet?->template?->preview) }}"
                                alt="{{ $item->booklet?->template?->title }}" />
                        </div>
                    </td>
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                        {{ $item->booklet?->title }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                        {{ $item->booklet?->number }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                        ${{ $item->booklet?->amount }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                        {{ $item->booklet?->coupons_count }}
                    </td>
                    @if ($isPaid)
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            ${{ number_abbreviate($item->amount_paid) }}
                        </td>
                    @endif
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                        {{ $item->created_at->format('m-d-Y h:i:A') }}
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
