<x-layouts.app-layout title="Update Password" is-header-blur="true">
    <x-breadcrumbs title="Password" menu="Profile" />

    <div class="flex flex-col lg:flex-row gap-4 sm:gap-5 lg:gap-6">
        @include('profile.sidebar')

        <div class="w-full lg:w-[67%]">
            <div class="card">

                <form action="{{ route('profile.account.update') }}" method="post">
                    @csrf
                    <div
                        class="flex flex-col items-center space-y-4 border-b border-slate-200 p-4 dark:border-navy-500 sm:flex-row sm:justify-between sm:space-y-0 sm:px-5">
                        <h2 class="text-lg font-medium tracking-wide text-slate-700 dark:text-navy-100">
                            {{ __('Update Password') }}
                        </h2>
                        <div class="flex justify-center space-x-2">
                            <x-primary-button class="min-w-[7rem] rounded-full">
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </div>
                    <div class="p-4 sm:p-5">
                        @session('status')
                            <div class="mt-2 mb-5 font-medium text-sm text-green-600 dark:text-green-400">
                                {{ $value }}
                            </div>
                        @endsession
                        <x-validation-errors class="mb-4" />

                        <p class="text-slate-700 dark:text-navy-300 mb-4">
                            {{ __('Ensure your account is using a long, random password to stay secure.') }}</p>

                        <label class="block">
                            <span>{{ __('Current Password') }}</span>
                            <span class="relative mt-1.5 flex">
                                <input
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="{{ __('Current Password') }}" type="password"
                                    name="current_password" />
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

                        <label class="mt-4 block">
                            <span>{{ __('New Password') }}</span>
                            <span class="relative mt-1.5 flex">
                                <input
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="{{ __('New Password') }}" type="password" name="password" />
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

                        <label class="mt-4 block">
                            <span>{{ __('Confirm Password') }}</span>
                            <span class="relative mt-1.5 flex">
                                <input
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:z-10 hover:border-slate-400 focus:z-10 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="{{ __('Confirm Password') }}" type="password"
                                    name="password_confirmation" />
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
                </form>

            </div>
        </div>
    </div>
</x-layouts.app-layout>
