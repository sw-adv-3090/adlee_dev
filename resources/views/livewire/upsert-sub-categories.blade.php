<div class="space-y-5">
    @foreach ($subCategories as $idx => $item)
        <div class="">
            <label class="block">
                <span class="font-medium text-slate-600 dark:text-navy-100">Sub Category {{ $loop->iteration }}</span>
                <input
                    class="form-input mt-1.5 w-full rounded-lg border border-slate-300 bg-transparent px-3 py-2 placeholder:text-slate-400/70 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:hover:border-navy-400 dark:focus:border-accent "
                    placeholder="Enter sub category {{ $loop->iteration }}" type="text"
                    name="subCategories[{{ $idx }}][name]" value="{{ $item['name'] }}" required />
                <input type="hidden" name="subCategories[{{ $idx }}][id]" value="{{ $item['id'] }}" />
            </label>
            <div class="flex justify-end mt-1">
                <button type="button"
                    class="btn bg-error/10 font-medium text-error hover:bg-error/20 focus:bg-error/20 active:bg-error/25"
                    wire:click="deleteSubCategory({{ json_encode($item) }},{{ $loop->index }})">
                    Delete
                </button>
            </div>
        </div>
    @endforeach

    <div class="flex justify-end">
        <button type="button"
            class="btn bg-primary/10 font-medium text-primary hover:bg-primary/20 focus:bg-primary/20 active:bg-primary/25 dark:bg-accent-light/10 dark:text-accent-light dark:hover:bg-accent-light/20 dark:focus:bg-accent-light/20 dark:active:bg-accent-light/25"
            wire:click="addSubCategory">Add Sub Category</button>
    </div>
</div>
