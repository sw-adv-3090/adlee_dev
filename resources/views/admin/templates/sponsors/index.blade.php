<x-layouts.app-layout title="Sponsor Templates" is-sidebar-open="true">
    <div
        class="mt-6 flex flex-col items-center justify-between space-y-2 text-center sm:flex-row sm:space-y-0 sm:text-left">
        <div>
            <h3 class="text-xl font-semibold text-slate-700 dark:text-navy-100">
                Sponsors Templates
            </h3>
            <p class="mt-1 hidden sm:block">List of all sponsors templates</p>
        </div>
        <a href="{{ route('admin.templates.sponsors.create') }}"
            class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-indigo-50" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            <span> New Template </span>
        </a>
    </div>

    <div class="mt-4 sm:mt-5 lg:mt-6">
        @include('partials.alert')
        @livewire('admin.templates.sponsors')
    </div>
</x-layouts.app-layout>
