<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\CuttingOption;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function products()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products', compact('products'));
    }

    public function add_product()
    {
        $categories = Category::select('id', 'name')->orderBy('name')->get();
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        return view('admin.add_product', compact('categories', 'brands', ));
    }


    public function product_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug',
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required|boolean',
            'quantity' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->slug ?? $request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        if ($request->hasFile('image')) {
            $product->image = $this->uploadProductImage($request->file('image'));
        }

        if ($request->hasFile('images')) {
            $gallery = [];
            foreach ($request->file('images') as $imageFile) {
                $gallery[] = $this->uploadProductImage($imageFile);
            }
            $product->images = implode(',', $gallery);
        }

        // ✅ ADD THIS BLOCK HERE
        if ($request->has('cutting_options')) {
            $product->cutting_options = json_encode($request->cutting_options);
        } else {
            $product->cutting_options = json_encode([]);
        }

        // ✅ Now Save
        $product->save();

        return redirect()->route('admin.products')->with('status', 'Product Added Successfully!');
    }

    public function product_edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        return view('admin.product_edit', compact('product', 'categories', 'brands'));
    }

    public function update_product(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug,' . $id,
            'short_description' => 'required',
            'description' => 'required',
            'regular_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'SKU' => 'required',
            'stock_status' => 'required',
            'featured' => 'required|boolean',
            'quantity' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product->name = $request->name;
        $product->slug = Str::slug($request->slug ?? $request->name);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->SKU = $request->SKU;
        $product->stock_status = $request->stock_status;
        $product->featured = $request->featured;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        // ✅ Save cutting options (admin checkboxes)
        if ($request->has('cutting_options')) {
            $product->cutting_options = json_encode($request->cutting_options);
        } else {
            $product->cutting_options = json_encode([]);
        }

        // ✅ Update main image
        if ($request->hasFile('image')) {
            if ($product->image) {
                $oldPath = public_path('uploads/product/' . $product->image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            $product->image = $this->uploadProductImage($request->file('image'));
        }

        // ✅ Update gallery images
        if ($request->hasFile('images')) {
            // Delete old gallery images from disk
            if ($product->images) {
                foreach (explode(',', $product->images) as $oldImage) {
                    $oldPath = public_path('uploads/product/' . $oldImage);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
            }

            // Upload new gallery images
            $gallery = [];
            foreach ($request->file('images') as $imageFile) {
                $gallery[] = $this->uploadProductImage($imageFile);
            }
            $product->images = implode(',', $gallery);
        }

        $product->save();

        return redirect()->route('admin.products')->with('status', 'Product Updated Successfully!');
    }


    public function delete_product($id)
    {
        $product = Product::findOrFail($id);

        // Delete main image
        if ($product->image) {
            $path = public_path('uploads/product/' . $product->image);
            if (file_exists($path)) {
                @unlink($path);
            }
        }

        // Delete gallery images
        if ($product->images) {
            foreach (explode(',', $product->images) as $imageFile) {
                $path = public_path('uploads/product/' . $imageFile);
                if (file_exists($path)) {
                    @unlink($path);
                }
            }
        }

        $product->delete();

        return redirect()->route('admin.products')->with('status', 'Product Deleted Successfully!');
    }

    private function uploadProductImage($image)
    {
        $uploadPath = public_path('uploads/product');

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }

        $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move($uploadPath, $fileName);
        return $fileName;
    }
}
