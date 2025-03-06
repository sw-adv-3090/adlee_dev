<x-layouts.base-layout title="{{ __('Two Factor Verification') }}">
    <main class="grid w-full grow grid-cols-1 place-items-center">
        <div class="w-full max-w-[26rem] p-4 sm:px-5">
            <div class="text-center">
                <x-app-logo />
                <div class="mt-4">
                    <h2 class="text-2xl font-semibold text-slate-600 dark:text-navy-100">
                        {{ __('Two Factor Verification') }}
                    </h2>
                </div>
            </div>
            <form method="POST" action="{{ route('verify.store') }}">
                @csrf
                <div class="card mt-5 rounded-lg p-5 lg:p-7">
                    <p class="text-slate-400 dark:text-navy-300">
                        {{ __('Before continuing, Please verify 2FA code that has been send you through your provided email.') }}
                    </p>

                    @session('status')
                        <div class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ $value }}
                        </div>
                    @endsession

                    <x-validation-errors class="mt-2" />

                    <label class="block mt-3">
                        <span>{{ __('Two Factor Code') }}</span>
                        <span class="relative mt-1.5 flex">
                            <input
                                class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="{{ __('Two Factor Code') }}" type="number" name="two_factor_code" />
                            <span
                                class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 transition-colors duration-200"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </span>
                        </span>
                    </label>
                    <div class="mt-3 text-center">
                        <x-primary-button class="mt-5">
                            {{ __('Verify Two Factor Code') }}
                        </x-primary-button>

                        <x-secondary-button class="mt-3">
                            <a href="{{ route('verify.resend') }}">
                                {{ __('Resend Code') }}
                            </a>
                        </x-secondary-button>
                    </div>

                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="mt-5">
                @csrf
                <div class="card mt-5 rounded-lg p-5 lg:p-7">
                    <button type="submit"
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 ms-2">
                        {{ __('Log Out') }}
                    </button>
                </div>
            </form>
        </div>
    </main>
</x-layouts.base-layout>
