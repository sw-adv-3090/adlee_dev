<x-layouts.app-layout title="Ad Space Owners" is-sidebar-open="true">
    <div
        class="flex flex-col items-center justify-between space-y-2 text-center sm:flex-row sm:space-y-0 sm:text-left mt-6">
        <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
            Ad Space Owners
        </h2>
    </div>

    @livewire('admin.users', ['type' => 'ad-space-owners'])
</x-layouts.app-layout>
