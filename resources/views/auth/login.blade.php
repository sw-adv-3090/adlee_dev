<x-layouts.base-layout title="Login">
    <main class="grid w-full grow grid-cols-1 place-items-center">
        <div class="w-full max-w-[30rem] p-4 sm:px-5">
            <div class="text-center">
                <x-app-logo />
                <div class="mt-4">
                    <h2 class="text-2xl font-semibold text-slate-600 dark:text-navy-100">
                        {{ __('Welcome Back') }}
                    </h2>
                    <p class="text-slate-400 dark:text-navy-300">
                        {{ __('Please sign in to continue') }}
                    </p>
                </div>
            </div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="card mt-5 rounded-lg p-5 lg:p-7">
                    @include('partials.alert')
                    <x-validation-errors class="mb-4" />

                    <label class="block">
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
                    <label class="mt-4 block">
                        <span>{{ __('Password') }}</span>
                        <span class="relative mt-1.5 flex">
                            <input
                                class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="{{ __('Enter Password') }}" type="password" name="password" />
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
                    <div class="mt-4 flex items-center justify-between space-x-2">
                        <label for="remember_me" class="inline-flex items-center space-x-2">
                            <input
                                class="form-checkbox is-basic size-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                type="checkbox" name="remember" id="remember_me" />
                            <span class="line-clamp-1">{{ __('Remember me') }}</span>
                        </label>
                        <a href="{{ route('password.request') }}"
                            class="text-xs text-slate-400 transition-colors line-clamp-1 hover:text-slate-800 focus:text-slate-800 dark:text-navy-300 dark:hover:text-navy-100 dark:focus:text-navy-100">{{ __('Forgot your password?') }}</a>
                    </div>
                    <x-primary-button class="mt-5">
                        {{ __('Log in') }}
                    </x-primary-button>

                    <div class="mt-4 text-center text-xs+">
                        <p class="line-clamp-1">
                            <span>{{ __("Don't have a Sponsor Account?") }}</span>

                            <a class="text-primary transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent"
                                href="{{ route('register') }}">{{ __('Create account') }}</a>
                        </p>
                        <p class="line-clamp-1 pt-2">
                            <span>{{ __("Don't have an Ad Space Owner account?") }}</span>

                            <a class="text-primary transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent"
                                href="{{ route('register', ['type' => 'ad-space-owner']) }}">{{ __('Create account') }}</a>
                        </p>
                        <p class="line-clamp-1 pt-2">
                            <span>{{ __("Don't have an Designer account?") }}</span>

                            <a class="text-primary transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent"
                                href="{{ route('register', ['type' => 'designer']) }}">{{ __('Create account') }}</a>
                        </p>
                    </div>
                    <x-social-login />
                </div>
            </form>

            <x-terms-privacy />
        </div>
    </main>
</x-layouts.base-layout>
