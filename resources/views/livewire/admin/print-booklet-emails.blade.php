<div>
    @include('partials.alert')
    <div class="grid grid-cols-12 mt-8">
        <div class="col-span-12 lg:col-span-8">
            <div class="card p-4 sm:p-5">
                <form wire:submit="save">
                    <div class="">
                        <h3 class="font-medium text-slate-600 dark:text-navy-100 text-lg">Print Emails</h3>
                        <p class="my-1.5">Write down all email address you want to send booklet zip file to be
                            print out whenever sponsor initiate booklet print request.
                        </p>
                    </div>
                    <div class="space-y-5">
                        @foreach ($emails as $index => $email)
                            <div class="flex items-center space-x-2">
                                <div class="flex-1">
                                    <label class="block">
                                        <input
                                            class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent "
                                            placeholder="Email Address" type="email"
                                            wire:model="emails.{{ $index }}" required />
                                    </label>
                                    @error('emails.' . $index)
                                        <span class="text-xs text-error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="button"
                                    class="btn size-7 rounded-full bg-error p-0 font-medium text-white hover:bg-error-focus focus:bg-error-focus active:bg-error-focus/90 mt-1"
                                    wire:click="removeEmail({{ $index }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        @endforeach


                    </div>
                    <div class="flex justify-end mt-3">
                        <button type="button"
                            class="btn h-8 space-x-2 bg-primary font-medium text-white hover:bg-primary-focus hover:shadow-lg hover:shadow-primary/50 focus:bg-primary-focus focus:shadow-lg focus:shadow-primary/50 active:bg-primary-focus/90"
                            wire:click="addEmail">
                            <span>Add New</span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-plus" viewBox="0 0 16 16">
                                <path
                                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                            </svg>
                        </button>
                    </div>

                    <div class="text-center mt-5">
                        <button type="submit"
                            class="btn min-w-[7rem] bg-primary font-medium text-white hover:bg-primary-focus focus:bg-primary-focus active:bg-primary-focus/90 dark:bg-accent dark:hover:bg-accent-focus dark:focus:bg-accent-focus dark:active:bg-accent/90">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
