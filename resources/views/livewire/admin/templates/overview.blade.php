<div class="card">
    <div class="mt-3 flex items-center justify-between px-4 sm:px-5">
        <h2 class="text-base font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
            {{ __('Templates Overview') }}
        </h2>
        <div class="flex">
            <div class="flex items-center" x-data="{ isInputActive: false }">
                <label class="block">
                    <input x-effect="isInputActive === true && $nextTick(() => { $el.focus()});"
                        :class="isInputActive ? 'w-32 lg:w-48' : 'w-0'"
                        class="form-input bg-transparent px-1 text-right transition-all duration-100 placeholder:text-slate-500 dark:placeholder:text-navy-200 border-0 ring-0 outline-none focus:ring-0"
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
        </div>
    </div>

    <div class="mt-5 grid grid-cols-1 gap-4 px-4 sm:grid-cols-3 sm:px-5">
        <div class="relative flex flex-col overflow-hidden rounded-lg bg-gradient-to-br from-info to-info-focus p-3.5">
            <p class="text-xs uppercase text-sky-100">{{ __('Total Templates') }}</p>
            <div class="flex items-end justify-between space-x-2">
                <p class="mt-4 text-2xl font-medium text-white">{{ $totalTemplates }}</p>

            </div>
            <div class="mask is-reuleaux-triangle absolute top-0 right-0 -m-3 size-16 bg-white/20"></div>
        </div>
        <div class="relative flex flex-col overflow-hidden rounded-lg p-3.5 {{ $sponsor_bg }}">
            <p class="text-xs uppercase text-amber-50">Sponsors</p>
            <div class="flex items-end justify-between space-x-2">
                <p class="mt-4 text-2xl font-medium text-white">{{ $sponsorTemplates }}</p>
                <a href="{{ route('admin.templates.sponsors.index') }}"
                    class="border-b border-dotted border-current pb-0.5 text-xs font-medium text-amber-50 outline-none transition-colors duration-300 line-clamp-1 hover:text-white focus:text-white">Get
                    Report
                </a>
            </div>
            <div class="mask is-diamond absolute top-0 right-0 -m-3 size-16 bg-white/20"></div>
        </div>
        <div class="relative flex flex-col overflow-hidden rounded-lg p-3.5 {{ $coupon_bg }}">
            <p class="text-xs uppercase text-pink-100">Coupons</p>
            <div class="flex items-end justify-between space-x-2">
                <p class="mt-4 text-2xl font-medium text-white">{{ $couponTemplates }}</p>
                <a href="{{ route('admin.templates.coupons.index') }}"
                    class="border-b border-dotted border-current pb-0.5 text-xs font-medium text-pink-100 outline-none transition-colors duration-300 line-clamp-1 hover:text-white focus:text-white">Get
                    Report
                </a>
            </div>
            <div class="mask is-hexagon-2 absolute top-0 right-0 -m-3 size-16 bg-white/20"></div>
        </div>
    </div>

    <div class="scrollbar-sm mt-5 min-w-full overflow-x-auto">
        <table class="is-hoverable w-full text-left">
            <tbody>
                @forelse ($templates as $template)
                    <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            <div class="flex items-center space-x-4">
                                <div class="size-12">
                                    <img class="h-full w-full rounded-lg" src="{{ asset($template->preview) }}"
                                        alt="image" />
                                </div>
                                <div>
                                    <p class="font-medium text-slate-600 dark:text-navy-100">
                                        {{ $template->title }}
                                    </p>
                                    <p class="mt-1 text-xs text-slate-400 dark:text-navy-300 capitalize">
                                        {{ $template->type }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">0 Clients</td>
                        {{-- <td class="whitespace-nowrap px-4 py-3 sm:px-5">2 Adult</td> --}}

                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            <p class="font-medium text-slate-700 dark:text-navy-100">
                                $0
                            </p>
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                            <span>{{ $template->created_at->format('F j, Y') }}</span>
                        </td>
                    </tr>
                @empty
                    <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                        <td class="whitespace-nowrap px-4 py-3 sm:px-5 text-center " colspan="4">
                            <p class="text-md py-3">No templates created yet</p>
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    <!-- Paginations -->
    {{-- <div
        class="flex flex-col justify-between space-y-4 px-4 py-4 sm:flex-row sm:items-center sm:space-y-0 sm:px-5">
        <div class="text-xs+">1 - 10 of 10 entries</div>

        <ol class="pagination">
            <li class="rounded-l-full bg-slate-150 dark:bg-navy-500">
                <a href="#"
                    class="flex size-8 items-center justify-center rounded-full text-slate-500 transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:text-navy-200 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
