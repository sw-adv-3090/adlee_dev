<div class="card space-y-5 p-4 sm:p-5">
    <div class="space-y-3">
        <span class="font-medium text-slate-600 dark:text-navy-100">Upload File</span>
        <p>
            Upload your file to server to get file url.
        </p>
        <label
            class="block btn bg-slate-150 font-medium text-slate-800 hover:bg-slate-200 focus:bg-slate-200 active:bg-slate-200/80 dark:bg-navy-500 dark:text-navy-50 dark:hover:bg-navy-450 dark:focus:bg-navy-450 dark:active:bg-navy-450/90 py-3">
            <input tabindex="-1" type="file" class="pointer-events-none absolute inset-0 h-full w-full opacity-0"
                wire:model.live="file" />
            <div class="flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                </svg>
                <span>Choose File</span>
            </div>
        </label>
        @error('file')
            <span class="text-xs text-error">{{ $message }}</span>
        @enderror

        <div class="spinner size-10 animate-spin rounded-full border-[3px] border-primary/30 border-r-primary dark:border-accent/30 dark:border-r-accent"
            wire:loading>
        </div>
        @if ($fileUrl)
            <div
                class="alert flex items-center justify-between rounded-lg bg-primary px-4 py-3 text-white dark:bg-accent sm:px-5">
                <p id="fileUrl" class="text-tiny+ max-w-[85%] 2xl:max-w-[90%]">{{ $fileUrl }}</p>
                <button class="btn h-6 shrink-0 rounded bg-white/20 px-2 text-xs text-white active:bg-white/25"
                    @click="$clipboard({
                    content:document.querySelector('#fileUrl').innerText,
                    success:()=>$notification({text:'Text Copied',variant:'success'}),
                    error:()=>$notification({text:'Error',variant:'error'})
            })">
                    Copy
                </button>
            </div>
        @endif

    </div>


</div>
