<x-layouts.base-layout title="Forget Password">
    <main class="grid w-full grow grid-cols-1 place-items-center">
        <div class="w-full max-w-[26rem] p-4 sm:px-5">
            <div class="text-center">
                <x-app-logo />
                <div class="mt-4">
                    <h2 class="text-2xl font-semibold text-slate-600 dark:text-navy-100">
                        {{ __('Forget Password') }}
                    </h2>
                </div>
            </div>
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="card mt-5 rounded-lg p-5 lg:p-7">
                    <p class="text-slate-400 dark:text-navy-300">
                        {{ __('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                    </p>

                    @session('status')
                        <div class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ $value }}
                        </div>
                    @endsession

                    @session('error')
                        <div class="mt-2 font-medium text-sm text-red-600 dark:text-red-400">
                            {{ $value }}
                        </div>
                    @endsession

                    <x-validation-errors class="mt-2" />

                    <label class="block mt-3">
                        <span>{{ __('Email Address') }}</span>
                        <span class="relative mt-1.5 flex">
                            <input
                                class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="{{ __('Email Address') }}" type="email" name="email"
                                value="{{ old('email') }}" />
                            <span
                                class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 transition-colors duration-200"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>
                        </span>
                    </label>
                    <x-primary-button class="mt-5">
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </main>
</x-layouts.base-layout>
