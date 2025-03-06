<x-layouts.app-layout title="Update Sponsor Template" is-sidebar-open="true">
    <div
        class="mt-6 flex flex-col items-center justify-between space-y-2 text-center sm:flex-row sm:space-y-0 sm:text-left">
        <div class="flex items-center space-x-1">
            <h2 class="text-xl font-medium text-slate-700 line-clamp-1 dark:text-navy-50">
                Update Sponsor Template
            </h2>
        </div>
        <a href="{{ route('admin.templates.categories.index') }}"
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

    <div class="min-w-full mt-8">
        <div class="card">
            <div class="p-4 sm:p-5">
                <form action="{{ route('admin.templates.categories.update', $category) }}" method="post">
                    @csrf
                    @method('put')

                    <div class="space-y-5">
                        <label class="block">
                            <span class="font-medium text-slate-600 dark:text-navy-100">Name</span>
                            <input
                                class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent "
                                placeholder="Enter cetegory name" type="text" name="name"
                                value="{{ old('name', $category->name) }}" required />
                        </label>
                        @error('name')
                            <span class="text-xs text-error">{{ $message }}</span>
                        @enderror

                        @livewire('upsert-sub-categories', ['sub_categories' => $category->subCategories])

                        <div class="flex justify-center space-x-2 pt-4">
                            <a href="{{ route('admin.templates.categories.index') }}"
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

</x-layouts.app-layout>
