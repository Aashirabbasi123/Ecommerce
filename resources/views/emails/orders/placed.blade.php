@component('mail::message')

# 🧾 Order Confirmation

Hello {{ $order->name }},

Thank you for shopping with us. Your order has been placed successfully! 🎉

---

## 🧾 Order Summary

**Order ID:** {{ $order->id }}
**Total Amount:** Rs {{ $order->total }}

---

## 📦 Shipping Details

**Name:** {{ $order->name }}
**Phone:** {{ $order->phone }}
**Address:** {{ $order->address }}, {{ $order->city }}, {{ $order->state }}

---

## 🛍️ Items Ordered

@php
    $cuttingOptionMap = [
        'whole_uncleaned' => 'Whole & Uncleaned',
        'whole_gutted' => 'Whole & Gutted',
        'headless_gutted' => 'Headless & Gutted',
        'slices_with_skin_bone' => 'Slices with Skin & Centre Bone',
        'boneless_biscuits' => 'Boneless Biscuits',
        'boneless_fillet' => 'Boneless Fillet',
        'boneless_fingers' => 'Boneless Fingers',
    ];
@endphp

<table border="1" cellpadding="6" cellspacing="0" width="100%" style="border-collapse: collapse;">
    <thead style="background-color: #f2f2f2;">
        <tr>
            <th align="left">Product</th>
            <th align="left">Quantity</th>
            <th align="left">Price</th>
            <th align="left">Cutting Option</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->orderItems as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rs {{ $item->price }}</td>
                <td>{{ $cuttingOptionMap[$item->cutting_option] ?? 'N/A' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<br>

@component('mail::button', ['url' => url('/orders/' . $order->id)])
📄 View Your Order
@endcomponent

Thanks,<br>
{{ config('app.name') }}

@endcomponent