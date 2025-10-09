<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use  App\Enums\CategoryStatusEnum;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('items')->paginate(7);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorystatuses = CategoryStatusEnum::labels();
        return view('admin.categories.create', compact('categorystatuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','unique:categories'],
            'status' => ['required','in:1,2']
        ]);
        Category::create($data);
        return to_route('admin.categories.index')->with('success', 'Category added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categorystatuses = CategoryStatusEnum::labels();
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('categorystatuses', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $category = Category::findOrFail($id);
        $data = $request->validate([
            'name' => 'required','unique:categories,name,' . $category->id ,
            'status' => ['required','in:1,2']
        ]);
        $category->update($data);
        return to_route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Unit deleted successfully.'
        ]);
    }
}
