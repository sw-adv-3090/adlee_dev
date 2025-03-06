<x-layouts.app-layout title="Company Information" is-sidebar-open="true">
    <div class="flex items-center space-x-4 py-5 lg:py-6">
        <h2 class="text-xl font-medium text-slate-800 dark:text-navy-50 lg:text-2xl">
            Company Information
        </h2>
    </div>

    <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6">
        <x-ad-space-owner-flow-steps :step2="true" />

        <div class="col-span-12 grid lg:col-span-9">
            <div class="card p-4 sm:p-5">
                @include('partials.alert')

                <p class="text-base font-medium text-slate-700 dark:text-navy-100">
                    Company Information
                </p>
                <form action="{{ route('ad-space-owner.basic-settings.store') }}" method="post">
                    @csrf
                    <div class="mt-4 space-y-5">
                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Company name</span>
                            <span class="relative mt-1.5 flex">
                                <input
                                    class="form-input peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                    placeholder="Your Company" type="text" name="company_name"
                                    value="{{ old('company_name', $adSpaceOwner?->company_name) }}" required />
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
                                    name="company_phone"
                                    value="{{ old('company_phone', $adSpaceOwner?->company_phone) }}" required />
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
                                    {{ $adSpaceOwner?->company_logo ? '' : 'required' }} />
                            </div>
                            @if ($adSpaceOwner?->company_logo)
                                <input type="hidden" name="old_company_logo" value="{{ $adSpaceOwner->company_logo }}">
                                <div class="avatar mt-1.5 size-20">
                                    <img id="avatar" class="mask is-squircle"
                                        src="{{ asset($adSpaceOwner?->company_logo) }}"
                                        alt="{{ $adSpaceOwner?->company_name }}" />
                                </div>
                            @endif
                            @error('company_logo')
                                <span class="text-xs text-error">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="flex justify-center mt-6">
                        <button type="submit"
                            class="btn space-x-2 bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            <span>Save Information</span>
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
