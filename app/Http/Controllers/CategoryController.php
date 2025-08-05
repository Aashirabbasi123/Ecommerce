<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
//   -------------------- category --------------------  \\\

    public function categories()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.categories', compact('categories'));
    }

    public function add_category()
    {
        return view('admin.add_category');
    }
    // New category save
    // ✅ Step 1: Image upload function with hash-based duplicate check
    private function uploadCategoryImage($image)
    {
        $originalName = $image->getClientOriginalName();
        $uploadPath = public_path('uploads/category');
        $filePath = $uploadPath . '/' . $originalName;

        // ✅ If file already exists, just return original name (no upload again)
        if (file_exists($filePath)) {
            return $originalName;
        }

        // ✅ Else move the file
        $image->move($uploadPath, $originalName);
        return $originalName;
    }


    // ✅ Step 2: Updated category_store method
    public function category_store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);

        if ($request->hasFile('image')) {
            $category->image = $this->uploadCategoryImage($request->file('image'));
        }

        $category->save();

        return redirect()->route('admin.categories')->with('status', 'category added successfully!');
    }
    // category edit form with data
    public function edit_category($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category-edit', compact('category'));
    }

    // categoryupdate
    public function update_category(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $category->name = $request->name;
        $category->slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);

        if ($request->hasFile('image')) {
            $category->image = $this->uploadCategoryImage($request->file('image'));
        }

        $category->save();

        return redirect()->route('admin.categories')->with('status', 'category updated successfully!');
    }

    // category delete
    public function delete_category($id)
    {
        $category = Category::findOrFail($id);

        if ($category->image && file_exists(public_path('uploads/category/' . $category->image))) {
            (public_path('uploads/category/' . $category->image));
        }

        $category->delete();

        return redirect()->route('admin.categories')->with('status', 'category deleted successfully!');
    }
}
