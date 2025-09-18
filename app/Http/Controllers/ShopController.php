<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function shop(Request $request)
    {
        $size = $request->query("size") ?? 12;
        $f_brands = $request->query("brands") ?? '';
        $f_categories = $request->query("categories") ?? '';
        $order = $request->query("order") ?? -1;

        switch ($order) {
            case 1:
                $o_column = 'created_at';
                $o_order = 'DESC';
                break;
            case 2:
                $o_column = 'created_at';
                $o_order = 'ASC';
                break;
            case 3:
                $o_column = 'sale_price';
                $o_order = 'ASC';
                break;
            case 4:
                $o_column = 'sale_price';
                $o_order = 'DESC';
                break;
            default:
                $o_column = 'id';
                $o_order = 'DESC';
        }

        $brands = Brand::with('products')->orderBy('name', 'ASC')->get();
        $categories = Category::orderBy('name', 'ASC')->get();
        $products = Product::when($f_brands, function ($query) use ($f_brands) {
            $query->whereIn('brand_id', explode(',', $f_brands));
        })
        ->when($f_categories, function ($query) use ($f_categories) {
        $query->whereIn('category_id', explode(',', $f_categories));
        })
        ->orderBy($o_column, $o_order)->paginate($size);

        return view('user.shop', compact('products', 'size', 'order', 'brands', 'f_brands','categories','f_categories'));
    }


    public function detail($product_slug)
    {
        $product = Product::where('slug', $product_slug)->firstOrFail();
        $rproducts = Product::where('slug', '<>', $product_slug)->take(8)->get();

        $previous = Product::where('id', '<', $product->id)->orderBy('id', 'desc')->first();
        $next = Product::where('id', '>', $product->id)->orderBy('id', 'asc')->first();
        $categories = Category::all();
        return view('user.detail', compact('product', 'rproducts', 'previous', 'next','categories'));
    }

}
