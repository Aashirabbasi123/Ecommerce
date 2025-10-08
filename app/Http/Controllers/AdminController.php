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

        // Summary Counts & Amounts (single row)
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

        // make sure we have a safe object
        $stats = $dashboardDatas[0] ?? (object) [
            'Total' => 0,
            'TotalAmount' => 0,
            'TotalPending' => 0,
            'TotalPendingAmount' => 0,
            'TotalDelivered' => 0,
            'TotalDeliveredAmount' => 0,
            'TotalCanceled' => 0,
            'TotalCanceledAmount' => 0,
        ];

        // Variables used in your blade Monthly Revenue boxes (match blade names)
        $TotalAmount = $stats->TotalAmount ?? 0;
        // blade expects $TotalOrderedAmount as "Pending" total — keep that name for compatibility
        $TotalOrderedAmount = $stats->TotalPendingAmount ?? 0;
        $TotalDeliveredAmount = $stats->TotalDeliveredAmount ?? 0;
        $TotalCanceledAmount = $stats->TotalCanceledAmount ?? 0;

        // Monthly rows grouped by label + status
        $rows = Order::selectRaw("
            YEAR(created_at) AS year,
            MONTH(created_at) AS month,
            DATE_FORMAT(created_at, '%b-%Y') AS label,
            status,
            COALESCE(SUM(total),0) AS total
        ")
            ->groupBy('year', 'month', 'label', 'status')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // group rows by label (e.g. "Sep-2025", "Oct-2025")
        $grouped = $rows->groupBy('label');

        $months = $grouped->keys()->toArray();

        $amounts = [];
        $pendingAmounts = [];
        $deliveredAmounts = [];
        $canceledAmounts = [];

        foreach ($months as $label) {
            $sub = $grouped[$label];

            // total for this month (sum of all statuses)
            $amounts[] = (float) $sub->sum('total');

            // per status sums (if not present returns 0)
            $pendingAmounts[] = (float) $sub->where('status', 'pending')->sum('total');
            $deliveredAmounts[] = (float) $sub->where('status', 'delivered')->sum('total');
            $canceledAmounts[] = (float) $sub->where('status', 'canceled')->sum('total');
        }

        // if no months found, provide a safe default so chart won't break
        if (empty($months)) {
            $months = [date('M-Y')];
            $AmountM = '0';
            $PendingAmountM = '0';
            $DeliveredAmountM = '0';
            $CanceledAmountM = '0';
        } else {
            // create comma-separated numbers for ApexCharts usage in blade (kept same style as your blade)
            $AmountM = implode(',', $amounts);
            $PendingAmountM = implode(',', $pendingAmounts);
            $DeliveredAmountM = implode(',', $deliveredAmounts);
            $CanceledAmountM = implode(',', $canceledAmounts);
        }

        return view("admin.dashboard", compact(
            'orders',
            'dashboardDatas',
            'months',
            'AmountM',
            'PendingAmountM',
            'DeliveredAmountM',
            'CanceledAmountM',
            'TotalAmount',
            'TotalOrderedAmount',
            'TotalDeliveredAmount',
            'TotalCanceledAmount'
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

