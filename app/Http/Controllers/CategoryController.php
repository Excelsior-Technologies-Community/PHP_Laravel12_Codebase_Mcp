<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderby('id', 'asc')->paginate(3);

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name'
        ]);

        Category::create([
            'name' => $request->name
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Category created successfully.']);
        }

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        if (request()->ajax()) {
            return view('categories._edit_form', compact('category'));
        }

        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id
        ]);

        $category->update([
            'name' => $request->name
        ]);

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Category updated successfully.']);
        }

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->posts()->update(['category_id' => null]);
        $category->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Category deleted successfully.']);
        }

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
