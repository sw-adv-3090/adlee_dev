<x-layouts.app-layout title="Bank Account Verification" is-sidebar-open="true">
    <div
        class="flex flex-col items-center justify-between space-y-2 text-center sm:flex-row sm:space-y-0 sm:text-left mt-6">
        <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
            Bank Account Verification
        </h2>

        <a href="{{ route('sponsors.banks.index') }}"
            class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                class="bi bi-chevron-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
            </svg>
            <span> Back </span>
        </a>
    </div>

    @include('partials.alert')


    <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6 mt-8">
        <div class="col-span-12 grid lg:col-span-9">

            <div class="card p-4 sm:p-5">
                <p class="text-info">
                    Stripe has initiated two test micro deposits in your account. Please enter that amounts for
                    verification. Usually it takes 1-2 business days to deposit in your account. The amounts must be
                    entered in cents.
                </p>
                @if (!is_null($account->verified_at))
                    <div class="alert flex space-x-2 rounded-lg border border-error px-4 py-4 text-error my-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <p> Your account is already verified.</p>
                    </div>
                @endif

                <form action="{{ route('sponsors.banks.verification.verify', $account) }}" method="post">
                    @csrf
                    <div class="mt-4 space-y-5">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <label class="block">
                                <span class="font-medium text-slate-600 dark:text-navy-100">Amount 1 (In Cents)</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent disabled:opacity-50"
                                        placeholder="Amount 1 (In Cents)" type="number" name="amount1"
                                        value="{{ old('amount1') }}" required @disabled(!is_null($account->verified_at)) />
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-solid fa-user text-base"></i>
                                    </span>
                                </span>
                            </label>
                            @error('amount1')
                                <span class="text-xs text-error">{{ $message }}</span>
                            @enderror
                            <label class="block">
                                <span class="font-medium text-slate-600 dark:text-navy-100">Amount 2 (In Cents)</span>
                                <span class="relative mt-1.5 flex">
                                    <input
                                        class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent disabled:opacity-50"
                                        placeholder="Amount 2 (In Cents)" type="number" name="amount2"
                                        value="{{ old('amount2') }}" required @disabled(!is_null($account->verified_at)) />
                                    <span
                                        class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                        <i class="fa-solid fa-map-marked-alt text-base"></i>
                                    </span>
                                </span>
                            </label>
                            @error('amount2')
                                <span class="text-xs text-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-center mt-6">
                        <button type="submit"
                            class="btn space-x-2 bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-50 disabled:cursor-not-allowed"
                            @disabled(!is_null($account->verified_at))>
                            <span>Verify Bank Account</span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</x-layouts.app-layout>
