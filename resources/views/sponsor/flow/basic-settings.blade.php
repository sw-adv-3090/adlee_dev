<x-layouts.app-layout title="Basic Settings" is-header-blur="true">

    <div class="flex items-center space-x-4 py-5 lg:py-6">
        <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
            Basic Settings
        </h2>
    </div>


    <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
        <x-sponsor-flow-steps :step3="true" />

        <div class="col-span-12 grid lg:col-span-9">
            <div class="card p-4 sm:p-5">
                @include('partials.alert')

                <p class="text-base font-medium text-slate-700 dark:text-navy-100">
                    Basic Settings
                </p>
                <form action="{{ route('sponsors.basic-settings.store') }}" method="post">
                    @csrf
                    @php
                        $sponsor = auth()->user()->sponsor;
                    @endphp
                    <div class="mt-4 space-y-5">
                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Company name</span>
                            <span class="relative mt-1.5 flex">
                                <input
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="Your Company" type="text" name="company_name"
                                    value="{{ old('company_name', $sponsor?->company_name) }}" required />
                                <span
                                    class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                    <i class="fa-regular fa-building text-base"></i>
                                </span>
                            </span>
                        </label>
                        @error('company_name')
                            <span class="text-xs text-error">{{ $message }}</span>
                        @enderror

                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Company Phone number</span>
                            <span class="relative mt-1.5 flex">
                                <input
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="(999) 999-9999" type="text"
                                    x-input-mask="{numericOnly: true, blocks: [0, 3, 3, 4], delimiters: ['(', ') ', '-']}"
                                    name="company_phone" value="{{ old('company_phone', $sponsor?->company_phone) }}"
                                    required />
                                <span
                                    class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                    <i class="fa fa-phone"></i>
                                </span>
                            </span>
                        </label>
                        @error('company_phone')
                            <span class="text-xs text-error">{{ $message }}</span>
                        @enderror

                        <div>
                            <span class="font-medium text-slate-600 dark:text-navy-100">Company Logo</span>
                            <p class="my-1.5">
                                {{ __('Upload your company logo that will appear on templates. We recommend a logo at least 300px wide. Only png file format is supported.') }}
                            </p>
                            <div class="filepond fp-bordered fp-grid mt-1.5 [--fp-grid:2] ">
                                <input type="file" name="company_logo" class="preview"
                                    {{ $sponsor?->company_logo ? '' : 'required' }} />
                            </div>
                            @if ($sponsor?->company_logo)
                                <input type="hidden" name="old_company_logo" value="{{ $sponsor->company_logo }}">
                                <div class="avatar mt-1.5 size-20">
                                    <img id="avatar" class="mask is-squircle"
                                        src="{{ asset($sponsor?->company_logo) }}"
                                        alt="{{ $sponsor?->company_name }}" />
                                </div>
                            @endif
                            @error('company_logo')
                                <span class="text-xs text-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">IRS Given EIN Number</span>
                            <div class="relative mt-1.5 flex">
                                <input
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="Please enter your IRS Given EIN Number. Remember you have to verify your EIN number."
                                    type="text" x-input-mask="{numericOnly: true, blocks: [2, 7], delimiters: ['-']}"
                                    name="ein_number" value="{{ old('ein_number', $sponsor?->ein_number) }}"
                                    required />
                                <span
                                    class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                    <i class="fa-solid fa-map-pin text-base"></i>
                                </span>
                            </div>
                        </label>
                        @error('ein_number')
                            <span class="text-xs text-error">{{ $message }}</span>
                        @enderror

                        <label class="inline-flex items-center space-x-2">
                            <input
                                class="form-checkbox is-basic size-5 rounded border-slate-400/70 checked:bg-primary checked:border-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:bg-accent dark:checked:border-accent dark:hover:border-accent dark:focus:border-accent"
                                type="checkbox" name="consent_ein_number" @checked(old('consent_ein_number', $sponsor?->ein_number)) required />
                            <p>You agree that you are a authorized representative of the company to use this EIN.</p>
                        </label>
                        @error('consent_ein_number')
                            <span class="text-xs text-error">{{ $message }}</span>
                        @enderror

                        <label class="inline-flex items-center space-x-2">
                            <input
                                class="form-checkbox is-basic size-5 rounded border-slate-400/70 checked:bg-primary checked:border-primary hover:border-primary focus:border-primary dark:border-navy-400 dark:checked:bg-accent dark:checked:border-accent dark:hover:border-accent dark:focus:border-accent"
                                type="checkbox" name="is_commemoration" @checked(old('is_commemoration', $sponsor?->is_commemoration)) />
                            <p>Do you want to be prompted for commemorations using ‘In Memory Of’ or ‘In Honor Of’ to be
                                displayed on your sponsor advertisements?”</p>
                        </label>
                        @error('is_commemoration')
                            <span class="text-xs text-error">{{ $message }}</span>
                        @enderror
                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Who Will Pay Commission?</span>
                            <select
                                class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                                name="paying_commission" required>
                                {{-- <option value="">Choose Option</option> --}}
                                <option value="sponsor" @selected($sponsor?->paying_commission)>You (Sponsor)</option>
                                <option value="ad-space-owner" @selected(!$sponsor?->paying_commission)>Ad Space Owner</option>
                            </select>
                        </label>
                        @error('paying_commission')
                            <span class="text-xs text-error">{{ $message }}</span>
                        @enderror

                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Default Coupon Payout</span>
                            <select
                                class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                                name="default_coupon_payout" required>
                                <option value="">Choose Duration</option>
                                @foreach (coupon_payouts_durations() as $duration => $value)
                                    <option value="{{ $value }}" @selected(old('default_coupon_payout', $sponsor?->default_coupon_payout) == $value)>
                                        {{ $duration }}
                                    </option>
                                @endforeach

                            </select>
                        </label>
                        @error('default_coupon_payout')
                            <span class="text-xs text-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-center mt-6">
                        <button type="submit"
                            class="btn space-x-2 bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            <span>Save Settings</span>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            const preview = document.querySelector('input[type="file"].preview');

            FilePond.create(preview).setOptions({
                server: {
                    process: "{{ route('uploads.process.image') }}",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                },
            });
        })
    </script>

</x-layouts.app-layout>
