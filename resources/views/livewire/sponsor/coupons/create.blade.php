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
            </ol>
        </div>
    </div>

    <div class="col-span-12 grid lg:col-span-9">
        <div class="card p-4 sm:p-5">
            <div wire:loading wire:loading wire:target="save">
                <div
                    class="alert flex overflow-hidden rounded-lg bg-info/10 text-info dark:bg-info-light/15 dark:text-info-light mb-5">
                    <div class="w-1.5 bg-info"></div>
                    <div class="p-4">Please Wait</div>
                </div>
            </div>

            <form wire:submit="save">
                <div class="space-y-5">
                    @if ($step === 'info')
                        {{-- coupon title --}}
                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Coupon Title</span>
                            <input
                                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent "
                                placeholder="Enter coupon title for reference" type="text" wire:model="title"
                                value="{{ old('title') }}" required />
                        </label>
                        @error('title')
                            <span class="text-xs text-error">{{ $message }}</span>
                        @enderror

                        {{-- coupon amount --}}
                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Coupon Amount in Dollars,
                                minimum 50</span>
                            <input
                                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent "
                                placeholder="Enter coupon amount in Dollars" type="text" wire:model="amount"
                                value="{{ old('amount') }}" required />
                        </label>
                        @error('amount')
                            <span class="text-xs text-error">{{ $message }}</span>
                        @enderror

                        {{-- confirm coupon amount --}}
                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Confirm Coupon Amount in
                                Dollars</span>
                            <input
                                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent "
                                placeholder="Confirm coupon amount in Dollars" type="text"
                                wire:model="confirm_amount" value="{{ old('confirm_amount') }}" required />
                        </label>
                        @error('confirm_amount')
                            <span class="text-xs text-error">{{ $message }}</span>
                        @enderror

                        {{-- coupon payout deadline --}}
                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Coupon Payout Deadline</span>
                            <p class="my-1.5">Upon activating, choose the coupon payout timeframe.</p>
                            <select
                                class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                                wire:model="payout_deadline" required>
                                <option value="">Choose Duration</option>
                                @foreach (coupon_payouts_durations(true) as $duration => $value)
                                    <option value="{{ $value }}" @selected(old('payout_deadline') == $value)>
                                        {{ $duration }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                        @error('payout_deadline')
                            <span class="text-xs text-error">{{ $message }}</span>
                        @enderror 
                    @else
                        <div class="block md:flex items-center gap-3">
                            {{-- search --}}
                            <label class="block flex-1">
                                <span class="font-medium text-slate-600 dark:text-navy-100">Search</span>
                                <input
                                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="Search here..." type="text" wire:model.live="search" />
                            </label>

                            {{-- coupon language --}}
                            <label class="block">
                                <span class="font-medium text-slate-600 dark:text-navy-100">Coupon Language</span>
                                <select
                                    class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                                    wire:model.live="language" required>
                                    {{-- <option value="">Choose Coupon Language</option> --}}
                                    @foreach (languages() as $language)
                                        <option value="{{ $language->value }}">{{ $language->name }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>

                        <x-validation-errors class="mb-4" />

                        <div class="mt-3 grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3 lg:gap-6">
                            @forelse ($templates as $template)
                            
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
                                                    0
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
                            <a href="{{ route('sponsors.coupons.index') }}"
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
                            <button type="button" wire:click="saveAndSend"
                                class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90 disabled:opacity-50 disabled:cursor-not-allowed"
                                {{ count($templates) == 0 || $template_id === '' ? 'disabled' : '' }}>
                                Create and Send
                            </button>
                        </div>
                    @endif

                </div>
            </form>
        </div>

    </div>
</div>
