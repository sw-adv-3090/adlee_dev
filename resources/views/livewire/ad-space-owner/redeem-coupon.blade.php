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
                    <div class="step-header mask is-hexagon {{ $step === 'redeem' ? $activeIcon : $normalIcon }}">
                        <i class="fa-solid fa-gear text-base"></i>
                    </div>
                    <div class="text-left">
                        <p class="text-xs text-slate-400 dark:text-navy-300">
                            Step 1
                        </p>
                        <h3 class="text-base font-medium {{ $step === 'redeem' ? $activeTitle : '' }}">Redeem Coupon</h3>
                    </div>
                </li>

                <li class="step space-x-4 pb-12 before:bg-slate-200 dark:before:bg-navy-500">
                    <div class="step-header mask is-hexagon {{ $step === 'select-template' ? $activeIcon : $normalIcon }}">
                        <i class="fa-solid fa-money-bill-wave text-base"></i>
                    </div>
                    <div class="text-left">
                        <p class="text-xs text-slate-400 dark:text-navy-300">
                            Step 2
                        </p>
                        <h3 class="text-base font-medium {{ $step === 'select-template' ? $activeTitle : '' }}">Select Template
                        </h3>
                    </div>
                </li>
                <li class="step space-x-4 pb-12 before:bg-slate-200 dark:before:bg-navy-500">
                    <div class="step-header mask is-hexagon {{ $step === 'sign' ? $activeIcon : $normalIcon }}">
                        <i class="fa-solid fa-pencil text-base"></i>
                    </div>
                    <div class="text-left">
                        <p class="text-xs text-slate-400 dark:text-navy-300">
                            Step 3
                        </p>
                        <h3 class="text-base font-medium {{ $step === 'sign' ? $activeTitle : '' }}">E Sign Task
                        </h3>
                    </div>
                </li>
                <li class="step space-x-4 pb-12 before:bg-slate-200 dark:before:bg-navy-500">
                    <div class="step-header mask is-hexagon {{ $step === 'print-template' ? $activeIcon : $normalIcon }}">
                        <i class="fa-solid fa-money-bill-wave text-base"></i>
                    </div>
                    <div class="text-left">
                        <p class="text-xs text-slate-400 dark:text-navy-300">
                            Step 4
                        </p>
                        <h3 class="text-base font-medium {{ $step === 'print-template' ? $activeTitle : '' }}">Print Template
                        </h3>
                    </div>
                </li>
                <li class="step space-x-4 pb-12 before:bg-slate-200 dark:before:bg-navy-500">
                    <div class="step-header mask is-hexagon {{ $step === 'download-agreement' ? $activeIcon : $normalIcon }}">
                        <i class="fa-solid fa-money-bill-wave text-base"></i>
                    </div>
                    <div class="text-left">
                        <p class="text-xs text-slate-400 dark:text-navy-300">
                            Step 5
                        </p>
                        <h3 class="text-base font-medium {{ $step === 'download-agreement' ? $activeTitle : '' }}">Download Agreement file
                        </h3>
                    </div>
                </li>
            </ol>
        </div>
    </div>

    <div class="col-span-12 grid lg:col-span-9">
        <div class="card p-4 sm:p-5">

            <div class="space-y-5">
                @if ($step === 'redeem')
                <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6 mt-8">
                    <div class="col-span-12 grid lg:col-span-8">
                        <div class="card p-4 sm:p-5">
                            @if (is_null($coupon->activated_at))
                            <div class="alert flex space-x-2 rounded-lg border border-error px-4 py-4 text-error mt-4 mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                <p> {{ __('This coupon is not yet activated. Please contact your sponsor to activate the coupon so that you may redeem it.') }}
                                </p>
                            </div>
                            @endif

                            <div
                                class="is-scrollbar-hidden min-w-full overflow-x-auto rounded-lg border border-slate-200 dark:border-navy-500">
                                <table class="w-full text-left">
                                    <tbody>
                                        <tr>
                                            <th
                                                class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                                Sponsor
                                            </th>
                                            <td
                                                class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                                {{ $coupon->sponsor?->company_name }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th
                                                class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                                Coupon Number
                                            </th>
                                            <td
                                                class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                                {{ $coupon->number }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th
                                                class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                                Amount
                                            </th>
                                            <td
                                                class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                                ${{ $coupon->amount }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th
                                                class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                                Payout Deadline
                                            </th>
                                            <td
                                                class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                                {{ $coupon->payout_deadline }} days after redemption
                                            </td>
                                        </tr>
                                        <tr>
                                            <th
                                                class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                                Payout On
                                            </th>
                                            <td
                                                class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                                {{ now()->addDays($coupon->payout_deadline)->format('F j, Y') }}
                                                {{ __('(You will only be eligible to be paid once you sign the e-signature consent and print out the template)') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th
                                                class="whitespace-nowrap border border-t-0 border-l-0 border-slate-200 px-3 py-3 font-semibold uppercase text-slate-800 dark:border-navy-500 dark:text-navy-100 lg:px-5">
                                                Activated At
                                            </th>
                                            <td
                                                class="whitespace-nowrap border border-slate-200 px-3 py-3 dark:border-navy-500 lg:px-5">
                                                {{ $coupon->activated_at?->format('F j, Y h:i:A') }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-5 text-center" x-data="{ showModal: false }">


                                <div class="mt-5 text-center" x-data="{ showModal: false }">
                                    <button type="button" @click="showModal = true"
                                        class="btn space-x-2 bg-primary font-medium text-white shadow-lg shadow-primary/50 hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:shadow-accent/50 dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-70 disabled:cursor-not-allowed"
                                        @disabled(is_null($coupon->activated_at) || !is_null($coupon->redeemed_at))>
                                        <span>Redeem Coupon </span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-hand-index-thumb" viewBox="0 0 16 16">
                                            <path
                                                d="M6.75 1a.75.75 0 0 1 .75.75V8a.5.5 0 0 0 1 0V5.467l.086-.004c.317-.012.637-.008.816.027.134.027.294.096.448.182.077.042.15.147.15.314V8a.5.5 0 0 0 1 0V6.435l.106-.01c.316-.024.584-.01.708.04.118.046.3.207.486.43.081.096.15.19.2.259V8.5a.5.5 0 1 0 1 0v-1h.342a1 1 0 0 1 .995 1.1l-.271 2.715a2.5 2.5 0 0 1-.317.991l-1.395 2.442a.5.5 0 0 1-.434.252H6.118a.5.5 0 0 1-.447-.276l-1.232-2.465-2.512-4.185a.517.517 0 0 1 .809-.631l2.41 2.41A.5.5 0 0 0 6 9.5V1.75A.75.75 0 0 1 6.75 1M8.5 4.466V1.75a1.75 1.75 0 1 0-3.5 0v6.543L3.443 6.736A1.517 1.517 0 0 0 1.07 8.588l2.491 4.153 1.215 2.43A1.5 1.5 0 0 0 6.118 16h6.302a1.5 1.5 0 0 0 1.302-.756l1.395-2.441a3.5 3.5 0 0 0 .444-1.389l.271-2.715a2 2 0 0 0-1.99-2.199h-.581a5 5 0 0 0-.195-.248c-.191-.229-.51-.568-.88-.716-.364-.146-.846-.132-1.158-.108l-.132.012a1.26 1.26 0 0 0-.56-.642 2.6 2.6 0 0 0-.738-.288c-.31-.062-.739-.058-1.05-.046zm2.094 2.025" />
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
                                                        Redeem Coupon
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
                                                    <!-- show when sponsor is not select temlates to be used for commemoration puprose --->
                                                    <div class="text-center mt-3">
                                                        <p class="text-sm font-normal text-slate-600 mb-4">
                                                            {{ __('Are you sure you wish to redeem this coupon now? This action is irreversible. You will be redirected to select a template from a list which has been pre-approved by your Sponsor. In order to receive your payment, you will be prompted to sign an e-signature consent and also print out the completed template and hang up in clear view on your bulletin board.') }}
                                                        </p>

                                                        <div class="flex items-center justify-center space-x-2 mt-4">
                                                            <button @click="showModal = false"
                                                                class="btn min-w-[7rem] rounded-full border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                                                Cancel
                                                            </button>

                                                            <button type="button" wire:click="changeStep('select-template')"
                                                                class="btn min-w-[7rem] rounded-full bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                                                Agree & Continue
                                                            </button>


                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </template>
                                </div>

                            </div>
                        </div>
                    </div>

                    @elseif($step === 'select-template')
                    <div
                        class="flex flex-col items-center justify-between space-y-2 text-center sm:flex-row sm:space-y-0 sm:text-left mt-6">
                        <div class="mt-3">
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3 lg:gap-6">
                                @forelse ($templates as $template)

                                <div class="card space-y-5 p-4 sm:p-5 shadow cursor-pointer {{ $template->id == $selectedTemplate ? 'border border-primary' : '' }}"
                                    wire:click="selectTemplate({{ $template->id }})" wire:key="{{ $template->id }}">
                                    <div class="flex justify-between">
                                        <div class="flex items-center space-x-3">
                                            <p class="font-medium text-slate-700 dark:text-navy-100">
                                                {{ $template->title }}
                                            </p>
                                        </div>
                                        <p
                                            class="badge bg-primary/10 text-primary dark:bg-accent-light/15 dark:text-accent-light capitalize">
                                            {{ $template->language }}
                                        </p>
                                    </div>

                                    <div class="grow">
                                    <img class="h-48 w-full rounded-2xl object-cover object-center"
                                        src="data:image/png;base64,{{ $this->templatePreview($template,$coupon->id) }}" alt="image" />
                                    </div>
                                    <div class="flex justify-between">
                                        <p
                                            class="badge bg-secondary/10 text-secondary dark:bg-secondary-light/15 dark:text-secondary-light capitalize">
                                            {{ $template->category?->name }}
                                        </p>
                                        <a href="{{ route('template.preview1', $template) }}?coupon={{ $coupon->id}}&from_bbo=true" target="_blank"
                                            title="View template with dummy data"
                                            class="btn size-7 rounded-full bg-slate-150 p-0 font-medium text-slate-800 hover:bg-slate-200 hover:shadow-lg hover:shadow-slate-200/50 focus:bg-slate-200 focus:shadow-lg focus:shadow-slate-200/50 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:hover:shadow-navy-450/50 dark:focus:bg-navy-450 dark:focus:shadow-navy-450/50 dark:active:bg-navy-450/90">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 rotate-45" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                                @empty
                                <div
                                    class="alert flex rounded-lg border border-primary px-4 py-4 text-primary dark:border-accent dark:text-accent-light sm:px-5 mt-3 col-span-12">
                                    No template
                                </div>
                                @endforelse
                            </div>


                            <div class="text-center mt-10">
                                <button
                                    class="btn space-x-2 bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-50"
                                    @disabled(is_null($selectedTemplate)) wire:click="saveTemplate" wire:loading.attr="disabled">
                                    <span>Select Template</span>
                                </button>
                            </div>

                            {{-- <div class="text-center mt-10" x-data="{ showModal: false }">
                            <button @click="showModal = true"
                                class="btn space-x-2 bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-50"
                                @disabled(is_null($selectedTemplate))>
                                <span>Select Template</span>
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
                                        x-show="showModal" x-transition:enter="easy-out" x-transition:enter-start="opacity-0 scale-95"
                                        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="easy-in"
                                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                                        <div class="flex justify-between rounded-t-lg bg-slate-200 px-4 py-3 dark:bg-navy-800 sm:px-5">
                                            <h3 class="text-base font-medium text-slate-700 dark:text-navy-100">
                                                Redeem Coupon
                                            </h3>
                                            <button @click="showModal = !showModal"
                                                class="btn -mr-1.5 size-7 rounded-full p-0 hover:bg-slate-300/20 focus:bg-slate-300/20 active:bg-slate-300/25 dark:hover:bg-navy-300/20 dark:focus:bg-navy-300/20 dark:active:bg-navy-300/25">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12">
                                                    </path>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="p-4 sm:p-5">
                                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Mollitia similique, officiis sed
                                            odio sit dolores saepe harum, placeat, illum qui sint veritatis accusamus deleniti fugit
                                            corrupti. Doloremque quaerat iure animi?

                                        </div>

                                    </div>
                                </div>
                            </template>
                        </div> --}}

                        </div>


                    </div>


                    @elseif ($step === 'sign')
                    <div class="col-span-12">
                        <iframe src="{{ $link }}" frameborder="0" width="100%" height="500"></iframe>
                    </div>
                    @elseif($step === 'print-template')
                    <div class="flex justify-center space-x-2 pt-4">
                        <form id="download-form" method="POST"
                            action="{{ route('ad-space-owner.coupons.task.print', $coupon) }}"
                            method="POST">
                            @csrf
                            <button type="submit" id="download-link" target="hidden-frame"
                                class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-50 disabled:cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14"
                                    height="14" fill="currentColor"
                                    class="bi bi-printer" viewBox="0 0 16 16">
                                    <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1" />
                                    <path
                                        d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1" />
                                </svg>
                                <span> Print Template</span>
                            </button>
                                <iframe name="hidden-frame" style="display: none;"></iframe>
                        </form>
                        <!-- <button type="button" wire:click="changeStep('download-agreement')"
                            class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-50 disabled:cursor-not-allowed">
                            Next
                        </button> -->
                    </div>
                    @elseif($step === 'download-agreement')

                    @endif

                    @if ($step === 'redeem')
                    <div class="flex justify-center space-x-2 pt-4">



                    </div>
                    @elseif ($step === 'sign')
                    <div class="flex justify-center space-x-2 pt-4">
                        <button style='visibility:hidden' id='next_btn' type="button" wire:click="changeStep('print-template')"
                            class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-50 disabled:cursor-not-allowed">
                            Next
                        </button>
                    </div>
                    @elseif ($step === 'print-template')
                    <!-- <div class="flex justify-center space-x-2 pt-4">
                        <button type="button" wire:click="print()"
                            class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-50 disabled:cursor-not-allowed">
                            Print Template
                        </button>
                    </div> -->
                    @elseif($step === 'download-agreement')
                    <div class="flex justify-center space-x-2 pt-4">
                        <button type="button" wire:click="downloadAgreement()"
                            class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-50 disabled:cursor-not-allowed">
                            Download Agreement
                        </button>
                    </div>
                    <!-- <div class="flex justify-center space-x-2 pt-4">
                                
                    </div> -->
                    @endif

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
                window.addEventListener('message',(event) => {
                    console.log(event)
                    const btn_1 = document.getElementById("next_btn");
                    if (event.origin !== 'https://app.boldsign.com') {
                        return;
                    }

                    const data = event.data;

                    if (data.action === 'onDocumentSigned') {  
                        const apiPayload = {
                            "data": {
                                "object": "document",
                                "status": "Completed",
                                "documentId": data.documentId
                            }
                        }
                        btn_1.click();
                        fetch("https://adlee.io/boldsign/webhook", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify(apiPayload),
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log("Success:", data);
                        })
                        .catch(error => {
                            console.error("Error:", error);
                        });
                    }
                });

                window.addEventListener('click', (e) => {
                    console.log(',,,,.,,..,,',e);
                    if (e.target.innerText == 'Print Template') {
                        console.log('Hello world ../../../..')
                            setTimeout(() => {
                                window.location.reload();
                            }, 4000);
                    }
                })

            // Handle download link click        
            const attachEventListener = () => {
                const downloadLink = document.getElementById('download-link');
                console.log('button found', downloadLink);
                if (downloadLink) {
                    window.location.reload();
                    // downloadLink.addEventListener('click', () => {
                    //     setTimeout(() => {
                    //         window.location.reload();
                    //     }, 4000);
                    // });
                }
            };

    </script>
    @endpush
    @stack('scripts')

