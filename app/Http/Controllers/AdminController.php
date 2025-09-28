<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Coupon;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\Contact;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Dashboard dikhane ke liye
    public function dashboard()
    {
        // Recent 10 orders
        $orders = Order::orderBy("created_at", "desc")->take(10)->get();

        // Summary Counts & Amounts
        $dashboardDatas = DB::select("
        SELECT
            COUNT(*) AS Total,
            SUM(total) AS TotalAmount,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) AS TotalPending,
            SUM(CASE WHEN status = 'pending' THEN total ELSE 0 END) AS TotalPendingAmount,
            SUM(CASE WHEN status = 'delivered' THEN 1 ELSE 0 END) AS TotalDelivered,
            SUM(CASE WHEN status = 'delivered' THEN total ELSE 0 END) AS TotalDeliveredAmount,
            SUM(CASE WHEN status = 'canceled' THEN 1 ELSE 0 END) AS TotalCanceled,
            SUM(CASE WHEN status = 'canceled' THEN total ELSE 0 END) AS TotalCanceledAmount
        FROM orders
    ");

        // Monthly stats (for chart)
        $AmountM = Order::selectRaw("MONTH(created_at) as month, COALESCE(SUM(total),0) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total')
            ->implode(',');

        $PendingAmountM = Order::selectRaw("MONTH(created_at) as month, COALESCE(SUM(total),0) as total")
            ->where('status', 'pending')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total')
            ->implode(',');

        $DeliveredAmountM = Order::selectRaw("MONTH(created_at) as month, COALESCE(SUM(total),0) as total")
            ->where('status', 'delivered')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total')
            ->implode(',');

        $CanceledAmountM = Order::selectRaw("MONTH(created_at) as month, COALESCE(SUM(total),0) as total")
            ->where('status', 'canceled')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total')
            ->implode(',');

        return view("admin.dashboard", compact(
            'orders',
            'dashboardDatas',
            'AmountM',
            'PendingAmountM',
            'DeliveredAmountM',
            'CanceledAmountM'
        ));
    }


    // ✅ New Users Page (Track Registered Users)
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.user', compact('users'));
    }

    // Login page dikhane ke liye
    public function login()
    {
        return view('auth.login1');
    }

    public function coupons()
    {
        $coupons = Coupon::latest()->paginate(10);
        return view('admin.coupons', compact('coupons'));
    }
    public function add_coupons()
    {
        return view('admin.add_coupons');
    }
    public function coupon_store(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'type' => 'required',
            'value' => 'required|numeric',
            'cart_value' => 'required|numeric',
            'expiry_date' => 'required|date'
        ]);

        $coupon = new Coupon();
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->cart_value = $request->cart_value;
        $coupon->expiry_date = $request->expiry_date;
        $coupon->save();

        return redirect()->route('admin.coupons')->with('status', 'Coupon has been added successfully!');
    }
    public function edit_coupon($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupon-edit', compact('coupon'));
    }

    public function update_coupon(Request $request, $id)
    {
        $request->validate([
            'code' => 'required',
            'type' => 'required',
            'value' => 'required|numeric',
            'cart_value' => 'required|numeric',
            'expiry_date' => 'required|date'
        ]);

        $coupon = Coupon::findOrFail($id);
        $coupon->code = $request->code;
        $coupon->type = $request->type;
        $coupon->value = $request->value;
        $coupon->cart_value = $request->cart_value;
        $coupon->expiry_date = $request->expiry_date;
        $coupon->save();

        return redirect()->route('admin.coupons')->with('status', 'Coupon has been updated successfully!');
    }
    public function delete_coupon($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->route('admin.coupons')->with('status', 'Coupon has been deleted successfully!');
    }

    public function order()
    {
        $orders = Order::orderBy('created_at', 'desc')->paginate(12);
        return view('admin.order', compact('orders'));
    }

    public function order_detail($order_id)
    {
        $order = Order::find($order_id);
        $orderItems = OrderItem::where('order_id', $order_id)->orderBy('id')->paginate(12);
        $transaction = Transaction::where('order_id', $order_id)->first();
        $address = Address::where('user_id', $order->user_id)->where('isdefault', true)->first();

        return view('admin.order-detail', compact('order', 'orderItems', 'transaction', 'address'));
    }
    public function update_order_status(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->status = $request->order_status;
        if ($request->order_status == 'delivered') {
            $order->delivered_date = Carbon::now();
        } else if ($request->order_status == 'canceled') {
            $order->canceled_date = Carbon::now();
        }
        $order->save();
        if ($request->order_status == 'delivered') {
            $transaction = Transaction::where('order_id', $request->order_id)->first();
            $transaction->status = 'approved';
            $transaction->save();
        }
        return back()->with("status", "Status changed Sucessfully!");
    }
    public function contacts()
    {
        $contacts = Contact::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.contacts', compact('contacts'));
    }
    public function delete_contact($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.contacts')->with('status', 'contact has been deleted successfully!');
    }
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json([]);
        }

        $results = Product::where('name', 'LIKE', "%{$query}%")
            ->take(8)
            ->get(['id', 'name', 'slug', 'image']);

        return response()->json($results);
    }

}
