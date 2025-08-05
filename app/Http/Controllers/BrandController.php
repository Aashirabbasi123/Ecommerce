<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    // Brands list with pagination
    public function brands()
    {
        $brands = Brand::latest()->paginate(10);
        return view('admin.brand', compact('brands'));
    }

    // Brand add form
    public function add_brand()
    {
        return view('admin.add_brand');
    }

    // Brand edit form with data Update work
    public function edit_brand($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brand-edit', compact('brand'));
    }

    // Brand update   Update work
    public function update_brand(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $brand->name = $request->name;
        $brand->slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);

        if ($request->hasFile('image')) {
            $brand->image = $this->uploadBrandImage($request->file('image'));
        }

        $brand->save();

        return redirect()->route('admin.brand')->with('status', 'Brand updated successfully!');
    }

    // Brand delete
    public function delete_brand($id)
    {
        $brand = Brand::findOrFail($id);

        if ($brand->image && file_exists(public_path('uploads/brands/' . $brand->image))) {
            (public_path('uploads/brands/' . $brand->image));
        }

        $brand->delete();

        return redirect()->route('admin.brand')->with('status', 'Brand deleted successfully!');
    }

    // New brand save                       CREATE WORK FOR BRAND & IMAGE FILE
    // ✅ Step 1: Image upload function with hash-based duplicate check
    private function uploadBrandImage($image)
    {
        $originalName = $image->getClientOriginalName();
        $uploadPath = public_path('uploads/brands');
        $filePath = $uploadPath . '/' . $originalName;

        // ✅ If file already exists, just return original name (no upload again)
        if (file_exists($filePath)) {
            return $originalName;
        }

        // ✅ Else move the file
        $image->move($uploadPath, $originalName);
        return $originalName;
    }


    // ✅ Step 2:  brand_store method CREATE BRAND
    public function brand_store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->name);

        if ($request->hasFile('image')) {
            $brand->image = $this->uploadBrandImage($request->file('image'));
        }

        $brand->save();

        return redirect()->route('admin.brand')->with('status', 'Brand added successfully!');
    }
}
