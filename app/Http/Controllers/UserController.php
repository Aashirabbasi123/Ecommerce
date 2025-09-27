<?php

namespace App\Http\Controllers;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\slide;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function dashboard()
    {
        $products = Product::latest()->take(10)->get();
        $slides = slide::orderBy('id', 'DESC')->take(5)->get();
        $categories = Category::orderBy('name')->get();
        return view('user.dashboard', compact('products', 'slides', 'categories'));
    }
    public function login()
    {
        return view('auth.login');
    }
    public function useraccount()
    {
        return view('user.useraccount');
    }
    public function detail()
    {
     $categories = Category::all();
    return view('user.detail', compact('categories'));
    }
    public function about()
    {
         $categories = Category::all();
         return view('user.about', compact('categories'));
    }
    public function contact()
    {
         $categories = Category::all();
         return view('user.contact', compact('categories'));
    }
    public function contact_store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits:11',
            'comment' => 'required'
        ]);

        $contact = new Contact();
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->comment = $request->comment;
        $contact->save();

        return redirect()->back()->with('success', 'Your message has been sent successfully');
    }
    public function register()
    {
         $categories = Category::all();
         return view('auth.register', compact('categories'));
    }
    public function orders()
    {
        $orders = Order::with('orderItems')->where('user_id', Auth::id())->orderBy('created_at', 'DESC')->paginate(12);
        return view('user.orders', compact('orders'));
    }
    public function order_detail($order_id)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('id', $order_id)
            ->first();

        if (!$order) {
            return redirect()->route('login');
        }

        $orderItems = OrderItem::where('order_id', $order->id)
            ->orderBy('id')
            ->paginate(12);

        $transaction = Transaction::where('order_id', $order->id)->first();

        // Agar order me address_id column hai
        $address = $order->address_id
            ? Address::find($order->address_id)
            : Address::where('user_id', $order->user_id)->where('isdefault', true)->first();

        return view('user.order-detail', compact('order', 'orderItems', 'transaction', 'address'));
    }

    public function order_cancel(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->status = "canceled";
        $order->canceled_date = Carbon::now();
        $order->save();

        return back()->with("status", "Order has been cancelled successfully!");
    }
}
