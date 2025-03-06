<x-layouts.app-layout title="Booklets Print Requests" is-sidebar-open="true">
    <div
        class="mt-6 flex flex-col items-center justify-between space-y-2 text-center sm:flex-row sm:space-y-0 sm:text-left">
        <div class="flex items-center space-x-1">
            <h2 class="text-xl font-medium text-slate-700 line-clamp-1 dark:text-navy-50">
                Booklets Print Requests
            </h2>
        </div>
    </div>

    @livewire('admin.jobs.booklet-prints')
</x-layouts.app-layout>
