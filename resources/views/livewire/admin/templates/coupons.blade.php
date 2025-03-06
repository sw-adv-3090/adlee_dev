<div>
    @if (count($templates) > 0)
        <label class="block">
            <input
                class="form-input w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent"
                placeholder="Search" type="text" wire:model.live="search" />
        </label>
    @endif


    <div class="mt-3 grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3 lg:gap-6">
        @forelse ($templates as $template)
            <div class="card space-y-5 p-4 sm:p-5">
                <div class="flex justify-between">
                    <div class="flex items-center space-x-3">
                        <p class="font-medium text-slate-700 dark:text-navy-100">
                            {{ $template->title }}
                        </p>
                    </div>
                    <p class="badge {{ $template->badge }} capitalize">
                        {{ $template->language }}
                    </p>
                    <div class="flex space-x-2">
                        <div class="relative cursor-pointer">
                            <a href="{{ route('admin.templates.coupons.edit', $template) }}"
                                class="btn size-7 rounded-full bg-primary/10 p-0 text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                    fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path
                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                    <path fill-rule="evenodd"
                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                </svg>
                            </a>
                        </div>
                        <div class="relative cursor-pointer">
                            <form method="POST" action="{{ route('admin.templates.coupons.destroy', $template) }}"
                                method="POST" onsubmit="return confirm('Are you sure to delete template?')">
                                @csrf
                                @method('delete')
                                <button
                                    class="btn size-7 rounded-full bg-error/10 p-0 text-error hover:bg-error/20 focus:bg-error/20 active:bg-error/25">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>

                        </div>
                    </div>
                </div>

                <div class="grow">
                    <img class="h-48 w-full rounded-2xl object-cover object-center"
                        src="{{ asset($template->preview) }}" alt="image" />
                </div>
                <div class="flex justify-between">
                    <div class="flex space-x-5">
                        <div>
                            <p class="text-xs+">Revenue ($)</p>
                            <p class="text-lg font-semibold text-slate-700 dark:text-navy-100">
                                0
                            </p>
                        </div>
                        <div>
                            <p class="text-xs+">Clients</p>
                            <p class="text-lg font-semibold text-slate-700 dark:text-navy-100">
                                0
                            </p>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="text-xs+ mb-1">Preview</p>
                        <a href="{{ route('template.preview', $template) }}" target="_blank"
                            class="btn size-7 rounded-full bg-slate-150 p-0 font-medium text-slate-800 hover:bg-slate-200 hover:shadow-lg hover:shadow-slate-200/50 focus:bg-slate-200 focus:shadow-lg focus:shadow-slate-200/50 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:hover:shadow-navy-450/50 dark:focus:bg-navy-450 dark:focus:shadow-navy-450/50 dark:active:bg-navy-450/90">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 rotate-45" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 11l5-5m0 0l5 5m-5-5v12" />
                            </svg>
                        </a>

                    </div>

                </div>
            </div>
        @empty
            <div
                class="alert flex rounded-lg border border-primary px-4 py-4 text-primary dark:border-accent dark:text-accent-light sm:px-5">
                No template created yet.
            </div>
        @endforelse

    </div>
</div>
