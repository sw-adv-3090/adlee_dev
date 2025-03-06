<div
    class="mt-4 grid grid-cols-12 gap-4 px-[var(--margin-x)] transition-all duration-[.25s] sm:mt-5 sm:gap-5 lg:mt-6 lg:gap-6">
    <div class="col-span-12">
        <div class="flex items-center justify-between">
            <h2 class="text-base font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
                Latest Tasks
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
                <table class="is-hoverable w-full text-left">
                    <thead>
                        <tr>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Coupon Number
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Date
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Sponsor
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Advertiser
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Amount
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Paid Amount
                            </th>

                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Status
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tasks as $task)
                            @php
                                $paidAmount = $task->transactions_sum_amount ?? 0;

                                $status = 'Activated';

                                if ($task->signed_at) {
                                    $status = 'Signed';
                                }

                                if ($task->printed_at) {
                                    $status = 'Printed';
                                }

                                if ($paidAmount != 0) {
                                    $status = 'Partial Paid Out';
                                }

                                if ($task->coupon->payout_at) {
                                    $status = 'Paid Out';
                                }

                            @endphp
                            <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    <p class="font-medium text-primary dark:text-accent-light">
                                        {{ $task->coupon->number }}
                                    </p>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    <p class="font-medium">{{ $task->created_at->format('F j, Y') }}</p>
                                    <p class="mt-0.5 text-xs">{{ $task->created_at->format('h:i A') }}</p>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    <div class="flex items-center space-x-4">
                                        <div class="avatar size-9">
                                            <img class="mask is-squircle"
                                                src="{{ asset($task->sponsor?->company_logo) }}" alt="avatar" />
                                        </div>

                                        <span
                                            class="font-medium text-slate-700 dark:text-navy-100">{{ $task->sponsor?->company_name }}
                                        </span>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    <div class="flex items-center space-x-4">
                                        <div class="avatar size-9">
                                            <img class="mask is-squircle"
                                                src="{{ asset($task->company?->company_logo) }}" alt="avatar" />
                                        </div>

                                        <span
                                            class="font-medium text-slate-700 dark:text-navy-100">{{ $task->company?->company_name }}
                                        </span>
                                    </div>
                                </td>

                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    <p class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                                        ${{ $task->coupon->amount }}
                                    </p>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    <p class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                                        ${{ $paidAmount }}
                                    </p>
                                </td>

                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    <div class="badge rounded-full border border-info text-info">
                                        {{ $status }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    <a href="{{ route('admin.coupons.show', $task->coupon->id) }}"
                                        class="text-primary cursor-pointer disabled:text-gray-300 disabled:cursor-not-allowed">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                            <path
                                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5" colspan="7">
                                    <p class="font-medium text-primary dark:text-accent-light">
                                        No task yet
                                    </p>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
            <div class="px-4 py-4">
                {{ $tasks->links(data: ['scrollTo' => false]) }}
            </div>
        </div>
    </div>
</div>
