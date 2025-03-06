<x-layouts.app-layout title="Bulk Activate Booklets" is-sidebar-open="true">
    <div
        class="flex flex-col items-center justify-between space-y-2 text-center sm:flex-row sm:space-y-0 sm:text-left mt-6">
        <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
            Bulk Activate Booklets
        </h2>

        <a href="{{ route('sponsors.booklets.index') }}"
            class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor"
                class="bi bi-chevron-left" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
            </svg>
            <span> Back </span>
        </a>
    </div>

    @include('partials.alert')

    <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6 mt-8" x-data="{ showModal: false, showCommemorationForm: '{{ $data['isCommemoration'] }}', language: '' }">
        <div class="col-span-12 grid lg:col-span-8">
            <div class="card p-4 sm:p-5">

                <div
                    class="is-scrollbar-hidden min-w-full overflow-x-auto rounded-lg border border-slate-200 dark:border-navy-500">
                    <table class="w-full text-left">
                        <tbody>
                            <tr>
                                <th
                                    class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                    Booklets
                                </th>
                                <td
                                    class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                    {{ $data['booklets'] }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                    Total Coupons
                                </th>
                                <td
                                    class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                    {{ $data['totalCoupons'] }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                    Activated Coupons
                                </th>
                                <td
                                    class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                    {{ $data['activated'] }}
                                </td>
                            </tr>
                            <tr>
                                <th
                                    class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                    Coupons Not Activated
                                </th>
                                <td
                                    class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                    {{ $data['notActivated'] }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-5 text-center">
                    <button type="button" @click="showModal = true"
                        class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-70 disabled:cursor-not-allowed"
                        @disabled($data['notActivated'] == 0)>
                        <span>Activate Booklets </span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-check-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                            <path
                                d="m10.97 4.97-.02.022-3.473 4.425-2.093-2.094a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05" />
                        </svg>
                    </button>

                    <template x-teleport="#x-teleport-target">
                        <div class="fixed inset-0 z-[100] flex flex-col items-center justify-center overflow-hidden px-4 py-6 sm:px-5"
                            x-show="showModal" role="dialog" @keydown.window.escape="showModal = false">
                            <div class="absolute inset-0 bg-slate-900/60 transition-opacity duration-300"
                                @click="showModal = false" x-show="showModal" x-transition:enter="ease-out"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                x-transition:leave="ease-in" x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0"></div>
                            <div class="relative w-full max-w-2xl origin-bottom rounded-lg bg-white pb-4 transition-all duration-300 dark:bg-navy-700"
                                x-show="showModal" x-transition:enter="easy-out"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="easy-in"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95">
                                <div
                                    class="flex justify-between rounded-t-lg bg-slate-200 px-4 py-3 dark:bg-navy-800 sm:px-5">
                                    <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                                        Activate Booklets Coupons
                                    </h3>
                                    <button @click="showModal = !showModal"
                                        class="btn -mr-1.5 size-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>

                                <div class="p-4 sm:p-5">
                                    <!-- show when sponsor select temlates to be used for commemoration puprose --->
                                    <div x-show="showCommemorationForm">
                                        <form action="{{ route('sponsors.booklets.bulk.activate') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="booklets"
                                                value="{{ json_encode($data['bookletIds']) }}">
                                            <div class="space-y-5">
                                                <!---- language --->
                                                <div class="">
                                                    <p class="pb-2">Please choose a language the ad space owner can
                                                        select for the sponsorship </p>
                                                    <div class="space-x-2">
                                                        <label class="inline-flex items-center space-x-2">
                                                            <input
                                                                class="form-radio is-basic size-5 rounded-full border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                                                name="language" type="radio" value="both"
                                                                x-on:change="language = $event.target.value" required />
                                                            <p>Both</p>
                                                        </label>
                                                        <label class="inline-flex items-center space-x-2">
                                                            <input
                                                                class="form-radio is-basic size-5 rounded-full border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                                                name="language" type="radio" value="english"
                                                                x-on:change="language = $event.target.value" required />
                                                            <p>English</p>
                                                        </label>
                                                        <label class="inline-flex items-center space-x-2">
                                                            <input
                                                                class="form-radio is-basic size-5 rounded-full border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                                                name="language" type="radio" value="hebrew"
                                                                x-on:change="language = $event.target.value" required />
                                                            <p>Hebrew</p>
                                                        </label>
                                                    </div>
                                                </div>

                                                <!---- title in english --->
                                                <label class="block"
                                                    x-show="language === 'both' || language === 'english'">
                                                    <span class="font-medium text-slate-600 dark:text-navy-100">Title
                                                        in
                                                        English</span>
                                                    <select
                                                        class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                                                        name="english_title"
                                                        :required="language === 'both' || language === 'english'">
                                                        <option value="">Choose Title in English</option>
                                                        <option value="Mr.">Mr.</option>
                                                        <option value="Mrs.">Mrs.</option>
                                                        <option value="Rabbi">Rabbi</option>
                                                    </select>
                                                </label>

                                                <!---- title in hebrew --->
                                                <label class="block"
                                                    x-show="language === 'both' || language ==='hebrew'">
                                                    <span class="font-medium text-slate-600 dark:text-navy-100">Title
                                                        in
                                                        Hebrew</span>
                                                    <select
                                                        class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                                                        name="hebrew_title"
                                                        x-bind:required="language === 'both' || language === 'hebrew'">
                                                        <option value="">Choose Title in Hebrew</option>
                                                        <option value="מוה"ר">מוה"ר</option>
                                                        <option value="מרת.">מרת.</option>
                                                        <option value="הרב">הרב</option>
                                                    </select>
                                                </label>

                                                <!---- purpose --->
                                                <div class="" x-show="language === 'both' || language === 'english'">
                                                    <p class="pb-2">Purpose of commemoration in English? </p>
                                                    <div class="space-x-2">
                                                        <label class="inline-flex items-center space-x-2">
                                                            <input
                                                                class="form-radio is-basic size-5 rounded-full border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                                                name="purposeEng" type="radio" value="In Memory Of"
                                                                x-bind:required="language === 'both' || language === 'english'" />
                                                            <p>In Memory Of</p>
                                                        </label>
                                                        <label class="inline-flex items-center space-x-2">
                                                            <input
                                                                class="form-radio is-basic size-5 rounded-full border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                                                name="purposeEng" type="radio" value="In Honor Of"
                                                                x-bind:required="language === 'both' || language === 'english'" />
                                                            <p>In Honor Of</p>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="" x-show="language === 'both' || language === 'hebrew'">
                                                    <p class="pb-2">Purpose of commemoration in Hebrew? </p>
                                                    <div class="space-x-2">
                                                        <label class="inline-flex items-center space-x-2">
                                                            <input
                                                                class="form-radio is-basic size-5 rounded-full border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                                                name="purposeHeb" type="radio" value="לזכר"
                                                                x-bind:required="language === 'both' || language === 'hebrew'" />
                                                            <p>לזכר</p>
                                                        </label>
                                                        <label class="inline-flex items-center space-x-2">
                                                            <input
                                                                class="form-radio is-basic size-5 rounded-full border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                                                name="purposeHeb" type="radio" value="לִכבוֹד"
                                                                x-bind:required="language === 'both' || language === 'hebrew'" />
                                                            <p>לִכבוֹד</p>
                                                        </label>
                                                    </div>
                                                </div>

                                                <!---- name in english --->
                                                <label class="block"
                                                    x-show="language === 'both' || language === 'english'">
                                                    <span class="font-medium text-slate-600 dark:text-navy-100">Name in
                                                        English</span>
                                                    <input
                                                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent "
                                                        placeholder="Name in English" type="text"
                                                        name="english_name"
                                                        :required="language === 'both' || language === 'english'" />
                                                </label>

                                                <!---- name in hebrew --->
                                                <label class="block"
                                                    x-show="language === 'both' || language ==='hebrew'">
                                                    <span class="font-medium text-slate-600 dark:text-navy-100">Name in
                                                        Hebrew (e.g. משה ב"ר חיים ע"ה)</span>
                                                    <input
                                                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent "
                                                        placeholder="Name in Hebrew" type="text"
                                                        name="hebrew_name"
                                                        :required="language === 'both' || language === 'hebrew'" />
                                                </label>
                                            </div>

                                            <div class="mt-5 text-center">
                                                <button type="submit"
                                                    class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-70 disabled:cursor-not-allowed">
                                                    <span>Activate Coupons </span>
                                                </button>
                                            </div>

                                        </form>
                                    </div>

                                    <!-- show when sponsor is not select temlates to be used for commemoration puprose --->
                                    <div x-show="!showCommemorationForm" class="text-center mt-3">
                                        <p class="text-sm font-normal text-slate-600 mb-4">Are you sure to activate
                                            booklets coupons?
                                            This action is irreversible. </p>
                                        <form action="{{ route('sponsors.booklets.bulk.activate') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="booklets"
                                                value="{{ json_encode($data['bookletIds']) }}">
                                            <button type="submit"
                                                class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-70 disabled:cursor-not-allowed">
                                                <span>Activate Coupons</span>
                                            </button>
                                        </form>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </template>

                </div>
            </div>
        </div>
    </div>

</x-layouts.app-layout>
