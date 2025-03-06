<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.categories.index', [
            'categories' => Category::withCount(['subCategories', 'templates'])->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $category = Category::create(['name' => $request->name]);

        $subCatgories = [];
        foreach ($request->subCategories as $item) {
            $subCatgories[] = [
                'category_id' => $category->id,
                'name' => $item['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (count($subCatgories) > 0) {
            SubCategory::insert($subCatgories);
        }

        return back()->with('success', 'New category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $category->load('subCategories');

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        foreach ($request->subCategories as $item) {
            SubCategory::updateOrCreate([
                'id' => $item['id']
            ], [
                'category_id' => $category->id,
                'name' => $item['name'],
            ]);
        }

        return back()->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $category->subCategories()->delete();
            $category->delete();

            return back()->with('success', 'Category deleted successfully.');
        } catch (\Exception $ex) {
            return back()->with('error', $ex->getMessage());
        }

    }
}
