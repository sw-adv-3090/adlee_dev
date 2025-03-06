<div class="is-scrollbar-hidden min-w-full overflow-x-auto">
    @php
        $isCancelled = isset($type) && $type === 'cancel';
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
                    Avatar
                </th>
                <th <th
                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                    Name
                </th>
                <th
                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                    Email
                </th>
                <th
                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                    {{ $isCancelled ? 'Cancel At' : 'Joined At' }}
                </th>
            </tr>
        </thead>
        @forelse ($users as $user)
            <tbody x-data="{ expanded: false }">
                <tr class="border-y border-transparent">
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                        {{ $loop->iteration }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-3 font-medium text-slate-700 dark:text-navy-100 sm:px-5">
                        <div class="avatar flex">
                            <img class="rounded-full" src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" />
                        </div>
                    </td>
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                        {{ $user->name }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                        {{ $user->email }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                        @if (!$isCancelled)
                            {{ $user->created_at->format('m-d-Y h:i:A') }}
                        @else
                            {{ $user->subscription()?->ends_at?->format('m-d-Y h:i:A') ?? '-' }}
                        @endif

                    </td>
                </tr>
            </tbody>
        @empty
            <tbody>
                <tr class="border-y border-transparent">
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5" colspan="5">No result</td>
                </tr>
            </tbody>
        @endforelse

    </table>
</div>
