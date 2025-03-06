<x-layouts.app-layout title="Sign Agreement" is-sidebar-open="true">
    <div
        class="flex flex-col items-center justify-between space-y-2 text-center sm:flex-row sm:space-y-0 sm:text-left mt-6">
        <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
            Sign Agreement
        </h2>

        <a href="{{ route('ad-space-owner.coupons.index', ['coupon_id' => $coupon->uuid]) }}"
            class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                class="bi bi-chevron-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
            </svg>
            <span> Continue </span>
        </a>

    </div>

    @include('partials.alert')

    <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6 mt-10">

        <div class="col-span-12">
            <iframe src="{{ $link }}" frameborder="0" width="100%" height="500"></iframe>
        </div>
    </div>
</x-layouts.app-layout>
