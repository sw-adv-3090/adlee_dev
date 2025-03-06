<div class="mt-10">
    <div class="flex items-center justify-between">
        <h2 class="text-base font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
            {{ $type === 'ad-space-owners' ? 'Ad Space Owners' : 'Sponsors' }}
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

                        @if ($type === 'sponsors')
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Sponsor
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Booklets
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Coupons
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                ACH Support
                            </th>
                        @else
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Ad Space Owner
                            </th>
                            <th
                                class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                Coupons Redeemed
                            </th>
                        @endif

                        {{-- <th
                            class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                            More
                        </th> --}}
                    </tr>
                </thead>
                @forelse ($users as $user)
                    <tbody x-data="{ expanded: false }">
                        <tr class="border-y border-transparent">
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                {{ $loop->iteration + $users->firstItem() - 1 }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                <div class="flex items-center gap-2">
                                    <div class="avatar flex">
                                        <img class="rounded-full" src="{{ asset($user->avatar) }}" alt="ٰImage" />
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm">{{ $user->name }}</span>
                                        <span>{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            @if ($type === 'sponsors')
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    @if ($user->sponsor)
                                        <div class="flex items-center gap-2">
                                            <div class="avatar flex">
                                                <img class="rounded-full"
                                                    src="{{ asset($user->sponsor->company_logo) }}" alt="ٰImage" />
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-sm">{{ $user->sponsor->company_name }}</span>
                                                <span>{{ $user->sponsor->company_phone }}</span>
                                            </div>
                                        </div>
                                    @else
                                        -
                                    @endif

                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ $user->booklets_count }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ $user->coupons_count }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    @if ($user->sponsor)
                                        <button @class([
                                            'btn font-medium',
                                            'text-white bg-primary hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90' => !$user->sponsor->ach_support,
                                            'text-slate-800 bg-slate-150 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90' =>
                                                $user->sponsor->ach_support,
                                        ]) type="button"
                                            wire:click="toggleACHSupport({{ $user->sponsor->id }})"
                                            wire:confirm="Are you sure you want to change ACH support?">
                                            {{ $user->sponsor->ach_support ? 'Disable' : 'Enable' }}
                                        </button>
                                    @else
                                        -
                                    @endif

                                </td>
                            @else
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    @if ($user->adSpaceOwner)
                                        <div class="flex items-center gap-2">
                                            <div class="avatar flex">
                                                <img class="rounded-full"
                                                    src="{{ asset($user->adSpaceOwner->company_logo) }}"
                                                    alt="ٰImage" />
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-sm">{{ $user->adSpaceOwner->company_name }}</span>
                                                <span>{{ $user->adSpaceOwner->company_phone }}</span>
                                            </div>
                                        </div>
                                    @else
                                        -
                                    @endif


                                </td>
                                <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                    {{ $user->tickets_count }}
                                </td>
                            @endif

                            {{-- <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                <button @click="expanded = !expanded"
                                    class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                    <i :class="expanded && '-rotate-180'"
                                        class="fas fa-chevron-down text-sm transition-transform"></i>
                                </button>
                            </td> --}}
                        </tr>
                    </tbody>
                @empty
                    <tbody>
                        <tr class="border-y border-transparent">
                            <td class="whitespace-nowrap px-4 py-3 sm:px-5"
                                colspan="{{ $type === 'sponsors' ? '6' : '4' }}">No record</td>
                        </tr>
                    </tbody>
                @endforelse

            </table>
        </div>

        <div class="px-4 py-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
