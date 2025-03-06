<x-layouts.app-layout title="{{ __('Admin Dashboard') }}" main="false" is-sidebar-open="true" is-header-blur="true">
    <!-- Main Content Wrapper -->
    <main class="main-content w-full pb-8">
        <div
            class="mt-4 grid grid-cols-12 gap-4 px-[var(--margin-x)] transition-all duration-[.25s] sm:mt-5 sm:gap-5 lg:mt-6 lg:gap-6">

            @livewire('admin.statistics')

            @if (count($data['tasks']) > 0)
                <div class="card col-span-12">
                    <div class="flex flex-col py-3 px-4">
                        <h2 class="font-medium tracking-wide text-base text-slate-700 dark:text-navy-100">
                            Projects Board
                        </h2>
                        <p class="mt-1 hidden sm:block">List of latest 6 ongoing projects</p>
                    </div>
                    <div class="grid grid-cols-1 gap-y-4 pb-3 sm:grid-cols-3">
                        @foreach ($data['tasks'] as $task)
                            <a href="{{ route('admin.coupons.show', $task->coupon->id) }}"
                                class="flex flex-col justify-between border-4 border-transparent border-l-info px-4">
                                <div>
                                    <p class="text-base font-medium text-slate-600 dark:text-navy-100">
                                        {{ $task->coupon?->title }}
                                    </p>
                                    <div class="badge mt-2 bg-info/10 text-info dark:bg-info/15">
                                        {{ $task->language ?? $task->coupon?->language }}
                                    </div>
                                </div>
                                <div>
                                    <div class="mt-8">
                                        <div class="flex justify-between items-center flex-wrap">
                                            <p class="text-lg font-medium text-slate-600 dark:text-navy-100">June
                                                08, 2021</p>
                                            <div class="badge h-5.5 rounded-full bg-success px-2 text-xs+ text-white">
                                                {{ round(now()->diffInDays($task->coupon?->payout_on)) }} days left
                                            </div>
                                        </div>


                                    </div>
                                    <div class="mt-5 flex flex-wrap space-x-3">
                                        <div class="size-10 hover:z-10">
                                            <img class="rounded-full border-1 border-white dark:border-navy-700"
                                                src="{{ asset($task->company?->company_logo) }}" alt="avatar"
                                                class="object-contain" />
                                        </div>
                                        <p class="font-medium text-slate-600 dark:text-navy-100">
                                            {{ $task->company?->company_name }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="mt-4 grid grid-cols-12 gap-4 bg-slate-150 py-5 dark:bg-navy-800 sm:mt-5 sm:gap-5 lg:mt-6 lg:gap-6">
            <div
                class="col-span-12 flex flex-col px-[var(--margin-x)] transition-all duration-[.25s] lg:col-span-3 lg:pr-0">
                <h2
                    class="text-base font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-xl">
                    Top Sponsors
                </h2>

                <p class="mt-3 grow">
                    The top sponsors are calculated based on the payment of a tickets and
                    undergoes activate tickets.
                </p>

                {{-- <div class="mt-4">
                    <p>Sales Growth</p>
                    <div class="mt-1.5 flex items-center space-x-2">
                        <div class="flex size-7 items-center justify-center rounded-full bg-success/15 text-success">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 11l5-5m0 0l5 5m-5-5v12" />
                            </svg>
                        </div>
                        <p class="text-base font-medium text-slate-700 dark:text-navy-100">
                            $2,225.22
                        </p>
                    </div>
                </div> --}}
            </div>
            <div
                class="is-scrollbar-hidden col-span-12 flex space-x-4 overflow-x-auto px-[var(--margin-x)] transition-all duration-[.25s] lg:col-span-9 lg:pl-0">
                @foreach ($data['topSponsors'] as $item)
                    <div class="card w-72 shrink-0 space-y-9 rounded-xl p-4 sm:px-5">
                        <div class="flex items-center justify-between space-x-2">
                            <div class="flex items-center space-x-3">
                                <div class="avatar">
                                    <img class="mask is-squircle" src="{{ asset($item->sponsor?->company_logo) }}"
                                        alt="image" />
                                </div>
                                <div>
                                    <p class="font-medium text-slate-700 line-clamp-1 dark:text-navy-100">
                                        {{ $item->sponsor?->company_name }}
                                    </p>
                                    <p class="text-xs text-slate-400 dark:text-navy-300">
                                        {{ $item->email }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between space-x-2">
                            <div>
                                <p class="text-xs+">Tickets</p>
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                    {{ $item->coupons_count ?? 0 }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs+">Tasks</p>
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                    {{ $item->sponsor_tasks_count ?? 0 }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs+">Payment</p>
                                <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                    ${{ $item->transactions_sum_amount ?? 0 }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

        @livewire('admin.tasks')

    </main>
</x-layouts.app-layout>
