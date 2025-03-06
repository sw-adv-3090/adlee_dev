<x-layouts.app-layout title="Accounts Report" is-sidebar-open="false" main="false">
    <!-- Main Content Wrapper -->
    <main class="main-content w-full pb-8">
        <div
            class="mt-4 grid grid-cols-12 gap-4 px-[var(--margin-x)] transition-all duration-[.25s] sm:mt-5 sm:gap-5 lg:mt-6 lg:gap-6">
            @livewire('admin.reports.accounts')
        </div>
    </main>
</x-layouts.app-layout>
