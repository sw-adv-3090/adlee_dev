<x-layouts.base-layout title="2FA Verification">
    <main class="grid w-full grow grid-cols-1 place-items-center">
        <div class="w-full max-w-[26rem] p-4 sm:px-5">
            <div class="text-center">
                <x-app-logo />
                <div class="mt-4">
                    <h2 class="text-2xl font-semibold text-slate-600 dark:text-navy-100">
                        {{ __('2FA Verification') }}
                    </h2>
                </div>
            </div>
            <form method="POST" action="{{ route('two-factor.login') }}">
                @csrf
                <div class="card mt-5 rounded-lg p-5 lg:p-7" x-data="{ recovery: false }">
                    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400" x-show="! recovery">
                        {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
                    </div>

                    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400" x-cloak x-show="recovery">
                        {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
                    </div>

                    <x-validation-errors class="mt-4" />

                    <div class="" x-show="! recovery">
                        <label class="block">
                            <span>{{ __('Code') }}</span>
                            <span class="relative mt-1.5 flex">
                                <input
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="{{ __('Code') }}" type="text" inputmode="numeric" name="code"
                                    autofocus x-ref="code" autocomplete="one-time-code" />
                                <span
                                    class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="size-5 transition-colors duration-200" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </span>
                            </span>
                        </label>
                    </div>

                    <div class="" x-cloak x-show="recovery">
                        <label class="block">
                            <span>{{ __('Recovery Code') }}</span>
                            <span class="relative mt-1.5 flex">
                                <input
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="{{ __('Recovery Code') }}" type="text" name="recovery_code"
                                    x-ref="recovery_code" autocomplete="one-time-code" />
                                <span
                                    class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="size-5 transition-colors duration-200" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </span>
                            </span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button type="button"
                            class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 underline cursor-pointer"
                            x-show="! recovery"
                            x-on:click="
                                        recovery = true;
                                        $nextTick(() => { $refs.recovery_code.focus() })
                                    ">
                            {{ __('Use a recovery code') }}
                        </button>

                        <button type="button"
                            class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 underline cursor-pointer"
                            x-cloak x-show="recovery"
                            x-on:click="
                                        recovery = false;
                                        $nextTick(() => { $refs.code.focus() })
                                    ">
                            {{ __('Use an authentication code') }}
                        </button>
                    </div>

                    <x-primary-button class="mt-5">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </main>
</x-layouts.base-layout>
