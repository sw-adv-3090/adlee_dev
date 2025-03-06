<x-layouts.app-layout title="{{ __('Admin Dashboard') }}" main="false" is-sidebar-open="true" is-header-blur="true">
    <!-- Main Content Wrapper -->
    <main class="main-content w-full pb-8">
        <div
            class="mt-4 grid grid-cols-12 gap-4 px-[var(--margin-x)] transition-all duration-[.25s] sm:mt-5 sm:gap-5 lg:mt-6 lg:gap-6">
            <div class="col-span-12 lg:col-span-8">
                <div class="flex items-center justify-between space-x-2">
                    <h2 class="text-base font-medium tracking-wide text-slate-800 line-clamp-1 dark:text-navy-100">
                        Sales Overview
                    </h2>
                    <div x-data="{ activeTab: 'tabRecent' }"
                        class="is-scrollbar-hidden overflow-x-auto rounded-lg bg-slate-200 text-slate-600 dark:bg-navy-800 dark:text-navy-200">
                        <div class="tabs-list flex p-1">
                            <button @click="activeTab = 'tabRecent'"
                                :class="activeTab === 'tabRecent' ? 'bg-white shadow dark:bg-navy-500 dark:text-navy-100' :
                                    'hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100'"
                                class="btn shrink-0 px-3 py-1 text-xs+ font-medium">
                                Last month
                            </button>
                            <button @click="activeTab = 'tabAll'"
                                :class="activeTab === 'tabAll' ? 'bg-white shadow dark:bg-navy-500 dark:text-navy-100' :
                                    'hover:text-slate-800 focus:text-slate-800 dark:hover:text-navy-100 dark:focus:text-navy-100'"
                                class="btn shrink-0 px-3 py-1 text-xs+ font-medium">
                                Last year
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:space-x-7">
                    <div class="mt-4 flex shrink-0 flex-col items-center sm:items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-8 text-info" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                        </svg>
                        <div class="mt-4">
                            <div class="flex items-center space-x-1">
                                <p class="text-2xl font-semibold text-slate-700 dark:text-navy-100">
                                    $6,556.55
                                </p>
                                <button
                                    class="btn size-6 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                </button>
                            </div>
                            <p class="text-xs text-slate-400 dark:text-navy-300">
                                this month
                            </p>
                        </div>
                        <div class="mt-3 flex items-center space-x-2">
                            <div class="ax-transparent-gridline w-28">
                                <div x-init="$nextTick(() => {
                                    $el._x_chart = new ApexCharts($el, pages.charts.analyticsSalesThisMonth);
                                    $el._x_chart.render()
                                });"></div>
                            </div>
                            <div class="flex items-center space-x-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-success" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                </svg>
                                <p class="text-sm+ text-slate-800 dark:text-navy-100">
                                    3.2%
                                </p>
                            </div>
                        </div>
                        <button
                            class="btn mt-8 space-x-2 rounded-full border border-slate-300 px-3 text-xs+ font-medium text-slate-700 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-100 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5 text-slate-400 dark:text-navy-300"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z" />
                            </svg>
                            <span> Download Report</span>
                        </button>
                    </div>

                    <div class="ax-transparent-gridline grid w-full grid-cols-1">
                        <div x-init="$nextTick(() => {
                            $el._x_chart = new ApexCharts($el, pages.charts.analyticsSalesOverview);
                            $el._x_chart.render()
                        });"></div>
                    </div>
                </div>
            </div>
            <div class="col-span-12 lg:col-span-4">
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 sm:gap-5 lg:grid-cols-2">
                    <div class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
                        <div class="flex justify-between space-x-1">
                            <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                $67.6k
                            </p>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-primary dark:text-accent"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="mt-1 text-xs+">Income</p>
                    </div>
                    <div class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
                        <div class="flex justify-between">
                            <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                12.6K
                            </p>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-success" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                        </div>
                        <p class="mt-1 text-xs+">Completed</p>
                    </div>
                    <div class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
                        <div class="flex justify-between">
                            <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                143
                            </p>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-warning" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <p class="mt-1 text-xs+">Pending</p>
                    </div>
                    <div class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
                        <div class="flex justify-between">
                            <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                651
                            </p>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-info" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                            </svg>
                        </div>
                        <p class="mt-1 text-xs+">Dispatch</p>
                    </div>
                    <div class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
                        <div class="flex justify-between space-x-1">
                            <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                46k
                            </p>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-secondary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <p class="mt-1 text-xs+">Products</p>
                    </div>
                    <div class="rounded-lg bg-slate-150 p-4 dark:bg-navy-700">
                        <div class="flex justify-between">
                            <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                8.8k
                            </p>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-error" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <p class="mt-1 text-xs+">Customers</p>
                    </div>
                </div>
            </div>

            <div class="card col-span-12 lg:col-span-8">
                <div class="flex items-center justify-between py-3 px-4">
                    <h2 class="font-medium tracking-wide text-slate-700 dark:text-navy-100">
                        Projects Status
                    </h2>
                    <div x-data="usePopper({ placement: 'bottom-end', offset: 4 })"
                        @click.outside="if(isShowPopper) isShowPopper = false" class="inline-flex">
                        <button x-ref="popperRef" @click="isShowPopper = !isShowPopper"
                            class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                            </svg>
                        </button>

                        <div x-ref="popperRoot" class="popper-root" :class="isShowPopper && 'show'">
                            <div
                                class="popper-box rounded-md border border-slate-150 bg-white py-1.5 font-inter dark:border-navy-500 dark:bg-navy-700">
                                <ul>
                                    <li>
                                        <a href="#"
                                            class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">Action</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">Another
                                            Action</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">Something
                                            else</a>
                                    </li>
                                </ul>
                                <div class="my-1 h-px bg-slate-150 dark:bg-navy-500"></div>
                                <ul>
                                    <li>
                                        <a href="#"
                                            class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">Separated
                                            Link</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 gap-y-4 pb-3 sm:grid-cols-3">
                    <div class="flex flex-col justify-between border-4 border-transparent border-l-info px-4">
                        <div>
                            <p class="text-base font-medium text-slate-600 dark:text-navy-100">
                                Web Design
                            </p>
                            <p class="text-xs text-slate-400 dark:text-navy-300">
                                Design Learn Management System
                            </p>
                            <div class="badge mt-2 bg-info/10 text-info dark:bg-info/15">
                                UI/UX Design
                            </div>
                        </div>
                        <div>
                            <div class="mt-8">
                                <p class="font-inter">
                                    <span
                                        class="text-2xl font-medium text-slate-600 dark:text-navy-100">%55.</span><span
                                        class="text-xs">23</span>
                                </p>
                                <p class="mt-1 text-xs">June 08, 2021</p>
                            </div>
                            <div class="mt-8 flex items-center justify-between space-x-2">
                                <div class="flex -space-x-3">
                                    <div class="avatar size-8 hover:z-10">
                                        <img class="rounded-full ring ring-white dark:ring-navy-700"
                                            src="{{ asset('images/100x100.png') }}" alt="avatar" />
                                    </div>
                                    <div class="avatar size-8 hover:z-10">
                                        <div
                                            class="is-initial rounded-full bg-info text-xs+ uppercase text-white ring ring-white dark:ring-navy-700">
                                            jd
                                        </div>
                                    </div>
                                    <div class="avatar size-8 hover:z-10">
                                        <img class="rounded-full ring ring-white dark:ring-navy-700"
                                            src="{{ asset('images/100x100.png') }}" alt="avatar" />
                                    </div>
                                </div>
                                <button
                                    class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col justify-between border-4 border-transparent border-l-secondary px-4">
                        <div>
                            <p class="text-base font-medium text-slate-600 dark:text-navy-100">
                                Mobile App
                            </p>
                            <p class="text-xs text-slate-400 dark:text-navy-300">
                                Ecommerce Application
                            </p>
                            <div
                                class="badge mt-2 bg-secondary/10 text-secondary dark:bg-secondary-light/15 dark:text-secondary-light">
                                Ecommerce
                            </div>
                        </div>
                        <div>
                            <div class="mt-8">
                                <p class="font-inter">
                                    <span
                                        class="text-2xl font-medium text-slate-600 dark:text-navy-100">%14.</span><span
                                        class="text-xs">84</span>
                                </p>
                                <p class="mt-1 text-xs">May 01, 2021</p>
                            </div>
                            <div class="mt-8 flex items-center justify-between space-x-2">
                                <div class="flex -space-x-3">
                                    <div class="avatar size-8 hover:z-10">
                                        <img class="rounded-full ring ring-white dark:ring-navy-700"
                                            src="{{ asset('images/100x100.png') }}" alt="avatar" />
                                    </div>
                                    <div class="avatar size-8 hover:z-10">
                                        <div
                                            class="is-initial rounded-full bg-success text-xs+ uppercase text-white ring ring-white dark:ring-navy-700">
                                            uh
                                        </div>
                                    </div>
                                    <div class="avatar size-8 hover:z-10">
                                        <img class="rounded-full ring ring-white dark:ring-navy-700"
                                            src="{{ asset('images/100x100.png') }}" alt="avatar" />
                                    </div>
                                </div>
                                <button
                                    class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col justify-between border-4 border-transparent border-l-warning px-4">
                        <div>
                            <p class="text-base font-medium text-slate-600 dark:text-navy-100">
                                Design System
                            </p>
                            <p class="text-xs text-slate-400 dark:text-navy-300">
                                Create LMS design system on figma
                            </p>
                            <div class="mt-2 flex space-x-1.5">
                                <div class="badge bg-warning/10 text-warning dark:bg-warning/15">
                                    LMS
                                </div>
                                <div class="badge bg-warning/10 text-warning dark:bg-warning/15">
                                    Figma
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="mt-8">
                                <p class="font-inter">
                                    <span
                                        class="text-2xl font-medium text-slate-600 dark:text-navy-100">%87.</span><span
                                        class="text-xs">40</span>
                                </p>
                                <p class="mt-1 text-xs">September 16, 2021</p>
                            </div>
                            <div class="mt-8 flex items-center justify-between space-x-2">
                                <div class="flex -space-x-3">
                                    <div class="avatar size-8 hover:z-10">
                                        <img class="rounded-full ring ring-white dark:ring-navy-700"
                                            src="{{ asset('images/100x100.png') }}" alt="avatar" />
                                    </div>
                                    <div class="avatar size-8 hover:z-10">
                                        <div
                                            class="is-initial rounded-full bg-error text-xs+ uppercase text-white ring ring-white dark:ring-navy-700">
                                            pm
                                        </div>
                                    </div>
                                    <div class="avatar size-8 hover:z-10">
                                        <img class="rounded-full ring ring-white dark:ring-navy-700"
                                            src="{{ asset('images/100x100.png') }}" alt="avatar" />
                                    </div>
                                </div>
                                <button
                                    class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-12 lg:col-span-4">
                <div class="flex items-center justify-between">
                    <h2 class="font-medium tracking-wide text-slate-700 dark:text-navy-100">
                        Customer Satisfaction
                    </h2>
                    <div x-data="usePopper({ placement: 'bottom-end', offset: 4 })"
                        @click.outside="if(isShowPopper) isShowPopper = false" class="inline-flex">
                        <button x-ref="popperRef" @click="isShowPopper = !isShowPopper"
                            class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                            </svg>
                        </button>

                        <div x-ref="popperRoot" class="popper-root" :class="isShowPopper && 'show'">
                            <div
                                class="popper-box rounded-md border border-slate-150 bg-white py-1.5 font-inter dark:border-navy-500 dark:bg-navy-700">
                                <ul>
                                    <li>
                                        <a href="#"
                                            class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">Action</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">Another
                                            Action</a>
                                    </li>
                                    <li>
                                        <a href="#"
                                            class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">Something
                                            else</a>
                                    </li>
                                </ul>
                                <div class="my-1 h-px bg-slate-150 dark:bg-navy-500"></div>
                                <ul>
                                    <li>
                                        <a href="#"
                                            class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">Separated
                                            Link</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <p>
                        <span class="text-3xl text-slate-700 dark:text-navy-100">9.7</span>
                        <span class="text-xs text-success">+2.1%</span>
                    </p>
                    <p class="text-xs+">Performance score</p>
                </div>
                <div class="mt-4 flex h-2 space-x-1">
                    <div class="w-5/12 rounded-full bg-primary dark:bg-accent" x-tooltip.primary="'Exellent'"></div>
                    <div class="w-2/12 rounded-full bg-success" x-tooltip.success="'Very Good'"></div>
                    <div class="w-2/12 rounded-full bg-info" x-tooltip.info="'Good'"></div>

                    <div class="w-2/12 rounded-full bg-warning" x-tooltip.warning="'Poor'"></div>
                    <div class="w-1/12 rounded-full bg-error" x-tooltip.error="'Very Poor'"></div>
                </div>

                <div class="is-scrollbar-hidden mt-4 min-w-full overflow-x-auto">
                    <table class="w-full font-inter">
                        <tbody>
                            <tr>
                                <td class="whitespace-nowrap py-2">
                                    <div class="flex items-center space-x-2">
                                        <div class="size-3.5 rounded-full border-2 border-primary dark:border-accent">
                                        </div>
                                        <p class="font-medium tracking-wide text-slate-700 dark:text-navy-100">
                                            Exellent
                                        </p>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap py-2 text-right">
                                    <p class="font-medium text-slate-700 dark:text-navy-100">
                                        1 029
                                    </p>
                                </td>
                                <td class="whitespace-nowrap py-2 text-right">42%</td>
                            </tr>
                            <tr>
                                <td class="whitespace-nowrap py-2">
                                    <div class="flex items-center space-x-2">
                                        <div class="size-3.5 rounded-full border-2 border-success"></div>
                                        <p class="font-medium tracking-wide text-slate-700 dark:text-navy-100">
                                            Very Good
                                        </p>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap py-2 text-right">
                                    <p class="font-medium text-slate-700 dark:text-navy-100">
                                        426
                                    </p>
                                </td>
                                <td class="whitespace-nowrap py-2 text-right">18%</td>
                            </tr>
                            <tr>
                                <td class="whitespace-nowrap py-2">
                                    <div class="flex items-center space-x-2">
                                        <div class="size-3.5 rounded-full border-2 border-info"></div>
                                        <p class="font-medium tracking-wide text-slate-700 dark:text-navy-100">
                                            Good
                                        </p>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap py-2 text-right">
                                    <p class="font-medium text-slate-700 dark:text-navy-100">
                                        326
                                    </p>
                                </td>
                                <td class="whitespace-nowrap py-2 text-right">14%</td>
                            </tr>
                            <tr>
                                <td class="whitespace-nowrap py-2">
                                    <div class="flex items-center space-x-2">
                                        <div class="size-3.5 rounded-full border-2 border-warning"></div>
                                        <p class="font-medium tracking-wide text-slate-700 dark:text-navy-100">
                                            Poor
                                        </p>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap py-2 text-right">
                                    <p class="font-medium text-slate-700 dark:text-navy-100">
                                        395
                                    </p>
                                </td>
                                <td class="whitespace-nowrap py-2 text-right">17%</td>
                            </tr>
                            <tr>
                                <td class="whitespace-nowrap py-2">
                                    <div class="flex items-center space-x-2">
                                        <div class="size-3.5 rounded-full border-2 border-error"></div>
                                        <p class="font-medium tracking-wide text-slate-700 dark:text-navy-100">
                                            Very Poor
                                        </p>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap py-2 text-right">
                                    <p class="font-medium text-slate-700 dark:text-navy-100">
                                        129
                                    </p>
                                </td>
                                <td class="whitespace-nowrap py-2 text-right">9%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4 grid grid-cols-12 gap-4 bg-slate-150 py-5 dark:bg-navy-800 sm:mt-5 sm:gap-5 lg:mt-6 lg:gap-6">
            <div
                class="col-span-12 flex flex-col px-[var(--margin-x)] transition-all duration-[.25s] lg:col-span-3 lg:pr-0">
                <h2
                    class="text-base font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 lg:text-xl">
                    Top Sellers
                </h2>

                <p class="mt-3 grow">
                    The top sellers is calculated based on the sales of a product and
                    undergoes hourly updations.
                </p>

                <div class="mt-4">
                    <p>Sales Growth</p>
                    <div class="mt-1.5 flex items-center space-x-2">
                        <div class="flex size-7 items-center justify-center rounded-full bg-success/15 text-success">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 11l5-5m0 0l5 5m-5-5v12" />
                            </svg>
                        </div>
                        <p class="text-base font-medium text-slate-700 dark:text-navy-100">
                            $2,225.22
                        </p>
                    </div>
                </div>
            </div>
            <div
                class="is-scrollbar-hidden col-span-12 flex space-x-4 overflow-x-auto px-[var(--margin-x)] transition-all duration-[.25s] lg:col-span-9 lg:pl-0">
                <div class="card w-72 shrink-0 space-y-9 rounded-xl p-4 sm:px-5">
                    <div class="flex items-center justify-between space-x-2">
                        <div class="flex items-center space-x-3">
                            <div class="avatar">
                                <img class="mask is-squircle" src="{{ asset('images/100x100.png') }}" alt="image" />
                            </div>
                            <div>
                                <p class="font-medium text-slate-700 line-clamp-1 dark:text-navy-100">
                                    Travis Fuller
                                </p>
                                <p class="text-xs text-slate-400 dark:text-navy-300">
                                    Employee
                                </p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <div class="relative cursor-pointer">
                                <button
                                    class="btn size-7 bg-primary/10 p-0 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-accent-light/10 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </button>
                                <div
                                    class="absolute top-0 right-0 -m-1 flex h-4 min-w-[1rem] items-center justify-center rounded-full bg-primary px-1 text-tiny font-medium leading-none text-white dark:bg-accent">
                                    2
                                </div>
                            </div>
                            <div class="relative cursor-pointer">
                                <button
                                    class="btn size-7 bg-primary/10 p-0 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-accent-light/10 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </button>
                                <div
                                    class="absolute top-0 right-0 -m-1 flex h-4 min-w-[1rem] items-center justify-center rounded-full bg-primary px-1 text-tiny font-medium leading-none text-white dark:bg-accent">
                                    4
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between space-x-2">
                        <div>
                            <p class="text-xs+">Sells</p>
                            <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                2 348
                            </p>
                        </div>
                        <div>
                            <p class="text-xs+">Target</p>
                            <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                3 000
                            </p>
                        </div>
                        <div>
                            <p class="text-xs+">Clients</p>
                            <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                78
                            </p>
                        </div>
                    </div>
                    <div class="grow">
                        <div class="flex w-full space-x-1">
                            <div x-tooltip="'Phone Calls'" class="h-2 w-4/12 rounded-full bg-primary dark:bg-accent">
                            </div>
                            <div x-tooltip="'Chats Messages'" class="h-2 w-3/12 rounded-full bg-success"></div>
                            <div x-tooltip="'Emails'" class="h-2 w-5/12 rounded-full bg-info"></div>
                        </div>
                        <div class="mt-2 flex flex-wrap">
                            <div class="mr-4 mb-1 inline-flex items-center space-x-2 font-inter">
                                <div class="size-2 rounded-full bg-primary dark:bg-accent"></div>
                                <div class="flex space-x-1 text-xs leading-6">
                                    <span class="font-medium text-slate-700 dark:text-navy-100">Calls</span>
                                    <span>33%</span>
                                </div>
                            </div>
                            <div class="mr-4 mb-1 inline-flex items-center space-x-2 font-inter">
                                <div class="size-2 rounded-full bg-success"></div>
                                <div class="flex space-x-1 text-xs">
                                    <span class="font-medium text-slate-700 dark:text-navy-100">Chat Messages</span>
                                    <span>17%</span>
                                </div>
                            </div>
                            <div class="mb-1 inline-flex items-center space-x-2 font-inter">
                                <div class="size-2 rounded-full bg-info"></div>
                                <div class="flex space-x-1 text-xs">
                                    <span class="font-medium text-slate-700 dark:text-navy-100">Emails</span>
                                    <span>50%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div class="flex space-x-2">
                            <img x-tooltip="'Award Level 1'" class="size-6"
                                src="{{ asset('images/awards/award-19.svg') }}" alt="avatar" />
                            <img x-tooltip="'Award Level 2'" class="size-6"
                                src="{{ asset('images/awards/award-2.svg') }}" alt="avatar" />
                            <img x-tooltip="'Award Level 3'" class="size-6"
                                src="{{ asset('images/awards/award-5.svg') }}" alt="avatar" />
                        </div>
                        <button
                            class="btn -mr-1.5 size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="card w-72 shrink-0 space-y-9 rounded-xl p-4 sm:px-5">
                    <div class="flex items-center justify-between space-x-2">
                        <div class="flex items-center space-x-3">
                            <div class="avatar">
                                <img class="mask is-squircle" src="{{ asset('images/100x100.png') }}" alt="image" />
                            </div>
                            <div>
                                <p class="font-medium text-slate-700 line-clamp-1 dark:text-navy-100">
                                    Konnor Guzman
                                </p>
                                <p class="text-xs text-slate-400 dark:text-navy-300">
                                    Employee
                                </p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <div class="relative cursor-pointer">
                                <button
                                    class="btn size-7 bg-primary/10 p-0 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-accent-light/10 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="relative cursor-pointer">
                                <button
                                    class="btn size-7 bg-primary/10 p-0 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-accent-light/10 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </button>
                                <div
                                    class="absolute top-0 right-0 -m-1 flex h-4 min-w-[1rem] items-center justify-center rounded-full bg-primary px-1 text-tiny font-medium leading-none text-white dark:bg-accent">
                                    3
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between space-x-2">
                        <div>
                            <p class="text-xs+">Sells</p>
                            <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                1 451
                            </p>
                        </div>
                        <div>
                            <p class="text-xs+">Target</p>
                            <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                2 000
                            </p>
                        </div>
                        <div>
                            <p class="text-xs+">Clients</p>
                            <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                54
                            </p>
                        </div>
                    </div>
                    <div class="grow">
                        <div class="flex w-full space-x-1">
                            <div x-tooltip="'Phone Calls'" class="h-2 w-3/12 rounded-full bg-primary dark:bg-accent">
                            </div>
                            <div x-tooltip="'Chats Messages'" class="h-2 w-7/12 rounded-full bg-success"></div>
                            <div x-tooltip="'Emails'" class="size-2/12 rounded-full bg-info"></div>
                        </div>
                        <div class="mt-2 flex flex-wrap">
                            <div class="mr-4 mb-1 inline-flex items-center space-x-2 font-inter">
                                <div class="size-2 rounded-full bg-primary dark:bg-accent"></div>
                                <div class="flex space-x-1 text-xs leading-6">
                                    <span class="font-medium text-slate-700 dark:text-navy-100">Calls</span>
                                    <span>24%</span>
                                </div>
                            </div>
                            <div class="mr-4 mb-1 inline-flex items-center space-x-2 font-inter">
                                <div class="size-2 rounded-full bg-success"></div>
                                <div class="flex space-x-1 text-xs">
                                    <span class="font-medium text-slate-700 dark:text-navy-100">Chat Messages</span>
                                    <span>56%</span>
                                </div>
                            </div>
                            <div class="mb-1 inline-flex items-center space-x-2 font-inter">
                                <div class="size-2 rounded-full bg-info"></div>
                                <div class="flex space-x-1 text-xs">
                                    <span class="font-medium text-slate-700 dark:text-navy-100">Emails</span>
                                    <span>20%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div class="flex space-x-2">
                            <img x-tooltip="'Award Level 1'" class="size-6"
                                src="{{ asset('images/awards/award-1.svg') }}" alt="avatar" />
                            <img x-tooltip="'Award Level 2'" class="size-6"
                                src="{{ asset('images/awards/award-6.svg') }}" alt="avatar" />
                            <img x-tooltip="'Award Level 3'" class="size-6"
                                src="{{ asset('images/awards/award-9.svg') }}" alt="avatar" />
                        </div>
                        <button
                            class="btn -mr-1.5 size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="card w-72 shrink-0 space-y-9 rounded-xl p-4 sm:px-5">
                    <div class="flex items-center justify-between space-x-2">
                        <div class="flex items-center space-x-3">
                            <div class="avatar">
                                <img class="mask is-squircle" src="{{ asset('images/100x100.png') }}" alt="image" />
                            </div>
                            <div>
                                <p class="font-medium text-slate-700 line-clamp-1 dark:text-navy-100">
                                    Alfredo Elliott
                                </p>
                                <p class="text-xs text-slate-400 dark:text-navy-300">
                                    Contractors
                                </p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <div class="relative cursor-pointer">
                                <button
                                    class="btn size-7 bg-primary/10 p-0 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-accent-light/10 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </button>
                                <div
                                    class="absolute top-0 right-0 -m-1 flex h-4 min-w-[1rem] items-center justify-center rounded-full bg-primary px-1 text-tiny font-medium leading-none text-white dark:bg-accent">
                                    4
                                </div>
                            </div>
                            <div class="relative cursor-pointer">
                                <button
                                    class="btn size-7 bg-primary/10 p-0 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-accent-light/10 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between space-x-2">
                        <div>
                            <p class="text-xs+">Sells</p>
                            <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                423
                            </p>
                        </div>
                        <div>
                            <p class="text-xs+">Target</p>
                            <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                500
                            </p>
                        </div>
                        <div>
                            <p class="text-xs+">Clients</p>
                            <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                16
                            </p>
                        </div>
                    </div>
                    <div class="grow">
                        <div class="flex w-full space-x-1">
                            <div x-tooltip="'Phone Calls'" class="h-2 w-8/12 rounded-full bg-primary dark:bg-accent">
                            </div>
                            <div x-tooltip="'Chats Messages'" class="size-2/12 rounded-full bg-success"></div>
                            <div x-tooltip="'Emails'" class="size-2/12 rounded-full bg-info"></div>
                        </div>
                        <div class="mt-2 flex flex-wrap">
                            <div class="mr-4 mb-1 inline-flex items-center space-x-2 font-inter">
                                <div class="size-2 rounded-full bg-primary dark:bg-accent"></div>
                                <div class="flex space-x-1 text-xs leading-6">
                                    <span class="font-medium text-slate-700 dark:text-navy-100">Calls</span>
                                    <span>60%</span>
                                </div>
                            </div>
                            <div class="mr-4 mb-1 inline-flex items-center space-x-2 font-inter">
                                <div class="size-2 rounded-full bg-success"></div>
                                <div class="flex space-x-1 text-xs">
                                    <span class="font-medium text-slate-700 dark:text-navy-100">Chat Messages</span>
                                    <span>23%</span>
                                </div>
                            </div>
                            <div class="mb-1 inline-flex items-center space-x-2 font-inter">
                                <div class="size-2 rounded-full bg-info"></div>
                                <div class="flex space-x-1 text-xs">
                                    <span class="font-medium text-slate-700 dark:text-navy-100">Emails</span>
                                    <span>17%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div class="flex space-x-2">
                            <img x-tooltip="'Award Level 2'" class="size-6"
                                src="{{ asset('images/awards/award-14.svg') }}" alt="avatar" />
                            <img x-tooltip="'Award Level 3'" class="size-6"
                                src="{{ asset('images/awards/award-13.svg') }}" alt="avatar" />
                        </div>
                        <button
                            class="btn -mr-1.5 size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="card w-72 shrink-0 space-y-9 rounded-xl p-4 sm:px-5">
                    <div class="flex items-center justify-between space-x-2">
                        <div class="flex items-center space-x-3">
                            <div class="avatar">
                                <img class="mask is-squircle" src="{{ asset('images/100x100.png') }}" alt="image" />
                            </div>
                            <div>
                                <p class="font-medium text-slate-700 line-clamp-1 dark:text-navy-100">
                                    Samantha Shelton
                                </p>
                                <p class="text-xs text-slate-400 dark:text-navy-300">
                                    Contractors
                                </p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <div class="relative cursor-pointer">
                                <button
                                    class="btn size-7 bg-primary/10 p-0 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-accent-light/10 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </button>
                                <div
                                    class="absolute top-0 right-0 -m-1 flex h-4 min-w-[1rem] items-center justify-center rounded-full bg-primary px-1 text-tiny font-medium leading-none text-white dark:bg-accent">
                                    2
                                </div>
                            </div>
                            <div class="relative cursor-pointer">
                                <button
                                    class="btn size-7 bg-primary/10 p-0 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-accent-light/10 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between space-x-2">
                        <div>
                            <p class="text-xs+">Sells</p>
                            <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                579
                            </p>
                        </div>
                        <div>
                            <p class="text-xs+">Target</p>
                            <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                800
                            </p>
                        </div>
                        <div>
                            <p class="text-xs+">Clients</p>
                            <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                24
                            </p>
                        </div>
                    </div>
                    <div class="grow">
                        <div class="flex w-full space-x-1">
                            <div x-tooltip="'Phone Calls'" class="h-2 w-4/12 rounded-full bg-primary dark:bg-accent">
                            </div>
                            <div x-tooltip="'Chats Messages'" class="h-2 w-4/12 rounded-full bg-success"></div>
                            <div x-tooltip="'Emails'" class="h-2 w-4/12 rounded-full bg-info"></div>
                        </div>
                        <div class="mt-2 flex flex-wrap">
                            <div class="mr-4 mb-1 inline-flex items-center space-x-2 font-inter">
                                <div class="size-2 rounded-full bg-primary dark:bg-accent"></div>
                                <div class="flex space-x-1 text-xs leading-6">
                                    <span class="font-medium text-slate-700 dark:text-navy-100">Calls</span>
                                    <span>30%</span>
                                </div>
                            </div>
                            <div class="mr-4 mb-1 inline-flex items-center space-x-2 font-inter">
                                <div class="size-2 rounded-full bg-success"></div>
                                <div class="flex space-x-1 text-xs">
                                    <span class="font-medium text-slate-700 dark:text-navy-100">Chat Messages</span>
                                    <span>36%</span>
                                </div>
                            </div>
                            <div class="mb-1 inline-flex items-center space-x-2 font-inter">
                                <div class="size-2 rounded-full bg-info"></div>
                                <div class="flex space-x-1 text-xs">
                                    <span class="font-medium text-slate-700 dark:text-navy-100">Emails</span>
                                    <span>34%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div class="flex space-x-2">
                            <img x-tooltip="'Award Level 2'" class="size-6"
                                src="{{ asset('images/awards/award-15.svg') }}" alt="avatar" />
                            <img x-tooltip="'Award Level 3'" class="size-6"
                                src="{{ asset('images/awards/award-13.svg') }}" alt="avatar" />
                        </div>
                        <button
                            class="btn -mr-1.5 size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="card w-72 shrink-0 space-y-9 rounded-xl p-4 sm:px-5">
                    <div class="flex items-center justify-between space-x-2">
                        <div class="flex items-center space-x-3">
                            <div class="avatar">
                                <img class="mask is-squircle" src="{{ asset('images/100x100.png') }}" alt="image" />
                            </div>
                            <div>
                                <p class="font-medium text-slate-700 line-clamp-1 dark:text-navy-100">
                                    Derrick Simmons
                                </p>
                                <p class="text-xs text-slate-400 dark:text-navy-300">
                                    Employee
                                </p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <div class="relative cursor-pointer">
                                <button
                                    class="btn size-7 bg-primary/10 p-0 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-accent-light/10 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="relative cursor-pointer">
                                <button
                                    class="btn size-7 bg-primary/10 p-0 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-accent-light/10 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between space-x-2">
                        <div>
                            <p class="text-xs+">Sells</p>
                            <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                6 541
                            </p>
                        </div>
                        <div>
                            <p class="text-xs+">Target</p>
                            <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                8 000
                            </p>
                        </div>
                        <div>
                            <p class="text-xs+">Clients</p>
                            <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                145
                            </p>
                        </div>
                    </div>
                    <div class="grow">
                        <div class="flex w-full space-x-1">
                            <div x-tooltip="'Phone Calls'" class="h-2 w-6/12 rounded-full bg-primary dark:bg-accent">
                            </div>
                            <div x-tooltip="'Chats Messages'" class="h-2 w-4/12 rounded-full bg-success"></div>
                            <div x-tooltip="'Emails'" class="size-2/12 rounded-full bg-info"></div>
                        </div>
                        <div class="mt-2 flex flex-wrap">
                            <div class="mr-4 mb-1 inline-flex items-center space-x-2 font-inter">
                                <div class="size-2 rounded-full bg-primary dark:bg-accent"></div>
                                <div class="flex space-x-1 text-xs leading-6">
                                    <span class="font-medium text-slate-700 dark:text-navy-100">Calls</span>
                                    <span>55%</span>
                                </div>
                            </div>
                            <div class="mr-4 mb-1 inline-flex items-center space-x-2 font-inter">
                                <div class="size-2 rounded-full bg-success"></div>
                                <div class="flex space-x-1 text-xs">
                                    <span class="font-medium text-slate-700 dark:text-navy-100">Chat Messages</span>
                                    <span>30%</span>
                                </div>
                            </div>
                            <div class="mb-1 inline-flex items-center space-x-2 font-inter">
                                <div class="size-2 rounded-full bg-info"></div>
                                <div class="flex space-x-1 text-xs">
                                    <span class="font-medium text-slate-700 dark:text-navy-100">Emails</span>
                                    <span>15%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between">
                        <div class="flex space-x-2">
                            <img x-tooltip="'Award Level 2'" class="size-6"
                                src="{{ asset('images/awards/award-15.svg') }}" alt="avatar" />
                            <img x-tooltip="'Award Level 3'" class="size-6"
                                src="{{ asset('images/awards/award-5.svg') }}" alt="avatar" />
                            <img x-tooltip="'Award Level 3'" class="size-6"
                                src="{{ asset('images/awards/award-25.svg') }}" alt="avatar" />
                        </div>
                        <button
                            class="btn -mr-1.5 size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="card w-72 shrink-0 space-y-9 rounded-xl p-4 sm:px-5">
                    <div class="flex items-center justify-between space-x-2">
                        <div class="flex items-center space-x-3">
                            <div class="avatar">
                                <img class="mask is-squircle" src="{{ asset('images/100x100.png') }}" alt="image" />
                            </div>
                            <div>
                                <p class="font-medium text-slate-700 line-clamp-1 dark:text-navy-100">
                                    Katrina West
                                </p>
                                <p class="text-xs text-slate-400 dark:text-navy-300">
                                    Employee
                                </p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <div class="relative cursor-pointer">
                                <button
                                    class="btn size-7 bg-primary/10 p-0 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-accent-light/10 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                    </svg>
                                </button>
                                <div
                                    class="absolute top-0 right-0 -m-1 flex h-4 min-w-[1rem] items-center justify-center rounded-full bg-primary px-1 text-tiny font-medium leading-none text-white dark:bg-accent">
                                    1
                                </div>
                            </div>
                            <div class="relative cursor-pointer">
                                <button
                                    class="btn size-7 bg-primary/10 p-0 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-accent-light/10 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between space-x-2">
                        <div>
                            <p class="text-xs+">Sells</p>
                            <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                3 481
                            </p>
                        </div>
                        <div>
                            <p class="text-xs+">Target</p>
                            <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                5 000
                            </p>
                        </div>
                        <div>
                            <p class="text-xs+">Clients</p>
                            <p class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                                96
                            </p>
                        </div>
                    </div>

                    <div class="grow">
                        <div class="flex w-full space-x-1">
                            <div x-tooltip="'Phone Calls'" class="h-2 w-1/12 rounded-full bg-primary dark:bg-accent">
                            </div>
                            <div x-tooltip="'Chats Messages'" class="h-2 w-5/12 rounded-full bg-success"></div>
                            <div x-tooltip="'Emails'" class="h-2 w-6/12 rounded-full bg-info"></div>
                        </div>
                        <div class="mt-2 flex flex-wrap">
                            <div class="mr-4 mb-1 inline-flex items-center space-x-2 font-inter">
                                <div class="size-2 rounded-full bg-primary dark:bg-accent"></div>
                                <div class="flex space-x-1 text-xs leading-6">
                                    <span class="font-medium text-slate-700 dark:text-navy-100">Calls</span>
                                    <span>9%</span>
                                </div>
                            </div>
                            <div class="mr-4 mb-1 inline-flex items-center space-x-2 font-inter">
                                <div class="size-2 rounded-full bg-success"></div>
                                <div class="flex space-x-1 text-xs">
                                    <span class="font-medium text-slate-700 dark:text-navy-100">Chat Messages</span>
                                    <span>41%</span>
                                </div>
                            </div>
                            <div class="mb-1 inline-flex items-center space-x-2 font-inter">
                                <div class="size-2 rounded-full bg-info"></div>
                                <div class="flex space-x-1 text-xs">
                                    <span class="font-medium text-slate-700 dark:text-navy-100">Emails</span>
                                    <span>50%</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-between">
                        <div class="flex space-x-2">
                            <img x-tooltip="'Award Level 2'" class="size-6"
                                src="{{ asset('images/awards/award-1.svg') }}" alt="avatar" />
                            <img x-tooltip="'Award Level 3'" class="size-6"
                                src="{{ asset('images/awards/award-24.svg') }}" alt="avatar" />
                            <img x-tooltip="'Award Level 3'" class="size-6"
                                src="{{ asset('images/awards/award-30.svg') }}" alt="avatar" />
                        </div>
                        <button
                            class="btn -mr-1.5 size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="mt-4 grid grid-cols-12 gap-4 px-[var(--margin-x)] transition-all duration-[.25s] sm:mt-5 sm:gap-5 lg:mt-6 lg:gap-6">
            <div class="col-span-12">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100">
                        Latest Orders
                    </h2>
                    <div class="flex">
                        <div class="flex items-center" x-data="{ isInputActive: false }">
                            <label class="block">
                                <input x-effect="isInputActive === true && $nextTick(() => { $el.focus()});"
                                    :class="isInputActive ? 'w-32 lg:w-48' : 'w-0'"
                                    class="form-input bg-transparent px-1 text-right transition-all duration-100 placeholder:text-slate-500 dark:placeholder:text-navy-200 border-0 ring-0 outline-none focus:ring-0"
                                    placeholder="Search here..." type="text" />
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
                        <div x-data="usePopper({ placement: 'bottom-end', offset: 4 })"
                            @click.outside="if(isShowPopper) isShowPopper = false" class="inline-flex">
                            <button x-ref="popperRef" @click="isShowPopper = !isShowPopper"
                                class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                </svg>
                            </button>
                            <div x-ref="popperRoot" class="popper-root" :class="isShowPopper && 'show'">
                                <div
                                    class="popper-box rounded-md border border-slate-150 bg-white py-1.5 font-inter dark:border-navy-500 dark:bg-navy-700">
                                    <ul>
                                        <li>
                                            <a href="#"
                                                class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">Action</a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">Another
                                                Action</a>
                                        </li>
                                        <li>
                                            <a href="#"
                                                class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">Something
                                                else</a>
                                        </li>
                                    </ul>
                                    <div class="my-1 h-px bg-slate-150 dark:bg-navy-500"></div>
                                    <ul>
                                        <li>
                                            <a href="#"
                                                class="flex h-8 items-center px-3 pr-8 font-medium tracking-wide outline-none transition-all hover:bg-slate-100 hover:text-slate-800 focus:bg-slate-100 focus:text-slate-800 dark:hover:bg-navy-600 dark:hover:text-navy-100 dark:focus:bg-navy-600 dark:focus:text-navy-100">Separated
                                                Link</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="is-scrollbar-hidden min-w-full overflow-x-auto">
                        <table class="is-hoverable w-full text-left">
                            <thead>
                                <tr>
                                    <th
                                        class="whitespace-nowrap rounded-tl-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                        Order
                                    </th>
                                    <th
                                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                        Date
                                    </th>
                                    <th
                                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                        Name
                                    </th>
                                    <th
                                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                        Address
                                    </th>
                                    <th
                                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                        Order Status
                                    </th>
                                    <th
                                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                        Payment
                                    </th>
                                    <th
                                        class="whitespace-nowrap bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                        Total
                                    </th>

                                    <th
                                        class="whitespace-nowrap rounded-tr-lg bg-slate-200 px-4 py-3 font-semibold uppercase text-slate-800 dark:bg-navy-800 dark:text-navy-100 lg:px-5">
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="font-medium text-primary dark:text-accent-light">
                                            #95647
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="font-medium">25 May 2021</p>
                                        <p class="mt-0.5 text-xs">01:25 AM</p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="flex items-center space-x-4">
                                            <div class="avatar size-9">
                                                <img class="mask is-squircle" src="{{ asset('images/100x100.png') }}"
                                                    alt="avatar" />
                                            </div>

                                            <span class="font-medium text-slate-700 dark:text-navy-100">Anthony Jensen
                                            </span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="w-48 overflow-hidden text-ellipsis text-xs+">
                                            260 W. Storm Street New York, NY 10025.
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="badge bg-warning/10 text-warning dark:bg-warning/15">
                                            Unconfirmed
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="badge space-x-2.5 text-xs+ text-warning">
                                            <div class="size-2 rounded-full bg-current"></div>
                                            <span>Await Auth</span>
                                        </div>
                                    </td>

                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                                            $2 654
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <button
                                            class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="font-medium text-primary dark:text-accent-light">
                                            #84895
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="font-medium">03 May 2021</p>
                                        <p class="mt-0.5 text-xs">09:44 AM</p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="flex items-center space-x-4">
                                            <div class="avatar size-9">
                                                <img class="mask is-squircle" src="{{ asset('images/100x100.png') }}"
                                                    alt="avatar" />
                                            </div>

                                            <span class="font-medium text-slate-700 dark:text-navy-100">John Due
                                            </span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="w-48 overflow-hidden text-ellipsis text-xs+">
                                            13811 Gimbert Ln Santa Ana, California(CA), 92705
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="badge bg-success/10 text-success dark:bg-success/15">
                                            Completed
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="badge space-x-2.5 text-xs+ text-success">
                                            <div class="size-2 rounded-full bg-current"></div>
                                            <span>Paid</span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                                            $3 654
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <button
                                            class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="font-medium text-primary dark:text-accent-light">
                                            #49756
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="font-medium">19 Jun 2021</p>
                                        <p class="mt-0.5 text-xs">5:43 AM</p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="flex items-center space-x-4">
                                            <div class="avatar size-9">
                                                <img class="mask is-squircle" src="{{ asset('images/100x100.png') }}"
                                                    alt="avatar" />
                                            </div>

                                            <span class="font-medium text-slate-700 dark:text-navy-100">Tom Robert
                                            </span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="w-48 overflow-hidden text-ellipsis text-xs+">
                                            3803 Fox Rd Huron, Ohio(OH), 44839
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="badge bg-info/10 text-info dark:bg-info/15">
                                            Shipped
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="badge space-x-2.5 text-xs+ text-success">
                                            <div class="size-2 rounded-full bg-current"></div>
                                            <span>Paid</span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                                            $6 156
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <button
                                            class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="font-medium text-primary dark:text-accent-light">
                                            #79632
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="font-medium">03 Jun 2021</p>
                                        <p class="mt-0.5 text-xs">4:54 AM</p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="flex items-center space-x-4">
                                            <div class="avatar size-9">
                                                <img class="mask is-squircle" src="{{ asset('images/100x100.png') }}"
                                                    alt="avatar" />
                                            </div>

                                            <span class="font-medium text-slate-700 dark:text-navy-100">Nolan Doe
                                            </span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="w-48 overflow-hidden text-ellipsis text-xs+">
                                            1805 Jackson Ave Seaford, New York(NY), 11783
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div
                                            class="badge bg-primary/10 text-primary dark:bg-accent-light/15 dark:text-accent-light">
                                            Processing
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="badge space-x-2.5 text-xs+ text-success">
                                            <div class="size-2 rounded-full bg-current"></div>
                                            <span>Paid</span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                                            $7 621
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <button
                                            class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="font-medium text-primary dark:text-accent-light">
                                            #12668
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="font-medium">09 Jun 2021</p>
                                        <p class="mt-0.5 text-xs">2:03 AM</p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="flex items-center space-x-4">
                                            <div class="avatar size-9">
                                                <img class="mask is-squircle" src="{{ asset('images/100x100.png') }}"
                                                    alt="avatar" />
                                            </div>

                                            <span class="font-medium text-slate-700 dark:text-navy-100">Henry Curtis
                                            </span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="w-48 overflow-hidden text-ellipsis text-xs+">
                                            421 Basswood Ln Haysville, Kansas(KS), 67060
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="badge bg-error/10 text-error dark:bg-error/15">
                                            Cancelled
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="badge space-x-2.5 text-xs+ text-error">
                                            <div class="size-2 rounded-full bg-current"></div>
                                            <span>Failed</span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                                            $456
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <button
                                            class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="font-medium text-primary dark:text-accent-light">
                                            #66463
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="font-medium">23 Jul 2021</p>
                                        <p class="mt-0.5 text-xs">9:11 AM</p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="flex items-center space-x-4">
                                            <div class="avatar size-9">
                                                <img class="mask is-squircle" src="{{ asset('images/100x100.png') }}"
                                                    alt="avatar" />
                                            </div>

                                            <span class="font-medium text-slate-700 dark:text-navy-100">Katrina West
                                            </span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="w-48 overflow-hidden text-ellipsis text-xs+">
                                            205 Hope Rd Helena, Montana(MT), 59602
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="badge bg-warning/10 text-warning dark:bg-warning/15">
                                            Unconfirmed
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="badge space-x-2.5 text-xs+ text-warning">
                                            <div class="size-2 rounded-full bg-current"></div>
                                            <span>Await Auth</span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                                            $5 116
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <button
                                            class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>

                                <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="font-medium text-primary dark:text-accent-light">
                                            #53133
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="font-medium">11 Aug 2021</p>
                                        <p class="mt-0.5 text-xs">12:11 AM</p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="flex items-center space-x-4">
                                            <div class="avatar size-9">
                                                <img class="mask is-squircle" src="{{ asset('images/100x100.png') }}"
                                                    alt="avatar" />
                                            </div>

                                            <span class="font-medium text-slate-700 dark:text-navy-100">Lance Tucker
                                            </span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="w-48 overflow-hidden text-ellipsis text-xs+">
                                            1805 Jackson Ave Seaford, New York(NY), 11783
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="badge bg-warning/10 text-warning dark:bg-warning/15">
                                            Unconfirmed
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="badge space-x-2.5 text-xs+ text-warning">
                                            <div class="size-2 rounded-full bg-current"></div>
                                            <span>Await Auth</span>
                                        </div>
                                    </td>

                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                                            $4 952
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <button
                                            class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="font-medium text-primary dark:text-accent-light">
                                            #5684
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="font-medium">11 May 2021</p>
                                        <p class="mt-0.5 text-xs">07:55 AM</p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="flex items-center space-x-4">
                                            <div class="avatar size-9">
                                                <img class="mask is-squircle" src="{{ asset('images/100x100.png') }}"
                                                    alt="avatar" />
                                            </div>

                                            <span class="font-medium text-slate-700 dark:text-navy-100">Raul Bradley
                                            </span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="w-48 overflow-hidden text-ellipsis text-xs+">
                                            13811 Gimbert Ln Santa Ana, California(CA), 92705
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="badge bg-success/10 text-success dark:bg-success/15">
                                            Completed
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="badge space-x-2.5 text-xs+ text-success">
                                            <div class="size-2 rounded-full bg-current"></div>
                                            <span>Paid</span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                                            $5 137
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <button
                                            class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="font-medium text-primary dark:text-accent-light">
                                            #64669
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="font-medium">29 Jun 2021</p>
                                        <p class="mt-0.5 text-xs">1:54 AM</p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="flex items-center space-x-4">
                                            <div class="avatar size-9">
                                                <img class="mask is-squircle" src="{{ asset('images/100x100.png') }}"
                                                    alt="avatar" />
                                            </div>

                                            <span class="font-medium text-slate-700 dark:text-navy-100">Derrick
                                                Simmons
                                            </span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="w-48 overflow-hidden text-ellipsis text-xs+">
                                            3803 Fox Rd Huron, Ohio(OH), 44839
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="badge bg-info/10 text-info dark:bg-info/15">
                                            Shipped
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="badge space-x-2.5 text-xs+ text-success">
                                            <div class="size-2 rounded-full bg-current"></div>
                                            <span>Paid</span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                                            $2 566
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <button
                                            class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="border-y border-transparent border-b-slate-200 dark:border-b-navy-500">
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="font-medium text-primary dark:text-accent-light">
                                            #31669
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="font-medium">08 Jun 2021</p>
                                        <p class="mt-0.5 text-xs">7:36 AM</p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="flex items-center space-x-4">
                                            <div class="avatar size-9">
                                                <img class="mask is-squircle" src="{{ asset('images/100x100.png') }}"
                                                    alt="avatar" />
                                            </div>

                                            <span class="font-medium text-slate-700 dark:text-navy-100">Samantha
                                                Shelton
                                            </span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="w-48 overflow-hidden text-ellipsis text-xs+">
                                            1805 Jackson Ave Seaford, New York(NY), 11783
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div
                                            class="badge bg-primary/10 text-primary dark:bg-accent-light/15 dark:text-accent-light">
                                            Processing
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <div class="badge space-x-2.5 text-xs+ text-success">
                                            <div class="size-2 rounded-full bg-current"></div>
                                            <span>Paid</span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <p class="text-sm+ font-medium text-slate-700 dark:text-navy-100">
                                            $9 665
                                        </p>
                                    </td>
                                    <td class="whitespace-nowrap px-4 py-3 sm:px-5">
                                        <button
                                            class="btn size-8 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div
                        class="flex flex-col justify-between space-y-4 px-4 py-4 sm:flex-row sm:items-center sm:space-y-0 sm:px-5">
                        <div class="flex items-center space-x-2 text-xs+">
                            <span>Show</span>
                            <label class="block">
                                <select
                                    class="form-select rounded-full border border-slate-300 bg-white px-2 py-1 pr-6 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent">
                                    <option>10</option>
                                    <option>30</option>
                                    <option>50</option>
                                </select>
                            </label>
                            <span>entries</span>
                        </div>

                        <ol class="pagination">
                            <li class="rounded-l-lg bg-slate-150 dark:bg-navy-500">
                                <a href="#"
                                    class="flex size-8 items-center justify-center rounded-lg text-slate-500 transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:text-navy-200 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </a>
                            </li>
                            <li class="bg-slate-150 dark:bg-navy-500">
                                <a href="#"
                                    class="flex h-8 min-w-[2rem] items-center justify-center rounded-lg px-3 leading-tight transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">1</a>
                            </li>
                            <li class="bg-slate-150 dark:bg-navy-500">
                                <a href="#"
                                    class="flex h-8 min-w-[2rem] items-center justify-center rounded-lg bg-primary px-3 leading-tight text-white transition-colors hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">2</a>
                            </li>
                            <li class="bg-slate-150 dark:bg-navy-500">
                                <a href="#"
                                    class="flex h-8 min-w-[2rem] items-center justify-center rounded-lg px-3 leading-tight transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">3</a>
                            </li>
                            <li class="bg-slate-150 dark:bg-navy-500">
                                <a href="#"
                                    class="flex h-8 min-w-[2rem] items-center justify-center rounded-lg px-3 leading-tight transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">4</a>
                            </li>
                            <li class="bg-slate-150 dark:bg-navy-500">
                                <a href="#"
                                    class="flex h-8 min-w-[2rem] items-center justify-center rounded-lg px-3 leading-tight transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">5</a>
                            </li>
                            <li class="rounded-r-lg bg-slate-150 dark:bg-navy-500">
                                <a href="#"
                                    class="flex size-8 items-center justify-center rounded-lg text-slate-500 transition-colors hover:bg-slate-300 focus:bg-slate-300 active:bg-slate-300/80 dark:text-navy-200 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </li>
                        </ol>

                        <div class="text-xs+">1 - 10 of 10 entries</div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layouts.app-layout>