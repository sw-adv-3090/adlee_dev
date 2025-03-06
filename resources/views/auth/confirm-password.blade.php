<x-layouts.base-layout title="Confirm Your Password">
    <main class="grid w-full grow grid-cols-1 place-items-center">
        <div class="w-full max-w-[26rem] p-4 sm:px-5">
            <div class="text-center">
                <x-app-logo />
                <div class="mt-4">
                    <h2 class="text-2xl font-semibold text-slate-600 dark:text-navy-100">
                        {{ __('Confirm Your Password') }}
                    </h2>
                </div>
            </div>
            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf
                <p class="text-slate-400 dark:text-navy-300 mb-3">
                    {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                </p>

                <div class="card mt-5 rounded-lg p-5 lg:p-7">
                    <x-validation-errors class="mb-4" />

                    <label class="block">
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
                    <x-primary-button class="mt-5">
                        {{ __('Confirm') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </main>
</x-layouts.base-layout>
