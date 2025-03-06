<x-layouts.app-layout title="Booklets" is-sidebar-open="true">
    <div x-data="{ showModal: false }">
        <div
            class="flex flex-col items-center justify-between space-y-2 text-center sm:flex-row sm:space-y-0 sm:text-left mt-6">
            <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
                Booklets Overview
            </h2>

            {{-- <a href="{{ route('sponsors.booklets.create') }}"
                class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-indigo-50" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span> New Booklet </span>
            </a> --}}
            <button type="button" @click="showModal = true"
                class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-indigo-50" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span> New Booklet </span>
            </button>
        </div>

        <template x-teleport="#x-teleport-target">
            <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
                <div class="absolute inset-0 bg-slate-900/60 transition-opacity duration-300" @click="showModal = false"
                    x-show="showModal" x-transition:enter="ease-out" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="ease-in"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
                <div class="relative w-full max-w-2xl origin-bottom rounded-lg bg-white pb-4 transition-all duration-300 dark:bg-navy-700"
                    x-show="showModal" x-transition:enter="easy-out" x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="easy-in"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                    <div class="flex justify-between rounded-t-lg bg-slate-200 px-4 py-3 dark:bg-navy-800 sm:px-5">
                        <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">

                        </h3>
                        <button @click="showModal = false"
                            class="btn -mr-1.5 size-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25 z-[9999]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12">
                                </path>
                            </svg>
                        </button>
                    </div>

                    <div class="p-4 sm:p-5">
                        <div class="text-center">
                            <p class="text-sm font-normal text-slate-600 mb-4">
                                @if ($data['isOnBasicPlan'])
                                    {{ __('You are on the basic plan which does not include any free booklet prints. In order to print and ship this booklet to you that you are creating, you will be charged $' . $data['bookletFee'] . ' OR you may upgrade your plan which includes a couple for free each month.') }}
                                @elseif ($data['bookletRemaining'] == 0)
                                    {{ __("You are left 0 free booklet print for this month. In order to print and ship this booklet to you that you are creating, you will be charged for $" . $data['bookletFee'] . '.') }}
                                @else
                                {{ __("You have no more free booklets left this month. In order to proceed with printing your booklet and shipping it to you, you will be charged $" . $data['bookletFee'] . '.') }}
                                   <?php /* {{ __('You are left ' . $data['bookletRemaining'] . " free booklet print for this month. In order to print and ship this booklet to you that you are creating, you will be charged for $0") }} */ ?>
                                @endif
                            </p>



                            <div class="flex items-center justify-center gap-3 flex-wrap mt-10">
                                @if ($data['isOnBasicPlan'])
                                    <a href="{{ route('sponsors.plans.index') }}"
                                        class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-70 disabled:cursor-not-allowed">
                                        <span>Upgrade Plan</span>
                                    </a>
                                @endif
                                <a href="{{ route('sponsors.booklets.create') }}"
                                    class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-70 disabled:cursor-not-allowed">
                                    <span>Continue </span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" fill="currentColor"
                                        class="bi bi-chevron-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708" />
                                    </svg>
                                </a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </template>

        @include('partials.alert')

        @livewire('sponsor.booklets.index', ['data' => $data])
        <form action="" method="post" id="printBooklet">
            @csrf
        </form>

        @include('sponsor.booklets.js')
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('pirnt-booklet', (event) => {
                    const form = document.getElementById('printBooklet');
                    form.action = event.route;
                    form.submit();
                });
            });
        </script>
    </div>
</x-layouts.app-layout>
