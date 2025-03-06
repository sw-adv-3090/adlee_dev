<x-layouts.base-layout title="Verify Email Address">
    <main class="grid w-full grow grid-cols-1 place-items-center">
        <div class="w-full max-w-[26rem] p-4 sm:px-5">
            <div class="text-center">
                <x-app-logo />
                <div class="mt-4">
                    <h2 class="text-2xl font-semibold text-slate-600 dark:text-navy-100">
                        {{ __('Verify Email Address') }}
                    </h2>
                </div>
            </div>
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div class="card mt-5 rounded-lg p-5 lg:p-7">
                    <p class="text-slate-400 dark:text-navy-300">
                        {{ __('Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                    </p>

                    @if (session('status') == 'verification-link-sent')
                        <div class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to the email address you provided in your profile settings.') }}
                        </div>
                    @endif

                    <x-validation-errors class="mt-2" />

                    <x-primary-button class="mt-5">
                        {{ __('Resend Verification Email') }}
                    </x-primary-button>
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
