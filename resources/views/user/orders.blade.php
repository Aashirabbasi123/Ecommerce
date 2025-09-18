@extends('user.components.master')
@section('content')
    @include('user.components.navbar')
    <style>
        .table> :not(caption)>tr>th {
            padding: 0.625rem 1.5rem .625rem !important;
            background-color: #6a6e51 !important;
        }

        .table>tr>td {
            padding: 0.625rem 1.5rem .625rem !important;
        }

        .table-bordered> :not(caption)>tr>th,
        .table-bordered> :not(caption)>tr>td {
            border-width: 1px 1px;
            border-color: #6a6e51;
        }

        .status-ordered {
            background-color: #ffe066;
            width: 10px;
            color: #000000;
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
                    <h2 class="page-title">My Orders</h2>
                    <div class="table-wrapper table-container" style="max-height: 800px; overflow-y: auto;">
                        <table class="table table-striped table-bordered" style="height: 20px">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Subtotal</th>
                                    <!-- <th>Tax</th> -->
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Order Date</th>
                                    <th>Items</th>
                                    <th>Delivered On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->name }}</td>
                                        <td>{{ $order->phone }}</td>
                                        <td>Rs{{ $order->subtotal }}</td>
                                        {{-- <td>${{ $order->tax }}</td> --}}
                                        <td>Rs{{ $order->total }}</td>
                                        <td>
                                            @if ($order->status == 'delivered')
                                                <span class="badge bg-success">Delivered</span>
                                            @elseif($order->status == 'canceled')
                                                <span class="badge bg-danger">Canceled</span>
                                            @else
                                                <span class="badge bg-warning ">Ordered</span>
                                            @endif
                                            {{-- {{ $order->status }} --}}
                                        </td>
                                <td>{{ $order->created_at }}</td>
                                <td>{{ optional($order->orderItems)->count() }}</td>
                                <td>{{ $order->delivered_date }}</td>
                                <td>
                                    <a href="{{ route('user.order-detail', ['order_id' => $order->id]) }}"
                                        title="View Order">
                                        <i class="fa fa-eye eye"></i>
                                    </a>
                                </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="divider mt-4 mb-4"></div>

                    <div class="wgp-pagination d-flex justify-content-between align-items-center flex-wrap gap-2">
                        {{ $orders->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </section>
    </main>
    @include('user.components.footer')
@endsection
