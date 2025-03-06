<x-layouts.app-layout title="Templates Overview" is-sidebar-open="true" main="true">
    @php
        $sponsor_bg = 'bg-gradient-to-br from-amber-400 to-orange-600';
        $coupon_bg = 'bg-gradient-to-br from-pink-500 to-rose-500';
    @endphp
    <!-- Main Content Wrapper -->
    <main class="main-content w-full pb-8">
        <div class="mt-4 gap-4 px-[var(--margin-x)] transition-all duration-[.25s] sm:mt-5 sm:gap-5 lg:mt-6 lg:gap-6">
            @livewire('admin.templates.overview', ['sponsor_bg' => $sponsor_bg, 'coupon_bg' => $coupon_bg])
        </div>

        @if (count($topTemplates) > 0)
            <div class="mt-4 pl-[var(--margin-x)] transition-all duration-[.25s] sm:mt-5 lg:mt-6">
                <div class="rounded-l-lg bg-slate-150 pt-4 pb-1 dark:bg-navy-800">
                    <h2
                        class="px-4 text-base font-medium tracking-wide text-slate-700 line-clamp-1 dark:text-navy-100 sm:px-5 lg:text-lg">
                        Top Templates
                    </h2>
                    <div class="scrollbar-sm mt-4 flex space-x-4 overflow-x-auto px-4 pb-4 sm:px-5">
                        @foreach ($topTemplates as $template)
                            <div class="flex w-72 shrink-0 flex-col">
                                <img class="h-48 w-full rounded-2xl object-cover object-center"
                                    src="{{ asset($template->preview) }}" alt="{{ $template->title }}" />

                                <div class="card mx-2 -mt-8 grow rounded-2xl p-3.5">
                                    <div class="flex space-x-2">
                                        @if ($template->type === \App\Enums\TemplateType::SPONSOR->value)
                                            <div
                                                class="badge rounded-full {{ $sponsor_bg }} py-1 uppercase text-white">
                                                Sponosor
                                            </div>
                                        @else
                                            <div
                                                class="badge rounded-full {{ $coupon_bg }} py-1 uppercase text-white">
                                                Coupon
                                            </div>
                                        @endif

                                        <div class="flex flex-wrap items-center font-inter text-xs uppercase">
                                            <p>0 clients</p>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <a href="#"
                                            class="text-sm+ font-medium text-slate-700 line-clamp-1 hover:text-primary focus:text-primary dark:text-navy-100 dark:hover:text-accent-light dark:focus:text-accent-light">{{ $template->title }}</a>
                                    </div>
                                    <div class="flex items-end justify-between">
                                        <p class="mt-2">
                                            <span
                                                class="text-base font-medium text-slate-700 dark:text-navy-100">$0</span>
                                        </p>
                                        <p class="flex shrink-0 items-center space-x-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" stroke="currentColor"
                                                class="size-3.5 text-slate-400 dark:text-navy-300" fill="none"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M13.948 4.29l1.643 3.169c.224.44.82.864 1.325.945l2.977.477c1.905.306 2.353 1.639.98 2.953l-2.314 2.233c-.392.378-.607 1.107-.486 1.63l.663 2.763c.523 2.188-.681 3.034-2.688 1.89l-2.791-1.593c-.504-.288-1.335-.288-1.848 0l-2.791 1.594c-1.997 1.143-3.21.288-2.688-1.89l.663-2.765c.12-.522-.094-1.251-.486-1.63l-2.315-2.232c-1.362-1.314-.924-2.647.98-2.953l2.978-.477c.495-.081 1.092-.504 1.316-.945l1.643-3.17c.896-1.719 2.352-1.719 3.239 0z" />
                                            </svg>
                                            <span>0</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

    </main>
    <!-- Main Content Wrapper End -->
</x-layouts.app-layout>
