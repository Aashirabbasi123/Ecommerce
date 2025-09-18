<x-mail::message>
    # 🧾 Order Confirmation

    Hello {{ $order->name }},

    Thank you for shopping with us. Your order has been placed successfully! 🎉

    ---

    ### 🧾 Order Summary
    **Order ID:** {{ $order->id }}
    **Total Amount:** Rs {{ $order->total }}

    ---

    ### 📦 Shipping Details
    **Name:** {{ $order->name }}
    **Phone:** {{ $order->phone }}
    **Address:** {{ $order->address }}, {{ $order->city }}, {{ $order->state }}

    ---

    ### 🛍️ Items Ordered

    @foreach($order->orderItems as $item)
        **Product:** {{ $item->product->name }}
        **Quantity:** {{ $item->quantity }}
        **Price:** Rs {{ $item->price }}
        <!-- **Cutting Option:**
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

        - {{ $cuttingOptionMap[$item->cutting_option] ?? 'N/A' }} -->

        ---

    @endforeach

    <x-mail::button :url="url('/orders/' . $order->id)">
        📄 View Your Order
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
