<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\Coupon;
use Carbon\Carbon;

class CartController extends Controller
{
    public function cart()
    {
        $items = session()->get('cart', []);
        return view('user.cart', compact('items'));
    }
    public function add_to_cart(Request $request)
    {
        $cart = session()->get('cart', []);

        $id = $request->id;

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $request->quantity;
        } else {
            $cart[$id] = [
                'id' => $id,
                'name' => $request->name,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'image' => $request->image,

            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product Added to Cart!');
    }
    public function increase_quantity($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += 1;
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Quantity Increased!');
    }

    public function decrease_quantity($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id]) && $cart[$id]['quantity'] > 1) {
            $cart[$id]['quantity'] -= 1;
            session()->put('cart', $cart);
        } elseif (isset($cart[$id]) && $cart[$id]['quantity'] == 1) {
            unset($cart[$id]); //  Quantity 0 pe item remove kar deta hai
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Quantity Updated!');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Item Removed from Cart!');
    }
    public function empty_cart()
    {
        session()->forget('cart');
        return redirect()->back();
    }


    public function apply_coupon_code(Request $request)
    {
        $coupon_code = trim(strtolower($request->coupon_code));

        if (!empty($coupon_code)) {
            $cart = session()->get('cart', []);
            $subtotal = 0;

            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            $coupon = Coupon::whereRaw('LOWER(code) = ?', [$coupon_code])
                ->where('expiry_date', '>=', Carbon::today())
                ->where('cart_value', '<=', $subtotal)
                ->first();

            if (!$coupon) {
                return redirect()->back()->with('error', 'Invalid coupon code!');
            }

            Session::put('coupon', [
                'code' => $coupon->code,
                'type' => $coupon->type,
                'value' => $coupon->value,
                'cart_value' => $coupon->cart_value,
            ]);
            $this->calculateDiscount($subtotal);


            $this->setAmountForCheckout();

            return redirect()->back()->with('success', 'Coupon has been applied');
        }

        return redirect()->back()->with('error', 'Please enter a valid coupon code!');
    }

    public function calculateDiscount($subtotal)
    {
        $discount = 0;

        if (session()->has('coupon')) {
            $coupon = session('coupon');

            if ($coupon['type'] === 'fixed') {
                $discount = floatval($coupon['value']);
            } else {
                $discount = ($subtotal * floatval($coupon['value'])) / 100;
            }

            $subtotalAfterDiscount = $subtotal - $discount;
            $taxRate = config('cart.tax', 0);
            $taxAfterDiscount = ($subtotalAfterDiscount * $taxRate) / 100;
            $totalAfterDiscount = $subtotalAfterDiscount + $taxAfterDiscount;

            Session::put('discounts', [
                'discount' => number_format($discount, 2, '.', ''),
                'subtotal' => number_format($subtotalAfterDiscount, 2, '.', ''),
                'tax' => number_format($taxAfterDiscount, 2, '.', ''),
                'total' => number_format($totalAfterDiscount, 2, '.', '')
            ]);
        }
    }
    public function remove_coupon_code()
    {

        Session::forget('coupon');
        Session::forget('discounts');

        return back()->with('error', 'Coupon has been removed!');
    }

    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $address = Address::where('user_id', Auth::user()->id)->where('isdefault', 1)->first();
        return view('user.checkout', compact('address'));
    }
    public function place_an_order(Request $request)
    {
        $user_id = Auth::user()->id;
        $address = Address::where('user_id', $user_id)->where('isdefault', true)->first();

        if (!$address) {
            $request->validate([
                'name' => 'required|max:100',
                'phone' => 'required|numeric|digits:11',
                'state' => 'required',
                'city' => 'required',
                'address' => 'required',
            ]);

            $address = new Address();
            $address->name = $request->name;
            $address->phone = $request->phone;
            $address->state = $request->state;
            $address->city = $request->city;
            $address->address = $request->address;
            $address->user_id = $user_id;
            $address->isdefault = true;
            $address->save();
        }
        $cart = session()->get('cart', []);
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $this->calculateDiscount($subtotal);
        $this->setAmountForCheckout();

        $checkout = Session::get('checkout');
        if (!$checkout) {
            return redirect()->back()->with('error', 'Checkout session not found. Please try again.');
        }

        // Create Order
        $order = new Order();
        $order->user_id = $user_id;
        $order->subtotal = $checkout['subtotal'];
        $order->discount = $checkout['discount'];
        $order->tax = $checkout['tax'];
        $order->total = $checkout['total'];
        $order->name = $address->name;
        $order->phone = $address->phone;
        $order->address = $address->address;
        $order->city = $address->city;
        $order->state = $address->state;
        $order->save();

        // Save order items
        foreach ($cart as $item) {
            $orderItem = new OrderItem();
            $orderItem->product_id = $item['id'];
            $orderItem->order_id = $order->id;
            $orderItem->price = $item['price'];
            $orderItem->quantity = $item['quantity'];
            $orderItem->save();
        }

        // Save transaction
        if (in_array($request->mode, ['Cash_On_delivery', 'card', 'Easypaisa'])) {
            $transaction = new Transaction();
            $transaction->user_id = $user_id;
            $transaction->order_id = $order->id;
            $transaction->mode = $request->mode;
            $transaction->status = $request->mode === 'Cash_On_delivery' ? 'pending' : 'paid';
            $transaction->save();
        }

        // Clear session
        Session::forget('cart');
        Session::forget('checkout');
        Session::forget('coupon');
        Session::forget('discounts');
        Session::put('order_id', $order->id);

        return redirect()->route('card.confirm.order');
    }

    public function setAmountForCheckout()
    {
        $cart = session()->get('cart', []);

        if (count($cart) == 0) {
            Session::forget('checkout');
            return;
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        if (Session::has('coupon') && Session::has('discounts')) {
            // Use calculated values from calculateDiscount
            Session::put('checkout', [
                'discount' => Session::get('discounts')['discount'],
                'subtotal' => Session::get('discounts')['subtotal'],
                'tax' => Session::get('discounts')['tax'],
                'total' => Session::get('discounts')['total'],
            ]);
        } else {
            // No coupon applied, calculate normally
            $taxRate = config('cart.tax', 0.13);
            $tax = ($subtotal * $taxRate);
            $total = $subtotal + $tax;

            Session::put('checkout', [
                'discount' => 0,
                'subtotal' => round($subtotal, 2),
                'tax' => round($tax, 2),
                'total' => round($total, 2),
            ]);
        }
    }

    public function order_confirm()
    {
        if (Session::has('order_id')) {
            $order = Order::with(['transaction', 'orderItems.product'])->find(Session::get('order_id'));
            return view('user.order_confirm', compact('order'));
        }
        return redirect()->route('cart');
    }
}
