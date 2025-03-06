<x-layouts.app-layout title="Create Coupon Template" is-sidebar-open="true">
    <div
        class="mt-6 flex flex-col items-center justify-between space-y-2 text-center sm:flex-row sm:space-y-0 sm:text-left">
        <div class="flex items-center space-x-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h2 class="text-xl font-medium text-slate-700 line-clamp-1 dark:text-navy-50">
                Create Coupon Template
            </h2>
        </div>
        <a href="{{ route('admin.templates.coupons.index') }}"
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

    <div class="grid grid-cols-12 gap-4 sm:gap-5 lg:gap-6 mt-8">
        <div class="col-span-12 lg:col-span-8">
            <div class="card">
                <div class="tabs flex flex-col">
                    <div class="tab-content p-4 sm:p-5">
                        <form action="{{ route('admin.templates.coupons.store') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="space-y-5">
                                <label class="block">
                                    <span class="font-medium text-slate-600 dark:text-navy-100">Title</span>
                                    <input
                                        class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent "
                                        placeholder="Enter template title" type="text" name="title"
                                        value="{{ old('title') }}" required />
                                </label>
                                @error('title')
                                    <span class="text-xs text-error">{{ $message }}</span>
                                @enderror

                                <label class="block">
                                    <span>Template Language</span>
                                    <select
                                        class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                                        name="language" required>
                                        <option value="">Choose Template Language</option>
                                        @foreach ($languages as $language)
                                            <option value="{{ $language->value }}">{{ $language->name }}</option>
                                        @endforeach
                                    </select>
                                </label>
                                @error('language')
                                    <span class="text-xs text-error">{{ $message }}</span>
                                @enderror

                                <div>
                                    <span class="font-medium text-slate-600 dark:text-navy-100">Template Preview</span>
                                    <p class="my-1.5">Upload image of template who it will look. This will help users to
                                        visually look at the template how it is looking when they select the template.
                                    </p>
                                    <div class="filepond fp-bordered fp-grid mt-1.5 [--fp-grid:2] ">
                                        <input type="file" name="preview" class="preview" required />
                                    </div>
                                    @error('preview')
                                        <span class="text-xs text-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <span class="font-medium text-slate-600 dark:text-navy-100">Template Content</span>
                                    @include('partials.coupon-tooltip')
                                    <div class="filepond fp-bordered fp-grid mt-1.5 [--fp-grid:2]">
                                        <input type="file" name="content" class="content" required />
                                    </div>
                                    @error('content')
                                        <span class="text-xs text-error">{{ $message }}</span>
                                    @enderror
                                </div>

                                <label class="block">
                                    <span class="font-medium text-slate-600 dark:text-navy-100">Publish Date</span>
                                    <p class="my-1.5">The date at which the template will be visible for coupons to
                                        select. If you don't choose publish date then the template will be published
                                        immediately.
                                    </p>
                                    <span class="relative mt-1.5 flex">
                                        <input x-init="$el._x_flatpickr = flatpickr($el, {
                                            altInput: true,
                                            altFormat: 'F j, Y',
                                            dateFormat: 'Y-m-d',
                                        })"
                                            class="form-input mt-1.5 peer w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 pl-9 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                                            placeholder="Choose date..." type="text" name="publish_at" />
                                        <span
                                            class="pointer-events-none absolute flex h-full w-10 items-center justify-center text-slate-400 peer-focus:text-primary dark:text-navy-300 dark:peer-focus:text-accent">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="size-5 transition-colors duration-200" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </span>
                                    </span>
                                </label>
                                @error('publish_at')
                                    <span class="text-xs text-error">{{ $message }}</span>
                                @enderror

                                <div class="flex justify-center space-x-2 pt-4">
                                    <a href="{{ route('admin.templates.coupons.index') }}"
                                        class="btn min-w-[7rem] border border-slate-300 font-medium text-slate-800 hover:bg-slate-150 focus:bg-slate-150 active:bg-slate-150/80 dark:border-navy-450 dark:text-navy-50 dark:hover:bg-navy-500 dark:focus:bg-navy-500 dark:active:bg-navy-500/90">
                                        Cancel
                                    </a>
                                    <button type="submit"
                                        class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-12 lg:col-span-4">
            @livewire('file-upload')
        </div>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            const preview = document.querySelector('input[type="file"].preview');
            const content = document.querySelector('input[type="file"].content');

            FilePond.create(preview).setOptions({
                server: {
                    process: "{{ route('uploads.process.image') }}",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                },
            });
            FilePond.create(content).setOptions({
                server: {
                    process: "{{ route('uploads.process') }}",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    },
                },
            });
        })
    </script>
</x-layouts.app-layout>
