<x-layouts.app-layout title="Stripe Onboarding" is-header-blur="true">

    <div class="flex items-center space-x-4 py-5 lg:py-6">
        <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl capitalize">
            Stripe Onboarding
        </h2>
    </div>

    <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
        <x-ad-space-owner-flow-steps :step3="4" />

        <div class="col-span-12 grid lg:col-span-9">
            <div class="card p-4 sm:p-5">
                @include('partials.alert')

                <p class="text-base font-medium text-slate-700 dark:text-navy-100">
                    Connect your bank account with stripe to receive payouts
                </p>
                <p class="text-sm font-normal text-slate-700 dark:text-navy-100 mt-2">
                    {{ __('You will be redirected to stripe hosted onboarding page where stripe will ask required information from you including your bank accounts that will be used to send payout to you.') }}
                </p>
                <form action="{{ route('ad-space-owner.basic-settings.onboarding.store') }}" method="post">
                    @csrf

                    <div class="mt-4 space-y-5">
                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Country</span>
                            <select
                                class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                                name="country" required>
                                <option value="">Choose Country</option>
                                @foreach (countries() as $country)
                                    <option value="{{ $country->code_2 }}" @selected(old('country', $adSpaceOwner->country) === $country->code_2)>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                        <span
                            class="text-blue-400 text-xs">{{ __('The country in which the account holder resides, or in which the business is legally established. For example, if you are in the United States and the business for which you’re creating an account is legally represented in Canada, you would use Canada as the country for the account being created.') }}</span>
                        @error('country')
                            <span class="text-xs text-error">{{ $message }}</span>
                        @enderror

                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Business Type</span>
                            <select
                                class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                                name="business_type" required>
                                <option value="">Choose Business Type</option>
                                @foreach (busines_types() as $value => $type)
                                    <option value="{{ $value }}" @selected(old('business_type', $adSpaceOwner->business_type) === $value)>{{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                        @error('business_type')
                            <span class="text-xs text-error">{{ $message }}</span>
                        @enderror

                        {{-- <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Company name</span>
                            <span class="relative mt-1.5 flex">
                                <input
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="Your Company" type="text" name="company_name"
                                    value="{{ old('company_name') }}" required />
                                <span
                                    class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                    <i class="fa-regular fa-building text-base"></i>
                                </span>
                            </span>
                        </label>
                        @error('company_name')
                            <span class="text-xs text-error">{{ $message }}</span>
                        @enderror --}}
                    </div>
                    <div class="flex justify-center mt-6">
                        <button type="submit"
                            class="btn space-x-2 bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-50 disabled:cursor-not-allowed">
                            <span>Connect With Stripe</span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</x-layouts.app-layout>
