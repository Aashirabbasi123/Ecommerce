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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlacedMail;
use App\Models\Category;

class CartController extends Controller
{
    public function cart()
    {
        $items = session()->get('cart', []);
        $categories = Category::all();

        // Ensure checkout session is calculated
        $this->setAmountForCheckout();

        // Get checkout with a safe default
        $checkout = session()->get('checkout', [
            'discount' => 0,
            'subtotal' => 0,
            'shipping' => 0,
            'shipping_message' => 'Free Shipping',
            'total' => 0,
        ]);

        return view('user.cart', compact('items', 'categories', 'checkout'));
    }


    public function add_to_cart(Request $request)
    {
        $cart = session()->get('cart', []);
        $id = $request->id;

        // 🛠️ Quantity ko int me convert karo aur minimum 3 enforce karo
        $requestedQty = (int) $request->quantity;
        if ($requestedQty < 1) {
            $requestedQty = 1;
        }

        // 🧠 Agar product already cart me hai
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $requestedQty;
        } else {
            // 🎯 Ab koi limit nahi — jitni bheji user ne, wohi jayegi (minimum 3)
            $cart[$id] = [
                'id' => $id,
                'name' => $request->name,
                'price' => $request->price,
                'quantity' => $requestedQty,
                'image' => $request->image,
                'cutting_option' => $request->cutting_option,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart')->with('success', 'Product added to cart!');
    }


    public function increase_quantity($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            // ✅ quantity ko freely increase kar sakta hai
            $cart[$id]['quantity'] += 1;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Quantity Increased!');
        }

        return redirect()->back()->with('error', 'Product not found in cart!');
    }

    public function decrease_quantity($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $currentQty = $cart[$id]['quantity'];

            // ✅ agar 5 se zyada hai to 1 kam karo
            if ($currentQty > 3) {
                $cart[$id]['quantity'] = $currentQty - 1;
            } else {
                // ✅ agar 5 ya 5 se kam hai to fix 5 hi rakho
                $cart[$id]['quantity'] = 3;
            }

            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Quantity Updated!');
        }

        return redirect()->back()->with('error', 'Product not found in cart!');
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
            $totalAfterDiscount = $subtotalAfterDiscount;

            Session::put('discounts', [
                'discount' => number_format($discount, 2, '.', ''),
                'subtotal' => number_format($subtotalAfterDiscount, 2, '.', ''),
                'tax' => 0, // tax removed, still set as 0 for compatibility
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

        // ensure checkout session calculate ho
        $this->setAmountForCheckout();

        $address = Address::where('user_id', Auth::user()->id)->where('isdefault', 1)->first();
        $checkout = session()->get('checkout', [
            'discount' => 0,
            'subtotal' => 0,
            'shipping' => 0,
            'shipping_message' => 'Free Shipping',
            'total' => 0,
        ]);

        return view('user.checkout', compact('address', 'checkout'));
    }


    public function place_an_order(Request $request)
    {
        $user_id = Auth::user()->id;
        $address = Address::where('user_id', $user_id)->
            where('isdefault', true)->first();

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

        // ✅ Create Order
        $order = new Order();
        $order->user_id = $user_id;
        $order->subtotal = $checkout['subtotal'];
        $order->discount = $checkout['discount'];
        $order->shipping = $checkout['shipping'];
        $order->total = $checkout['total'];
        $order->tax = 0;
        $order->name = $address->name;
        $order->phone = $address->phone;
        $order->address = $address->address;
        $order->city = $address->city;
        $order->state = $address->state;
        $order->status = 'pending';
        $order->save();

        // ✅ Save Order Items
        foreach ($cart as $item) {
            $orderItem = new OrderItem();
            $orderItem->product_id = $item['id'];
            $orderItem->order_id = $order->id;
            $orderItem->price = $item['price'];
            $orderItem->quantity = $item['quantity'];
            $orderItem->cutting_option = $item['cutting_option'] ?? null;
            $orderItem->save();
        }

        // ✅ Save Transaction
        if (in_array($request->mode, ['Cash_On_delivery', 'card', 'Easypaisa'])) {
            $transaction = new Transaction();
            $transaction->user_id = $user_id;
            $transaction->order_id = $order->id;
            $transaction->mode = $request->mode;
            $transaction->status = $request->mode === 'Cash_On_delivery' ? 'pending' : 'paid';
            $transaction->save();
        }

        // ✅ Send Email
        $order->loadMissing(['orderItems.product']);
        try {
            Mail::to(Auth::user()->email)
                ->cc(env('MAIL_FROM_ADDRESS'))
                ->send(new OrderPlacedMail($order));
        } catch (\Exception $e) {
            \Log::error('Email sending failed: ' . $e->getMessage());
        }

        // ✅ Clear Cart
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

        // ✅ Discount check
        $discount = 0;
        if (Session::has('discounts')) {
            $discount = Session::get('discounts')['discount'];
            $subtotal = Session::get('discounts')['subtotal'];
        }

        // ✅ Shipping logic
        if ($subtotal >= 5000) {
            $shipping = 0;
            $shipping_message = "Free Shipping";
        } else {
            $shipping = 250;
            $shipping_message = "";
        }

        // ✅ Total after shipping
        $total = $subtotal - $discount + $shipping;

        Session::put('checkout', [
            'discount' => $discount,
            'subtotal' => round($subtotal, 2),
            'shipping' => $shipping,
            'shipping_message' => $shipping_message,
            'total' => round($total, 2),
        ]);
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
