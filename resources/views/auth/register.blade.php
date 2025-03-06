<x-layouts.base-layout title="Sign Up">
    @php
    $role_id = \App\Enums\UserRole::Sponsor->value;
    if (request()->has('type') && request()->type === 'ad-space-owner') {
    $role_id = \App\Enums\UserRole::AdSpaceOwner->value;
    }
    if (request()->has('type') && request()->type === 'designer') {
    $role_id = \App\Enums\UserRole::Designer->value;
    }
    @endphp
    <main class="grid w-full grow grid-cols-1 place-items-center">
        <div class="w-full max-w-[26rem] p-4 sm:px-5">
            <div class="text-center">
                <x-app-logo />
                <div class="mt-4">
                    <h2 class="text-2xl font-semibold text-slate-600 dark:text-navy-100">
                        {{ __('Welcome To ') . config('app.name') }}
                    </h2>
                    <p class="text-slate-400 dark:text-navy-300">
                        {{ __('Please sign up to continue') }}
                    </p>
                </div>
            </div>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <input type="hidden" name="role_id" value="{{ $role_id }}">
                <div class="card mt-5 rounded-lg p-5 lg:p-7">
                    <label class="relative flex">
                        <input
                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                            placeholder="{{ __('Name') }}" type="text" name="name"
                            value="{{ old('name') }}" />
                        <span
                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 transition-colors duration-200"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </span>
                    </label>
                    @if ($errors->has('name'))
                    <span class="text-red-600 text-sm">{{ $errors->first('name') }}</span>
                    @endif
                    <label class="relative mt-4 flex">
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
                    </label>
                    @if ($errors->has('email'))
                    <span class="text-red-600 text-sm">{{ $errors->first('email') }}</span>
                    @endif
                    <label class="relative mt-4 flex">
                        <input
                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                            placeholder="Password" type="password" name="password" />
                        <span
                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 transition-colors duration-200"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
                    </label>
                    <label class="relative mt-4 flex">
                        <input
                            class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                            placeholder="Repeat Password" type="password" name="password_confirmation" />
                        <span
                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 transition-colors duration-200"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
                    </label>
                    @if ($errors->has('password'))
                    <span class="text-red-600 text-sm">{{ $errors->first('password') }}</span>
                    @endif
                    @if ($errors->has('password_confirmation'))
                    <span class="text-red-600 text-sm">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                    <div class="mt-4 flex items-center space-x-2">
                        <input id="terms-verify"
                            class="form-checkbox is-basic size-5 rounded border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                            type="checkbox" required />
                        <label for="terms-verify" class="line-clamp-1">
                            {{ __('I agree with') }}
                            <a href="#" class="text-slate-400 hover:underline dark:text-navy-300">
                                {{ __('privacy policy') }}
                            </a>
                        </label>
                    </div>

                    <x-primary-button class="mt-5">
                        {{ __('Sign Up') }}
                    </x-primary-button>
                    <div class="mt-4 text-center text-xs+">
                        <p class="line-clamp-1">
                            <span>{{ __('Already have an account?') }} </span>
                            <a class="text-primary transition-colors hover:text-primary-focus dark:text-accent-light dark:hover:text-accent"
                                href="{{ route('login') }}">{{ __('Login') }}</a>
                        </p>
                    </div>
                    <x-social-login page="register" />
                </div>
            </form>

        </div>
    </main>
</x-layouts.base-layout>