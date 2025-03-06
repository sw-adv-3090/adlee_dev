<div class="mt-10">
    <div class="flex items-center justify-between">
        <h2 class="text-base font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
            Bank Accounts
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
                            Bank Name
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            Account Number
                        </th>
                        <th
                            class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            Verified
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
                @forelse ($accounts as $item)
                    <tbody x-data="{ expanded: false }">
                        <tr class="border-y border-transparent">
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                {{ $loop->iteration + $accounts->firstItem() - 1 }}
                            </td>

                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                {{ $item->bank_name }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                Ends with {{ $item->last4 }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                {{ !is_null($item->verified_at) ? 'Yes' : 'No' }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                <div class="flex space-x-2">
                                    <div class="badge rounded-full border border-info text-info capitalize">
                                        {{ $item->status }}
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                <div class="flex items-center gap-3">
                                    @if (is_null($item->verified_at))
                                        <a href="{{ route('sponsors.banks.verification.index', $item) }}"
                                            title="Verification"
                                            class="btn bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90">
                                            Verify
                                        </a>
                                    @else
                                        <button title="Verification"
                                            class="btn bg-info font-medium text-white hover:bg-info-focus focus:bg-info-focus active:bg-info-focus/90 disabled:opacity-50 disabled:cursor-not-allowed"
                                            disabled>
                                            Verify
                                        </button>
                                    @endif
                                    <form action="{{ route('sponsors.banks.delete', $item->uuid) }}" method="post"
                                        onsubmit="return confirm('Do you want to delete bank account? This action is irreversible.')">
                                        @csrf
                                        <button title="Delete Bank Account"
                                            class="btn bg-error font-medium text-white hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90 disabled:opacity-50 disabled:cursor-not-allowed">
                                            Delete
                                        </button>
                                    </form>
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
                                                    @if (!is_null($item->verified_at))
                                                        <tr
                                                            class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                            <td
                                                                class="whitespace-nowrap px-3 py-3 font-semibold capitalize text-slate-800 dark:text-navy-100 lg:px-5">
                                                                Verified At
                                                            </td>
                                                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                                                {{ $item->verified_at->format('m-d-Y h:i:A') }}
                                                            </td>
                                                        </tr>
                                                    @endif

                                                    @if (!is_null($item->failure_reason))
                                                        <tr
                                                            class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                                            <td class="whitespace-nowrap px-3 py-3 font-semibold  text-red-600 lg:px-5 text-center"
                                                                colspan="2">
                                                                {{ $item->failure_reason }}
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
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5" colspan="6">No bank account</td>
                        </tr>
                    </tbody>
                @endforelse

            </table>
        </div>

        <div class="px-4 py-4">
            {{ $accounts->links() }}
        </div>
    </div>
</div>
