<div class="space-y-5">
    <label class="block">
        <span>Template Category</span>
        <select
            class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
            wire:model.live="categoryId" name="category_id" required>
            <option value="">Choose Template Category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </label>

    @if (count($subCategories) > 0)
        <label class="block">
            <span>Template Sub Category</span>
            <select
                class="form-select mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2 hover:border-slate-400 focus:border-primary dark:border-navy-450 dark:bg-navy-700 dark:hover:border-navy-400 dark:focus:border-accent"
                wire:model.live="subCategoryId" name="sub_category_id" {{ count($subCategories) > 0 ? 'required' : '' }}>
                <option value="">Choose Template Sub Category</option>
                @foreach ($subCategories as $subCategory)
                    <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                @endforeach
            </select>
        </label>
    @endif

</div>
