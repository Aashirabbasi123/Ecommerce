@extends('user.components.master')
@section('content')
    @include('user.components.navbar')
    <style>
        .table> :not(caption)>tr>th {
            padding: 0.625rem 1.5rem .625rem !important;
            background-color: #6a6e51 !important;
        }

        .status-ordered {
            background-color: #ffe066;
            width: 10px;
            color: #000000;
        }

        .table>tr>td {
            padding: 0.625rem 1.5rem .625rem !important;
        }

        .table-bordered> :not(caption)>tr>th,
        .table-bordered> :not(caption)>tr>td {
            border-width: 1px 1px;
            border-color: #6a6e51;
        }

        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .tf-button {
            background-color: #0d6efd;
            color: #fff;
            padding: 8px 20px;
            border-radius: 6px;
            font-weight: 500;
            text-decoration: none;
            transition: 0.3s;
        }

        .tf-button:hover {
            background-color: #0056b3;
            color: #fff;
        }

        .table> :not(caption)>tr>td {
            padding: .8rem 1rem !important;
        }

        .bg-success {
            background-color: #40c710 !important;
        }

        .bg-danger {
            background-color: #f44032 !important;
        }

        .bg-warning {
            background-color: #f5d700 !important;
            color: #000;
        }
    </style>

    <main class="pt-90" style="padding-top: 0;">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <div class="row">
                <div class="col-lg-2">
                    @include('user.components.user_nav')
                </div>
                <div class="col-lg-10">
                    @if (session('status'))
                        @push('scripts')
                            <script>
                                swal("Success", "{{ session('status') }}", "success");
                            </script>
                        @endpush
                    @endif

                    <div class="wg-box" style="overflow-x: auto;">
                        <div class="header-row">
                            <div class="wg-filter flex-grow">
                                <h5>Ordered Details</h5>
                            </div>
                            <a class="tf-button style-1 w208" href="{{ route('user.orders') }}">Back</a>
                        </div>

                        <div class="table-responsive">
                            @if (session()->has('status'))
                                <p class="alert alert-success">{{ session('status') }}</p>
                            @endif
                            <table class="table table-bordered table-striped align-middle"style="min-width: 600px;">
                                <tbody>
                                    <tr>
                                        <th>Order No</th>
                                        <td>{{ $order->id }}</td>
                                        <th>Mobile</th>
                                        <td>{{ $order->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th style="color:#000">Order Date</th>
                                        <td>{{ $order->created_at }}</td>
                                        <th style="color:#000">Delivered Date</th>
                                        <td>{{ $order->delivered_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>Canceled Date</th>
                                        <td>{{ $order->canceled_date }}</td>
                                        <th>Order Status</th>
                                        <td>
                                            @if ($order->status == 'delivered')
                                                <span class="badge bg-success">Delivered</span>
                                            @elseif($order->status == 'canceled')
                                                <span class="badge bg-danger">Canceled</span>
                                            @else
                                                <span class="badge bg-warning ">Ordered</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="wg-box mt-5" style="overflow-x: auto;">
                        <div class="flex items-center justify-between gap10 flex-wrap">
                            <div class="wg-filter flex-grow">
                                <h5>Ordered Items</h5>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered"style="min-width: 600px;">
                                <thead>
                                    <tr>
                                        <th class="text-center"style="width:200px">Name</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-center">SKU</th>
                                        <th class="text-center">Category</th>
                                        <th class="text-center">Brand</th>
                                        <th class="text-center">Options</th>
                                        <th class="text-center">Return Status</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->orderItems as $item)
                                        <tr>
                                            <td class="pname">
                                                <div class="image">
                                                    <img src="{{ asset('uploads/product/' . $item->product->image) }}"
                                                        alt="{{ $item->product->name }}" class="image">
                                                </div>
                                                <div class="name">
                                                    <a href="{{ route('detailpage', ['product_slug' => $item->product->slug]) }}"
                                                        target="_blank" class="body-title-2">{{ $item->product->name }}</a>
                                                </div>
                                            </td>
                                            <td class="text-center">${{ $item->price }}</td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-center">{{ $item->product->SKU }}</td>
                                            <td class="text-center">{{ $item->product->category->name }}</td>
                                            <td class="text-center">{{ $item->product->brand->name }}</td>
                                            <td class="text-center">{{ $item->options }}</td>
                                            <td class="text-center">{{ $item->status == 0 ? 'No' : 'Yes' }}</td>
                                            <td class="text-center">
                                                <div class="list-icon-function view-icon">
                                                    <div class="item eye">
                                                        <i class="fa fa-eye"></i>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="divider"></div>
                        <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                            {{ $orderItems->links('pagination::bootstrap-5') }}
                        </div>
                    </div>

                    <div class="wg-box mt-5">
                        <h5>Shipping Address</h5>
                        <div class="my-account__address-item col-md-6">
                            <div class="my-account__address-item__detail">
                                @if ($address)
                                    <p>{{ $address->name }}</p>
                                    <p>{{ $address->address }}</p>
                                    <p>{{ $address->city }}, {{ $address->state }}</p>
                                    <br>
                                    <p>Mobile: {{ $address->phone }}</p>
                                @else
                                    <p><strong>No shipping address found.</strong></p>
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="wg-box mt-5" style="overflow-x: auto;">
                        <h5 class="mb-3">Transaction Summary</h5>
                        <table class="table table-bordered table-striped align-middle" style="min-width: 600px;">
                            <tbody>
                                <tr>
                                    <th>Subtotal</th>
                                    <td>${{ $order->subtotal }}</td>
                                    <th>Tax</th>
                                    <td>${{ $order->tax }}</td>
                                    <th>Discount</th>
                                    <td>${{ $order->discount }}</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>${{ $order->total }}</td>
                                    <th>Payment Mode</th>
                                    <td>{{ $transaction->mode }}</td>
                                    <th>Status</th>
                                    <td>
                                        @if ($transaction->status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($transaction->status == 'declined')
                                            <span class="badge bg-danger">Declined</span>
                                        @elseif($transaction->status == 'refunded')
                                            <span class="badge bg-secondary">Refunded</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @php
                        $cancelDeadline = $order->created_at->addMinutes(5);
                    @endphp
                    @if ($order->status == 'ordered' && now()->lessThan($cancelDeadline))
                        <div class="wg-box mt-5 text-right">
                            <form action="{{ route('user.cancel.order') }}" method="POST" class="cancel-form">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="order_id" value="{{ $order->id }}" />
                                <button type="button" class="btn btn-danger cancel-order">Cancel Order</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
    @include('user.components.footer')
@endsection
@push('scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        $(function() {
            $('.cancel-order').on('click', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                swal({
                    title: "Are you sure?",
                    text: "You want to cancel this order?",
                    type: "warning",
                    buttons: ["No", "Yes"],
                    confirmButtonColor: "#dc3545"
                }).then(function(result) {
                    if (result) {
                        form.submit();
                    }
                });
            });
            $('.cancel-order').on('click', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                swal({
                    title: "Are you sure?",
                    text: "You want to cancel this order?",
                    icon: "warning",
                    buttons: ["No", "Yes"],
                    dangerMode: true,
                }).then(function(willCancel) {
                    if (willCancel) {
                        form.submit();
                    }
                });
            });

        });
    </script>
@endpush
