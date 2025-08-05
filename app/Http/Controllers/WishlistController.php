<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function wishlist()
    {
        $items = session()->get('wishlist', []);
        return view('user.wishlist', compact('items'));
    }


    public function add_to_wishlist(Request $request)
    {
        $wishlist = session()->get('wishlist', []);

        $productId = $request->id;

        if (!isset($wishlist[$productId])) {
            $wishlist[$productId] = [
                'id' => $productId,
                'name' => $request->name,
                'quantity' => $request->quantity,
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
        // Get wishlist and cart from session
        $wishlist = session()->get('wishlist', []);
        $cart = session()->get('cart', []);

        // Check if product exists in wishlist
        if (isset($wishlist[$id])) {
            $item = $wishlist[$id];

            // Remove from wishlist
            unset($wishlist[$id]);
            session()->put('wishlist', $wishlist);

            // Add to cart (check if already in cart, then increase quantity)
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] += 1;
            } else {
                $cart[$id] = [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'image' => $item['image'] ?? null,
                    'quantity' => 1,
                ];
            }

            session()->put('cart', $cart);

            // Flash message
            session()->flash('success', 'Item moved to cart successfully!');
        } else {
            session()->flash('error', 'Item not found in wishlist.');
        }

        return redirect()->back();
    }




}