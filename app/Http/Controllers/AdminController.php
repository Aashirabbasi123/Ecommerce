<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Coupon;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Models\OrderItem;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Dashboard dikhane ke liye
    public function dashboard()
    {
        $orders = Order::orderBy("created_at", "desc")->get()->take(10);
        $dashboardDatas = DB::select("Select sum(total) As TotalAmount,
                        sum(if(status='ordered',total,0)) As TotalOrderedAmount,
                        sum(if(status='delivered',total,0)) As TotalDeliveredAmount,
                        sum(if(status='canceled',total,0)) As TotalCanceledAmount,
                        Count(*) As Total,
                        sum(if(status='ordered',1,0)) As TotalOrdered,
                        sum(if(status='delivered',1,0)) As TotalDelivered,
                        sum(if(status='canceled',1,0)) As TotalCanceled
                        From Orders
                    ");
        $monthlyDatas = DB::select("SELECT M.id AS MonthNo, M.name AS MonthName,
                        IFNULL(D.TotalAmount,0) AS TotalAmount,
                        IFNULL(D.TotalOrderedAmount,0) AS TotalOrderedAmount,
                        IFNULL(D.TotalDeliveredAmount,0) AS TotalDeliveredAmount,
                        IFNULL(D.TotalCanceledAmount,0) AS TotalCanceledAmount FROM month_names M
                        LEFT JOIN (Select DATE_FORMAT(created_at, '%b') As MonthName,
                        MONTH(created_at) AS MonthNo,
                        sum(total) AS TotalAmount,
                        sum(if(status='ordered',total,0)) AS TotalOrderedAmount,
                        sum(if(status='delivered',total,0)) AS TotalDeliveredAmount,
                        sum(if(status='canceled',total,0)) AS TotalCanceledAmount
                        From Orders WHERE YEAR(created_at)=YEAR(NOW()) GROUP BY YEAR(created_at), MONTH(created_at), DATE_FORMAT(created_at, '%b')
                        Order By MONTH(created_at)) D On D.MonthNo=M.id"
        );

        $AmountM = implode(',', collect($monthlyDatas)->pluck('TotalAmount')->toArray());
        $OrderedAmountM = implode(',', collect($monthlyDatas)->pluck('TotalOrderedAmount')->toArray());
        $DeliveredAmountM = implode(',', collect($monthlyDatas)->pluck('TotalDeliveredAmount')->toArray());
        $CanceledAmountM = implode(',', collect($monthlyDatas)->pluck('TotalCanceledAmount')->toArray());

        $TotalAmount = collect($monthlyDatas)->sum('TotalAmount');
        $TotalOrderedAmount = collect($monthlyDatas)->sum('TotalOrderedAmount');
        $TotalDeliveredAmount = collect($monthlyDatas)->sum('TotalDeliveredAmount');
        $TotalCanceledAmount = collect($monthlyDatas)->sum('TotalCanceledAmount');

        return view('admin.dashboard', compact('orders', 'dashboardDatas', 'AmountM', 'OrderedAmountM', 'DeliveredAmountM', 'CanceledAmountM', 'TotalAmount', 'TotalOrderedAmount', 'TotalDeliveredAmount', 'TotalCanceledAmount'));
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

}
