<div class="card p-4 sm:p-5 mt-5">
    <div class="flex items-center justify-between mb-5">
        <p class="text-base font-normal text-slate-700 dark:text-navy-100">
            Please select one template from the pre-approved list from your Sponsor which you will need to print out and
            hang in a visible location.
        </p>
        @if ($showLanguages)
            <label class="block">
                <select
                    class="form-select mt-1.5 min-w-40 rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                    name="language" wire:model.live="language">
                    @foreach (languages() as $language)
                        <option value="{{ $language->value }}">{{ $language->name }}</option>
                    @endforeach
                </select>
            </label>
        @endif

    </div>

    @session('error')
        <div class="alert flex space-x-2 rounded-lg border border-error px-4 py-4 text-error my-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd" />
            </svg>
            <p> {{ $value }}</p>
        </div>
    @endsession

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
                            src="{{ asset($template->preview) }}" alt="image" />
                    </div>
                    <div class="flex justify-between">
                        <p
                            class="badge bg-secondary/10 text-secondary dark:bg-secondary-light/15 dark:text-secondary-light capitalize">
                            {{ $template->category?->name }}
                        </p>
                        <a href="{{ route('template.preview', $template) }}" target="_blank"
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
