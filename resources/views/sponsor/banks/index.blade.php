<x-layouts.app-layout title="ACH Bank Accounts" is-sidebar-open="true">
    <div
        class="flex flex-col items-center justify-between space-y-2 text-center sm:flex-row sm:space-y-0 sm:text-left mt-6">
        <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
            ACH Bank Accounts
        </h2>

        <a href="{{ route('sponsors.banks.create') }}"
            class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-indigo-50" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            <span> Add New </span>
        </a>
    </div>

    @include('partials.alert')

    {{-- <p class="text-info mt-6">
       {{ __("Stripe will initiate two test micro deposits in your account when you add a bank account. Please enter that amounts for verification. Usually it takes 1-2 business days to deposit in your account. The amounts must be
        entered in cents.")}}
    </p> --}}

    @livewire('sponsor.bank-accounts')

</x-layouts.app-layout>
