@props(['page' => 'login'])

<div class="my-7 flex items-center space-x-3">
    <div class="h-px flex-1 bg-slate-200 dark:bg-navy-500"></div>
    <p>{{ __('OR') }}</p>
    <div class="h-px flex-1 bg-slate-200 dark:bg-navy-500"></div>
</div>
<div x-data="{ showModal: false, showFBModal: false, showXModal: false }">
    <div class="flex space-x-4">
        @if ($page === 'login')
            <a href="{{ route('auth.google') }}"
                class="btn w-full space-x-3 border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                <img class="size-5.5 " src="{{ asset('images/google.png') }}" alt="logo" />
                <span>{{ __('Google') }}</span>
            </a>
            <a href="{{ route('auth.facebook') }}"
                class="btn w-full space-x-3 border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                <img class="size-5.5 " src="{{ asset('images/facebook.png') }}" alt="logo" />
                <span>{{ __('Facebook') }}</span>
            </a>
            <a href="{{ route('auth.twitter') }}"
                class="btn w-full space-x-3 border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                <img class="size-5.5 " src="{{ asset('images/twitter.png') }}" alt="logo" />
                <span>{{ __('Twitter') }}</span>
            </a>
        @else
            <button type="button" @click="showModal = true"
                class="btn w-full space-x-3 border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                <img class="size-5.5 " src="{{ asset('images/google.png') }}" alt="logo" />
                {{-- <span>{{ __('Google') }}</span> --}}
            </button>
            <button type="button" @click="showFBModal = true"
                class="btn w-full space-x-3 border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                <img class="size-5.5" src="{{ asset('images/facebook.png') }}" alt="logo" />
                {{-- <span>{{ __('Facebook') }}</span> --}}
            </button>
            <button type="button" @click="showXModal = true"
                class="btn w-full space-x-3 border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                <img class="size-5.5" src="{{ asset('images/twitter.png') }}" alt="logo" />
                {{-- <span>{{ __('Twitter') }}</span> --}}
            </button>
        @endif

        <template x-teleport="#x-teleport-target">
            <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
                <div class="absolute inset-0 bg-slate-900/60 transition-opacity duration-300" @click="showModal = false"
                    x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
                <div class="relative max-w-md rounded-lg bg-white pt-10 pb-4 text-center transition-all duration-300 dark:bg-navy-700"
                    x-show="showModal" x-transition:enter="easy-out"
                    x-transition:enter-start="opacity-0 [transform:translate3d(0,1rem,0)]"
                    x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]" x-transition:leave="easy-in"
                    x-transition:leave-start="opacity-100 [transform:translate3d(0,0,0)]"
                    x-transition:leave-end="opacity-0 [transform:translate3d(0,1rem,0)]">

                    <div class="px-4 sm:px-12 text-left">
                        <a href="{{ route('auth.google', ['type' => 'sponsor']) }}"
                            class="btn w-full space-x-3 border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                            <img class="size-5.5 " src="{{ asset('images/google.png') }}" alt="logo" />
                            <span>{{ __('Register as Sponsor') }}</span>
                        </a>
                        <a href="{{ route('auth.google', ['type' => 'ad-space-owner']) }}"
                            class="mt-4 btn w-full space-x-3 border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                            <img class="size-5.5 " src="{{ asset('images/google.png') }}" alt="logo" />
                            <span>{{ __('Register as Ad Space Owner') }}</span>
                        </a>
                    </div>
                    <div class="my-4 h-px bg-slate-200 dark:bg-navy-500"></div>

                    <div class="px-5 text-center">
                        <button type="button" @click="showModal = false"
                            class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                            {{ __('Cancel') }}
                        </button>
                    </div>
                </div>
            </div>
        </template>

        <template x-teleport="#x-teleport-target">
            <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                x-show="showFBModal" role="dialog" @keydown.window.escape="showFBModal = false">
                <div class="absolute inset-0 bg-slate-900/60 transition-opacity duration-300"
                    @click="showFBModal = false" x-show="showFBModal" x-transition:enter="ease-out"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"></div>
                <div class="relative max-w-md rounded-lg bg-white pt-10 pb-4 text-center transition-all duration-300 dark:bg-navy-700"
                    x-show="showFBModal" x-transition:enter="easy-out"
                    x-transition:enter-start="opacity-0 [transform:translate3d(0,1rem,0)]"
                    x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]" x-transition:leave="easy-in"
                    x-transition:leave-start="opacity-100 [transform:translate3d(0,0,0)]"
                    x-transition:leave-end="opacity-0 [transform:translate3d(0,1rem,0)]">

                    <div class="px-4 sm:px-12 text-left">
                        <a href="{{ route('auth.facebook', ['type' => 'sponsor']) }}"
                            class="btn w-full space-x-3 border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                            <img class="size-5.5 " src="{{ asset('images/facebook.png') }}" alt="logo" />
                            <span>{{ __('Register as Sponsor') }}</span>
                        </a>
                        <a href="{{ route('auth.facebook', ['type' => 'ad-space-owner']) }}"
                            class="mt-4 btn w-full space-x-3 border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                            <img class="size-5.5 " src="{{ asset('images/facebook.png') }}" alt="logo" />
                            <span>{{ __('Register as Ad Space Owner') }}</span>
                        </a>
                    </div>
                    <div class="my-4 h-px bg-slate-200 dark:bg-navy-500"></div>

                    <div class="px-5 text-center">
                        <button type="button" @click="showFBModal = false"
                            class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                            {{ __('Cancel') }}
                        </button>
                    </div>
                </div>
            </div>
        </template>

        <template x-teleport="#x-teleport-target">
            <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                x-show="showXModal" role="dialog" @keydown.window.escape="showXModal = false">
                <div class="absolute inset-0 bg-slate-900/60 transition-opacity duration-300"
                    @click="showXModal = false" x-show="showXModal" x-transition:enter="ease-out"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"></div>
                <div class="relative max-w-md rounded-lg bg-white pt-10 pb-4 text-center transition-all duration-300 dark:bg-navy-700"
                    x-show="showXModal" x-transition:enter="easy-out"
                    x-transition:enter-start="opacity-0 [transform:translate3d(0,1rem,0)]"
                    x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]" x-transition:leave="easy-in"
                    x-transition:leave-start="opacity-100 [transform:translate3d(0,0,0)]"
                    x-transition:leave-end="opacity-0 [transform:translate3d(0,1rem,0)]">

                    <div class="px-4 sm:px-12 text-left">
                        <a href="{{ route('auth.twitter', ['type' => 'sponsor']) }}"
                            class="btn w-full space-x-3 border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                            <img class="size-5.5 " src="{{ asset('images/twitter.png') }}" alt="logo" />
                            <span>{{ __('Register as Sponsor') }}</span>
                        </a>
                        <a href="{{ route('auth.twitter', ['type' => 'ad-space-owner']) }}"
                            class="mt-4 btn w-full space-x-3 border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                            <img class="size-5.5 " src="{{ asset('images/twitter.png') }}" alt="logo" />
                            <span>{{ __('Register as Ad Space Owner') }}</span>
                        </a>
                    </div>
                    <div class="my-4 h-px bg-slate-200 dark:bg-navy-500"></div>

                    <div class="px-5 text-center">
                        <button type="button" @click="showXModal = false"
                            class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                            {{ __('Cancel') }}
                        </button>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>
