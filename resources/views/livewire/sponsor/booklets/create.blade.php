<div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6 mt-8">
    {{-- lg:place-items-center --}}
    <div class="col-span-12 grid lg:col-span-3">
        @php
        $normalIcon = 'bg-slate-200 text-slate-500 dark:bg-navy-500 dark:text-navy-100';
        $activeIcon = 'bg-primary text-white dark:bg-accent';
        $activeTitle = 'text-primary dark:text-accent-light';
        @endphp
        <div>
            <ol class="steps is-vertical line-space [--size:2.75rem] [--line:.5rem]">
                <li class="step space-x-4 pb-12 before:bg-slate-200 dark:before:bg-navy-500">
                    <div class="step-header mask is-hexagon {{ $step === 'info' ? $activeIcon : $normalIcon }}">
                        <i class="fa-solid fa-gear text-base"></i>
                    </div>
                    <div class="text-left">
                        <p class="text-xs text-slate-400 dark:text-navy-300">
                            Step 1
                        </p>
                        <h3 class="text-base font-medium {{ $step === 'info' ? $activeTitle : '' }}">Basic Info</h3>
                    </div>
                </li>

                <li class="step space-x-4 pb-12 before:bg-slate-200 dark:before:bg-navy-500">
                    <div class="step-header mask is-hexagon {{ $step === 'template' ? $activeIcon : $normalIcon }}">
                        <i class="fa-solid fa-money-bill-wave text-base"></i>
                    </div>
                    <div class="text-left">
                        <p class="text-xs text-slate-400 dark:text-navy-300">
                            Step 2
                        </p>
                        <h3 class="text-base font-medium {{ $step === 'template' ? $activeTitle : '' }}">Select Template
                        </h3>
                    </div>
                </li>
                <li class="step space-x-4 pb-12 before:bg-slate-200 dark:before:bg-navy-500">
                    <div class="step-header mask is-hexagon {{ $step === 'printing' ? $activeIcon : $normalIcon }}">
                        <i class="fa-solid fa-money-bill-wave text-base"></i>
                    </div>
                    <div class="text-left">
                        <p class="text-xs text-slate-400 dark:text-navy-300">
                            Step 3
                        </p>
                        <h3 class="text-base font-medium {{ $step === 'printing' ? $activeTitle : '' }}">Print Booklet
                        </h3>
                    </div>
                </li>
                <li class="step space-x-4 pb-12 before:bg-slate-200 dark:before:bg-navy-500">
                    <div class="step-header mask is-hexagon {{ $step === 'activate' ? $activeIcon : $normalIcon }}">
                        <i class="fa-solid fa-money-bill-wave text-base"></i>
                    </div>
                    <div class="text-left">
                        <p class="text-xs text-slate-400 dark:text-navy-300">
                            Step 4
                        </p>
                        <h3 class="text-base font-medium {{ $step === 'activate' ? $activeTitle : '' }}">Activate Booklet
                        </h3>
                    </div>
                </li>
                
            </ol>
        </div>
    </div>

    <div class="col-span-12 grid lg:col-span-9">
        <div class="card p-4 sm:p-5">
            <div class="alert flex overflow-hidden rounded-lg border border-info text-info mb-5">
                <div class="bg-info p-3 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="px-4 py-3 sm:px-5">Please be sure with all the provided info. You can't edit or delete the
                    booklet once its created.</div>
            </div>
            <div wire:loading wire:target="save">
                <div
                    class="alert flex overflow-hidden rounded-lg bg-info/10 text-info dark:bg-info-light/15 dark:text-info-light mb-5">
                    <div class="w-1.5 bg-info"></div>
                    <div class="p-4">Please wait. We are creating booklet with {{ $coupons }} coupons. It may
                        take some time. Pease don't referesh the page or press back button while we are working.</div>
                </div>
            </div>

            <form wire:submit="save">
                <div class="space-y-5">
                    @if ($step === 'info')
                    {{-- booklet title --}}
                    <label class="block">
                        <span class="font-medium text-slate-600 dark:text-navy-100">Booklet Title</span>
                        <input
                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent "
                            placeholder="Enter booklet title for reference" type="text" wire:model="title"
                            value="{{ old('title') }}" required />
                    </label>
                    @error('title')
                    <span class="text-xs text-error">{{ $message }}</span>
                    @enderror

                    {{-- booklet amount --}}
                    <label class="block">
                        <span class="font-medium text-slate-600 dark:text-navy-100">Booklet Amount in Dollars,
                            minimum 50</span>
                        <input
                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent "
                            placeholder="Enter booklet dollar amount" type="text" wire:model="amount"
                            value="{{ old('amount') }}" />
                    </label>
                    @error('amount')
                    <span class="text-xs text-error">{{ $message }}</span>
                    @enderror

                    {{-- confirm booklet amount --}}
                    <label class="block">
                        <span class="font-medium text-slate-600 dark:text-navy-100">Confirm Booklet Amount in
                            Dollars</span>
                        <input
                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent "
                            placeholder="Confirm booklet dollar amount" type="text" wire:model="confirm_amount"
                            value="{{ old('confirm_amount') }}" required />
                    </label>
                    @error('confirm_amount')
                    <span class="text-xs text-error">{{ $message }}</span>
                    @enderror

                    {{-- booklet coupon count --}}
                    {{-- <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Booklet Coupons Count</span>
                            <p class="my-1.5">Please write number of coupons to be in this booklet</p>
                            <input
                                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent "
                                placeholder="Booklet coupons count" type="number" wire:model="coupons"
                                value="{{ old('coupons') }}" step="{{ $couponLimit }}" required />
                    </label>
                    @error('coupons')
                    <span class="text-xs text-error">{{ $message }}</span>
                    @enderror --}}

                    {{-- booklet payout deadline --}}
                    <label class="block">
                        <span class="font-medium text-slate-600 dark:text-navy-100">Booklet Payout Deadline</span>
                        <p class="my-1.5">When any of coupon from booklet will be activated, the coupon will be
                            payout to Bulletin Board Owner after the choosen days.</p>
                        <select
                            class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                            wire:model="payout_deadline" required>
                            <option value="">Choose Duration</option>
                            @foreach (coupon_payouts_durations(true) as $duration => $value)
                            <option value="{{ $value }}" @selected(old('payout_deadline')==$value)>
                                {{ $duration }}
                            </option>
                            @endforeach
                        </select>
                    </label>
                    @error('payout_deadline')
                    <span class="text-xs text-error">{{ $message }}</span>
                    @enderror
                    @elseif($step === 'activate')
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
                                                    Total Coupons
                                                </th>
                                                <td
                                                    class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                                    {{ $data['total'] }}
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
                                        @disabled($data['notActivated']==0)>
                                        <span>Activate Booklet </span>
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
                                                        Activate Coupons
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
                                                        <form wire:submit.prevent="activateBooklet">
                                                            @csrf
                                                            <div class="space-y-5">
                                                                <!-- Language -->
                                                                <div>
                                                                    <p class="pb-2">Please choose a language the ad space owner can select for the sponsorship:</p>
                                                                    <div class="space-x-2">
                                                                        <label class="inline-flex items-center space-x-2">
                                                                            <input
                                                                                wire:model="bookletLanguage"
                                                                                name="bookletLanguage"
                                                                                class="form-radio is-basic size-5 rounded-full border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                                                                type="radio"
                                                                                value="both"
                                                                                required />
                                                                            <p>Both</p>
                                                                        </label>
                                                                        <label class="inline-flex items-center space-x-2">
                                                                            <input
                                                                                wire:model="bookletLanguage"
                                                                                name="bookletLanguage"
                                                                                class="form-radio is-basic size-5 rounded-full border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                                                                type="radio"
                                                                                value="english"
                                                                                required />
                                                                            <p>English</p>
                                                                        </label>
                                                                        <label class="inline-flex items-center space-x-2">
                                                                            <input
                                                                                wire:model="bookletLanguage"
                                                                                name="bookletLanguage"
                                                                                class="form-radio is-basic size-5 rounded-full border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                                                                type="radio"
                                                                                value="hebrew"
                                                                                required />
                                                                            <p>Hebrew</p>
                                                                        </label>
                                                                    </div>
                                                                </div>

                                                                <!-- Purpose -->
                                                                <div x-show="$wire.bookletLanguage === 'both' || $wire.bookletLanguage === 'english'">
                                                                    <p class="pb-2">Purpose of commemoration in English:</p>
                                                                    <div class="space-x-2">
                                                                        <label class="inline-flex items-center space-x-2">
                                                                            <input
                                                                                wire:model="purpose_eng"
                                                                                class="form-radio is-basic size-5 rounded-full border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                                                                type="radio"
                                                                                value="In Memory Of"
                                                                                x-bind:required="language === 'both' || language === 'english'" />
                                                                            <p>In Memory Of</p>
                                                                        </label>
                                                                        <label class="inline-flex items-center space-x-2">
                                                                            <input
                                                                                wire:model="purpose_eng"
                                                                                class="form-radio is-basic size-5 rounded-full border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                                                                type="radio"
                                                                                value="In Honor Of"
                                                                                x-bind:required="bookletLanguage === 'both' || bookletLanguage === 'english'" />
                                                                            <p>In Honor Of</p>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div x-show="$wire.bookletLanguage === 'both' || $wire.bookletLanguage === 'hebrew'">
                                                                    <p class="pb-2">Purpose of commemoration in Hebrew:</p>
                                                                    <div class="space-x-2">
                                                                        <label class="inline-flex items-center space-x-2">
                                                                            <input
                                                                                wire:model="purpose_heb"
                                                                                class="form-radio is-basic size-5 rounded-full border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                                                                type="radio"
                                                                                value="לזכר"
                                                                                x-bind:required="language === 'both' || language === 'hebrew'" />
                                                                            <p>לזכר</p>
                                                                        </label>
                                                                        <label class="inline-flex items-center space-x-2">
                                                                            <input
                                                                                wire:model="purpose_heb"
                                                                                class="form-radio is-basic size-5 rounded-full border-slate-400/70 checked:border-primary checked:bg-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:border-accent dark:checked:bg-accent dark:hover:border-accent dark:focus:border-accent"
                                                                                type="radio"
                                                                                value="לִכבוֹד"
                                                                                x-bind:required="language === 'both' || language === 'hebrew'" />
                                                                            <p>לִכבוֹד</p>
                                                                        </label>
                                                                    </div>
                                                                </div>

                                                                <!-- Title in English -->
                                                                <label class="block" x-show="$wire.bookletLanguage === 'both' || $wire.bookletLanguage === 'english'">
                                                                    <span class="font-medium text-slate-600 dark:text-navy-100">Title in English</span>
                                                                    <select
                                                                        wire:model="english_title"
                                                                        class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                                                                        required>
                                                                        <option value="">Choose Title in English</option>
                                                                        <option value="Mr.">Mr.</option>
                                                                        <option value="Mrs.">Mrs.</option>
                                                                        <option value="Rabbi">Rabbi</option>
                                                                    </select>
                                                                </label>

                                                                <!-- Title in Hebrew -->
                                                                <label class="block" x-show="$wire.bookletLanguage === 'both' || $wire.bookletLanguage === 'hebrew'">
                                                                    <span class="font-medium text-slate-600 dark:text-navy-100">Title in Hebrew</span>
                                                                    <select
                                                                        wire:model="hebrew_title"
                                                                        class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                                                                        x-bind:required="$wire.bookletLanguage === 'both' || $wire.bookletLanguage === 'hebrew'">
                                                                        <option value="">Choose Title in Hebrew</option>
                                                                        <option value="מוה" ר">מוה"ר</option>
                                                                        <option value="מרת.">מרת.</option>
                                                                        <option value="הרב">הרב</option>
                                                                    </select>
                                                                </label>

                                                                <!-- Name in English -->
                                                                <label class="block" x-show="$wire.bookletLanguage === 'both' || $wire.bookletLanguage === 'english'">
                                                                    <span class="font-medium text-slate-600 dark:text-navy-100">Name in English</span>
                                                                    <input
                                                                        wire:model="english_name"
                                                                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                                        type="text"
                                                                        placeholder="Name in English"
                                                                        x-bind:required="$wire.bookletLanguage === 'both' || $wire.bookletLanguage === 'english'" />
                                                                </label>

                                                                <!-- Name in Hebrew -->
                                                                <label class="block" x-show="$wire.bookletLanguage === 'both' || $wire.bookletLanguage === 'hebrew'">
                                                                    <span class="font-medium text-slate-600 dark:text-navy-100">Name in Hebrew (e.g. משה ב"ר חיים ע"ה)</span>
                                                                    <input
                                                                        wire:model="hebrew_name"
                                                                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                                                        type="text"
                                                                        placeholder="Name in Hebrew"
                                                                        x-bind:required="$wire.bookletLanguage === 'both' || $wire.bookletLanguage === 'hebrew'" />
                                                                </label>
                                                            </div>

                                                            <div class="mt-5 text-center">
                                                                <button
                                                                    type="submit"
                                                                    class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-70 disabled:cursor-not-allowed">
                                                                    <span>Activate Coupons</span>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>

                                                    <!-- show when sponsor is not select temlates to be used for commemoration puprose --->
                                                    <div x-show="!showCommemorationForm" class="text-center mt-3">
                                                        <p class="text-sm font-normal text-slate-600 mb-4">Are you sure to activate
                                                            coupons?
                                                            This action is irreversible. </p>
                                                        <form action="{{ route('sponsors.booklets.activate', $newCreatedbooklet) }}"
                                                            method="post">
                                                            @csrf
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
                    @elseif ($step === 'printing')
                    <div class="space-y-4" style="text-align: center;">
                    <button class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-70 disabled:cursor-not-allowed" type="button" wire:click="print">Print Booklet</button>
                    </div>
                    <!-- {{-- Printing Step --}}
                    <div class="space-y-4">
                        <button type="submit"
                            class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-70 disabled:cursor-not-allowed">
                            <span>Print Booklet</span>
                        </button>
                    </div> -->
                    @else
                    <div class="block md:flex items-center gap-3">
                        {{-- search --}}
                        <label class="block flex-1">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Search</span>
                            <input
                                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                placeholder="Search here..." type="text" wire:model.live="search" />
                        </label>

                        {{-- booklet language --}}
                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Booklet Language</span>
                            <select
                                class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                                wire:model.live="language" required>
                                {{-- <option value="">Choose Booklet Language</option> --}}
                                @foreach (languages() as $language)
                                <option value="{{ $language->value }}">{{ $language->name }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>

                    <x-validation-errors class="mb-4" />

                    <div class="mt-3 grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3 lg:gap-6">
                        @forelse ($templates as $template)
                        @if(file_exists(public_path($template->file)))
                        <div wire:key="{{ $template->id }}"
                            class="card space-y-5 p-4 sm:p-5 shadow cursor-pointer {{ $template->id == $template_id ? 'border border-primary' : '' }}"
                            wire:click="selectTemplate({{ $template->id }})">
                            <div class="flex justify-between">
                                <div class="flex items-center space-x-3">
                                    <p class="font-medium text-slate-700 dark:text-navy-100">
                                        {{ $template->title }}
                                    </p>
                                </div>
                                <p class="badge {{ $template->badge }} capitalize">
                                    {{ $template->language }}
                                </p>
                            </div>

                            <div class="grow">
                                <img class="h-48 w-full rounded-2xl object-cover object-center"
                                    src="{{ $template->preview }}" alt="image" />
                            </div>
                            <div class="flex justify-between">
                                <div class="flex space-x-5">
                                    <div>
                                        <p class="text-xs+">Used by users</p>
                                        <p class="text-lg font-semibold text-slate-700 dark:text-navy-100">
                                            {{ $template->booklets_count }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <p class="text-xs+ mb-1">Preview</p>
                                    <a href="{{ route('template.preview1', $template) }}" target="_blank"
                                        title="Preview Template"
                                        class="btn size-7 rounded-full bg-slate-150 p-0 font-medium text-slate-800 hover:bg-slate-200 hover:shadow-lg hover:shadow-slate-200/50 focus:bg-slate-200 focus:shadow-lg focus:shadow-slate-200/50 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:hover:shadow-navy-450/50 dark:focus:bg-navy-450 dark:focus:shadow-navy-450/50 dark:active:bg-navy-450/90">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 rotate-45"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif
                        @empty
                        <div
                            class="alert col-span-12 rounded-lg border border-primary px-4 py-4 text-primary dark:border-accent dark:text-accent-light sm:px-5">
                            No template created yet.
                        </div>
                        @endforelse

                    </div>
                    @endif

                    @if ($step === 'info')
                    <div class="flex justify-center space-x-2 pt-4">
                        <a href="{{ route('sponsors.booklets.index') }}"
                            class="btn min-w-[7rem] border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                            Cancel
                        </a>

                        <button type="button"
                            class="btn space-x-2 bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90"
                            wire:click="validateInfo">
                            <span>Next</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                    @elseif ($step === 'activate')
                    <!-- <div class="flex justify-center space-x-2 pt-4">
                        <button type="button" wire:click="changeStep('info')"
                            class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-50 disabled:cursor-not-allowed">
                            Activate
                        </button>
                    </div> -->
                    @elseif ($step === 'printing')
                    <!-- <div class="flex justify-center space-x-2 pt-4">
                        <button type="button" wire:click="print"
                            class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-50 disabled:cursor-not-allowed">
                            Print Booklet
                        </button>
                    </div> -->
                    @else
                    <div class="flex justify-center space-x-2 pt-4">
                        <button type="button"
                            class="btn space-x-2 bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90"
                            wire:click="changeStep('info')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span>Prev</span>
                        </button>
                        <button type="submit"
                            class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-50 disabled:cursor-not-allowed"
                            {{ count($templates) == 0 || $template_id === '' ? 'disabled' : '' }}>
                            Create
                        </button>
                    </div>
                    @endif

                </div>
            </form>
        </div>
    </div>
</div>