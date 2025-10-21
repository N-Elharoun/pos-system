<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use  App\Enums\CategoryStatusEnum;
use Illuminate\Support\Facades\Storage;

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
            'status' => ['required','in:1,2'],
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
        $category = Category::create($data);
        $category->uploadPhoto($request, 'photo', 'categories', 'category_photo');
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
            'status' => ['required','in:1,2'],
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
        $category->uploadPhoto($request, 'photo', 'categories', 'category_photo');
        $category->update($data);
        return to_route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->deletePhoto();
        $category->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Unit deleted successfully.'
        ]);
    }
}
