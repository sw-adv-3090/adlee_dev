<div class="is-scrollbar-hidden min-w-full overflow-x-auto" x-data="pages.tables.initExample1">
    <table class="is-hoverable w-full text-left">
        <thead>
            <tr>
                <th
                    class="whitespace-nowrap rounded-tl-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                    #
                </th>
                <th
                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                    Type
                </th>
                <th
                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                    Name
                </th>
                <th
                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                    Price
                </th>
                <th
                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                    ACH Fee
                </th>
                <th
                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                    Credit Card Fee
                </th>
                <th
                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                    Service Fee
                </th>
                <th
                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                    Template Limit
                </th>
                <th
                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                    Free Booklets
                </th>
                <th
                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                    Booklet Fee
                </th>
                <th
                    class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                    Status
                </th>
                <th
                    class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($plans as $plan)
                <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{ $loop->iteration }}</td>
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                        <div class="badge {{ $plan->badge }} rounded-full uppercase">
                            {{ $plan->type }}
                        </div>
                    </td>
                    <td class="whitespace-nowrap px-3 py-3 font-medium text-slate-700 dark:text-navy-100 lg:px-5">
                        {{ $plan->name }}
                    </td>
                    <td class="whitespace-nowrap px-3 py-3 font-medium text-slate-700 dark:text-navy-100 lg:px-5">
                        ${{ $plan->price }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{ $plan->ach_transaction_fee }}%</td>
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{ $plan->credit_card_transaction_fee }}%</td>
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{ $plan->transaction_service_fee }}%
                    </td>
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{ $plan->template_limit }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">{{ $plan->free_booklets }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">${{ $plan->booklet_fee }} /
                        {{ $plan->booklet_pages }}
                    </td>
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                        <label class="inline-flex items-center">
                            <input
                                class="form-switch h-5 w-10 rounded-full bg-slate-300 before:rounded-full before:bg-slate-50 checked:bg-primary checked:before:bg-white dark:bg-navy-900 dark:before:bg-navy-300 dark:checked:bg-accent dark:checked:before:bg-white"
                                type="checkbox" @checked($plan->status)
                                wire:click="updateStatus({{ $plan->id }})" />
                        </label>
                    </td>
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                        <div class="flex space-x-2">
                            <div class="relative cursor-pointer">
                                <a href="{{ route('admin.plans.edit', $plan) }}"
                                    class="btn size-7 rounded-full bg-primary/10 p-0 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                        fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path
                                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                        <path fill-rule="evenodd"
                                            d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                    </svg>
                                </a>
                            </div>
                            <div class="relative cursor-pointer">
                                <form method="POST" action="{{ route('admin.plans.destroy', $plan) }}" method="POST"
                                    onsubmit="return confirm('Are you sure to delete plan?')">
                                    @csrf
                                    @method('delete')
                                    <button
                                        class="btn size-7 rounded-full bg-error/10 p-0 text-error hover:bg-error/20 focus:bg-error/20 active:bg-error/25">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </form>

                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                    <td class="whitespace-nowrap px-4 py-3 sm:px-5" colspan="11">No plan yet</td>
                </tr>
            @endforelse

        </tbody>
    </table>
</div>
