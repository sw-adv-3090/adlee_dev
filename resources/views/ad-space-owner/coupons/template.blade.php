<x-layouts.app-layout title="Select Template" is-sidebar-open="true">
    <div
        class="flex flex-col items-center justify-between space-y-2 text-center sm:flex-row sm:space-y-0 sm:text-left mt-6">
        <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
            Select Template
        </h2>

        <a href="{{ route('ad-space-owner.coupons.index', ['coupon_id' => $coupon->uuid]) }}"
            class="btn space-x-2 bg-error font-medium text-white shadow-lg shadow-error/50 hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90 dark:bg-error dark:shadow-error/50 dark:hover:bg-error-focus dark:focus:bg-error-focus dark:active:bg-error/90">
            <span> Cancel </span>

            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle"
                viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                <path
                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
            </svg>
        </a>
    </div>

    <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">

        <div class="col-span-12 grid">
            @livewire('ad-space-owner.coupons.template', ['coupon' => $coupon])
        </div>
    </div>
</x-layouts.app-layout>
