<x-layouts.app-layout title="Browser Sessions" is-header-blur="true">
    <x-breadcrumbs title="Browser Sessions" menu="Profile" />

    <div class="flex flex-col lg:flex-row gap-4 sm:gap-5 lg:gap-6">
        @include('profile.sidebar')

        <div class="w-full lg:w-[67%]">
            <div class="card">
                <div
                    class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                    <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                        {{ __('Browser Sessions') }}
                    </h2>
                </div>

                <div class="p-4 sm:p-5">
                    @session('status')
                        <div class="my-3 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ $value }}
                        </div>
                    @endsession
                    @session('error')
                        <div class="my-3 font-medium text-sm text-red-600 dark:text-red-400">
                            {{ $value }}
                        </div>
                    @endsession

                    <p class="text-slate-700 dark:text-navy-300 mb-4">
                        {{ __('Manage and log out your active sessions on other browsers and devices.') }}
                    </p>

                    <div class="w-full text-sm text-gray-600 dark:text-gray-400">
                        <span>
                            {{ __('If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password.') }}
                        </span>

                        @if (count($sessions) > 0)
                            <div class="mt-5 space-y-6">
                                <!-- Other Browser Sessions -->
                                @foreach ($sessions as $session)
                                    <div class="flex items-center">
                                        <div>
                                            @if ($session->agent->isDesktop())
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-8 h-8 text-gray-500">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-8 h-8 text-gray-500">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                                </svg>
                                            @endif
                                        </div>

                                        <div class="ms-3">
                                            <div class="text-sm text-gray-600 dark:text-gray-400">
                                                {{ $session->agent->platform() ? $session->agent->platform() : __('Unknown') }}
                                                -
                                                {{ $session->agent->browser() ? $session->agent->browser() : __('Unknown') }}
                                            </div>

                                            <div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $session->ip_address }},

                                                    @if ($session->is_current_device)
                                                        <span
                                                            class="text-green-500 font-semibold">{{ __('This device') }}</span>
                                                    @else
                                                        {{ __('Last active') }} {{ $session->last_active }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="mt-5" x-data="{ showModal: false }">
                            <x-primary-button type="button" @click="showModal = true" class="max-w-[300px]">
                                {{ __('Log Out Other Browser Sessions') }}
                            </x-primary-button>

                            <template x-teleport="#x-teleport-target">
                                <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                                    x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
                                    <div class="absolute inset-0 bg-slate-900/60 transition-opacity duration-300"
                                        @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
                                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                        x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0"></div>
                                    <div class="relative max-w-md rounded-lg bg-white pt-10 pb-4 text-center transition-all duration-300 dark:bg-navy-700"
                                        x-show="showModal" x-transition:enter="easy-out"
                                        x-transition:enter-start="opacity-0 [transform:translate3d(0,1rem,0)]"
                                        x-transition:enter-end="opacity-100 [transform:translate3d(0,0,0)]"
                                        x-transition:leave="easy-in"
                                        x-transition:leave-start="opacity-100 [transform:translate3d(0,0,0)]"
                                        x-transition:leave-end="opacity-0 [transform:translate3d(0,1rem,0)]">

                                        <form action="{{ route('browser_sessions.logout') }}" method="post">
                                            @csrf
                                            <div class="px-4 sm:px-12 text-left">
                                                <span>
                                                    {{ __('Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices.') }}</span>

                                                <label class="mt-4 block text-left">
                                                    <span>{{ __('Password') }}</span>
                                                    <span class="relative mt-1.5 flex">
                                                        <input
                                                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                            placeholder="{{ __('Enter Password') }}" type="password"
                                                            name="password" required />
                                                        <span
                                                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="size-5 transition-colors duration-200"
                                                                fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="1.5"
                                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                            </svg>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                            <div class="my-4 h-px bg-slate-200 dark:bg-navy-500"></div>

                                            <div class="px-5">
                                                <button type="button" @click="showModal = false"
                                                    class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                                    {{ __('Cancel') }}
                                                </button>
                                                <button type="submit"
                                                    class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                                    {{ __('Log Out Other Browser Sessions') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app-layout>
