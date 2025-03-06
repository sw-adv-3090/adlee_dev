<x-layouts.app-layout title="Verify EIN" is-header-blur="true">

    <div class="flex items-center space-x-4 py-5 lg:py-6">
        <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
            Verify Your EIN Number
        </h2>
    </div>

    <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
        <x-ad-space-owner-flow-steps :step3="true" />

        <div class="col-span-12 grid lg:col-span-9">
            <div class="card p-4 sm:p-5">
                @include('partials.alert')

                @if (!$canVerify)
                    <div class="alert flex space-x-2 rounded-lg border border-error px-4 py-4 text-error my-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <p> Ooops! You have tried 3 failed attempts to verify your EIN number. Please wait for 24 hours
                            to try again. You can retry after {{ $nextTryAt->format('M d, Y h:i:A') }}</p>
                    </div>
                @endif

                <p class="text-base font-medium text-slate-700 dark:text-navy-100">
                    Please verify your EIN number before further proceed.
                </p>
                <form action="{{ route('ad-space-owner.basic-settings.ein.verify') }}" method="post">
                    @csrf

                    <div class="mt-4 space-y-5">
                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Company name</span>
                            <span class="relative mt-1.5 flex">
                                <input
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="Your Company" type="text" name="company_name"
                                    value="{{ old('company_name', $companyName) }}" required />
                                <span
                                    class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                    <i class="fa-regular fa-building text-base"></i>
                                </span>
                            </span>
                        </label>
                        @error('company_name')
                            <span class="text-xs text-error">{{ $message }}</span>
                        @enderror
                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">IRS Given EIN Number</span>
                            <div class="relative mt-1.5 flex">
                                <input
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="Please enter your IRS Given EIN Number." type="text"
                                    x-input-mask="{numericOnly: true, blocks: [2, 7], delimiters: ['-']}"
                                    name="ein_number" value="{{ old('ein_number', $einNumber) }}" required />
                                <span
                                    class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                    <i class="fa-solid fa-map-pin text-base"></i>
                                </span>
                            </div>
                        </label>
                        @error('ein_number')
                            <span class="text-xs text-error">{{ $message }}</span>
                        @enderror

                        <label class="inline-flex items-center space-x-2">
                            <input
                                class="form-checkbox is-basic size-5 rounded border-slate-400/70 checked:bg-primary checked:border-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:bg-accent dark:checked:border-accent dark:hover:border-accent dark:focus:border-accent"
                                type="checkbox" name="consent_ein_number" @checked(old('consent_ein_number')) required />
                            <p>You agree that you are a authorized representative of the company to use this EIN.</p>
                        </label>
                        @error('consent_ein_number')
                            <span class="text-xs text-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-center mt-6">
                        <button type="submit"
                            class="btn space-x-2 bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-50 disabled:cursor-not-allowed"
                            {{ !$canVerify ? 'disabled' : '' }}>
                            <span>Verify EIN</span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</x-layouts.app-layout>
