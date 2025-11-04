<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class WishlistController extends Controller
{
    public function wishlist()
    {
        $items = session()->get('wishlist', []);
        $categories = Category::all();
        return view('user.wishlist', compact('items', 'categories'));
    }

    public function add_to_wishlist(Request $request)
    {
        $wishlist = session()->get('wishlist', []);

        $productId = $request->id;

        // Quantity fix: always min 3
        $qty = (int) $request->quantity;
        if ($qty < 3) {
            $qty = 3;
        }

        if (!isset($wishlist[$productId])) {
            $wishlist[$productId] = [
                'id' => $productId,
                'name' => $request->name,
                'quantity' => $qty,
                'price' => $request->price,
                'image' => $request->image,
            ];
        }

        session()->put('wishlist', $wishlist);

        return redirect()->back()->with('success', 'Product added to wishlist!');
    }

    public function remove_from_wishlist($id)
    {
        $wishlist = session()->get('wishlist', []);
        if (isset($wishlist[$id])) {
            unset($wishlist[$id]);
            session()->put('wishlist', $wishlist);
        }

        return redirect()->back()->with('success', 'Item removed from wishlist!');
    }

    public function empty_wishlist()
    {
        session()->forget('wishlist');
        return redirect()->back();
    }
    public function move_to_cart($id)
    {
        $wishlist = session()->get('wishlist', []);
        $cart = session()->get('cart', []);

        if (isset($wishlist[$id])) {
            $item = $wishlist[$id];

            unset($wishlist[$id]);
            session()->put('wishlist', $wishlist);

            $wantedQty = isset($item['quantity']) ? (int) $item['quantity'] : 3;
            $qtyToAdd = max(3, $wantedQty);

            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = (int) $cart[$id]['quantity'] + $qtyToAdd;
            } else {
                $cart[$id] = [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'image' => $item['image'] ?? null,
                    'quantity' => $qtyToAdd,
                ];
            }

            session()->put('cart', $cart);

            session()->flash('success', 'Item moved to cart (qty: ' . $qtyToAdd . ')!');
        } else {
            session()->flash('error', 'Item not found in wishlist.');
        }

        return redirect()->back();
    }
}
