<x-layouts.app-layout title="Select Template" is-header-blur="true">

    <div class="flex justify-between items-center py-5 lg:py-6">
        <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
            Select Template
        </h2>
    </div>

    <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
        <x-sponsor-flow-steps :step3="true" :step4="true" :step5="true" />

        <div class="col-span-12 grid lg:col-span-9">
            @livewire('sponsor.templates')
        </div>
    </div>

</x-layouts.app-layout>
