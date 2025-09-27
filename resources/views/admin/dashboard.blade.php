@extends('layouts.admin')
@section('content')
<style>
    /* ====== Layout Base ====== */
    .main-content-inner {
        padding: 20px;
    }

    .main-content-wrap {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    .tf-section-2,
    .tf-section {
        width: 100%;
    }

    /* ====== Revenue Box ====== */
    .revenue-box {
        padding: 25px;
        border-radius: 14px;
        background: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        margin-top: 25px;
    }

    .revenue-box h5 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #212529;
    }

    .revenue-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }

    .stat-card {
        background: #f9fbfd;
        padding: 15px;
        border-radius: 12px;
        text-align: center;
        transition: 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        background: #f1f5ff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .stat-card .stat-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin: 0 auto 6px;
    }

    .stat-card.total .stat-dot {
        background: #2377FC;
    }

    .stat-card.pending .stat-dot {
        background: #FFA500;
    }

    .stat-card.delivered .stat-dot {
        background: #078407;
    }

    .stat-card.canceled .stat-dot {
        background: #FF0000;
    }

    .stat-label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        color: #6c757d;
        margin-bottom: 4px;
    }

    .stat-card h4 {
        font-size: 20px;
        font-weight: 600;
        color: #212529;
        margin: 0;
    }

    .chart-container {
        height: 350px;
    }

    /* ====== Orders Summary Cards ====== */
    .wg-chart-default {
        padding: 20px;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        transition: 0.3s;
    }

    .wg-chart-default:hover {
        transform: translateY(-3px);
        background: #f9fafc;
    }

    .wg-chart-default .body-text {
        font-size: 14px;
        font-weight: 500;
        color: #6c757d;
    }

    .wg-chart-default h4 {
        font-size: 22px;
        font-weight: 700;
        color: #212529;
    }

    .ic-bg {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #eef3ff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #2377FC;
    }

    /* ====== Recent Orders Table ====== */
    .wg-table {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .wg-table h5 {
        font-size: 18px;
        font-weight: 600;
        color: #212529;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table thead th {
        font-size: 14px;
        font-weight: 600;
        background: #f4f6f9;
        color: #212529;
        padding: 12px;
        text-align: center;
    }

    .table tbody td {
        font-size: 14px;
        color: #495057;
        padding: 12px;
        text-align: center;
        vertical-align: middle;
    }

    .table-striped tbody tr:nth-child(odd) {
        background-color: #fafbfc;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge.bg-success {
        background: #d1f7d6;
        color: #078407;
    }

    .badge.bg-danger {
        background: #ffd6d6;
        color: #e60000;
    }

    .badge.bg-warning {
        background: #fff3cd;
        color: #856404;
    }

    /* ====== Responsive Design ====== */
    @media (max-width: 1200px) {
        .revenue-stats {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .w-half {
            width: 100%;
        }

        .revenue-stats {
            grid-template-columns: 1fr;
        }

        .wg-chart-default {
            padding: 15px;
        }

        .wg-chart-default h4 {
            font-size: 18px;
        }

        .table thead {
            display: none;
        }

        .table tbody tr {
            display: flex;
            flex-direction: column;
            margin-bottom: 12px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .table tbody td {
            text-align: left;
            padding: 8px 5px;
        }
    }

    @media (max-width: 480px) {
        .main-content-inner {
            padding: 10px;
        }

        .wg-chart-default,
        .revenue-box,
        .wg-table {
            padding: 12px;
        }

        .wg-chart-default h4,
        .stat-card h4 {
            font-size: 16px;
        }
    }
</style>


    <div class="main-content-inner">

        <div class="main-content-wrap">
            <div class="tf-section-2 mb-30">
                <div class="flex gap20 flex-wrap-mobile">
                    <div class="w-half">

                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-shopping-bag"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Total Orders</div>
                                        <h4>{{ $dashboardDatas[0]->Total }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-dollar-sign"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Total Amount</div>
                                        <h4>{{ $dashboardDatas[0]->TotalAmount }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-shopping-bag"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Pending Orders</div>
                                        <h4>{{ $dashboardDatas[0]->TotalOrdered }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="wg-chart-default">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-dollar-sign"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Pending Orders Amount</div>
                                        <h4>{{ $dashboardDatas[0]->TotalOrderedAmount }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="w-half">

                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-shopping-bag"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Delivered Orders</div>
                                        <h4>{{ $dashboardDatas[0]->TotalDelivered }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-dollar-sign"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Delivered Orders Amount</div>
                                        <h4>{{ $dashboardDatas[0]->TotalDeliveredAmount }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="wg-chart-default mb-20">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-shopping-bag"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Canceled Orders</div>
                                        <h4>{{ $dashboardDatas[0]->TotalCanceled }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="wg-chart-default">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap14">
                                    <div class="image ic-bg">
                                        <i class="icon-dollar-sign"></i>
                                    </div>
                                    <div>
                                        <div class="body-text mb-2">Canceled Orders Amount</div>
                                        <h4>{{ $dashboardDatas[0]->TotalCanceledAmount }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="wg-box">
                    <div class="flex items-center justify-between">
                        <h5>Monthly Revenue</h5>
                    </div>
                    <div class="flex flex-wrap gap40">
                        <div>
                            <div class="mb-2">
                                <div class="block-legend">
                                    <div class="dot t1"></div>
                                    <div class="text-tiny">Total</div>
                                </div>
                            </div>
                            <div class="flex items-center gap10">
                                <h4>${{ $TotalAmount }}</h4>

                            </div>
                        </div>
                        <div>
                            <div class="mb-2">
                                <div class="block-legend">
                                    <div class="dot t2"></div>
                                    <div class="text-tiny">Pending</div>
                                </div>
                            </div>
                            <div class="flex items-center gap10">
                                <h4>${{ $TotalOrderedAmount }}</h4>

                            </div>
                        </div>
                        <div>
                            <div class="mb-2">
                                <div class="block-legend">
                                    <div class="dot t2"></div>
                                    <div class="text-tiny">Delivered</div>
                                </div>
                            </div>
                            <div class="flex items-center gap10">
                                <h4>${{ $TotalDeliveredAmount }}</h4>

                            </div>
                        </div>
                        <div>
                            <div class="mb-2">
                                <div class="block-legend">
                                    <div class="dot t2"></div>
                                    <div class="text-tiny">Canceled</div>
                                </div>
                            </div>
                            <div class="flex items-center gap10">
                                <h4>${{ $TotalCanceledAmount }}</h4>

                            </div>
                        </div>
                    </div>
                    <div id="line-chart-8"></div>
                </div>

            </div>
            <div class="tf-section mb-30">

                <div class="wg-box">
                    <div class="flex items-center justify-between">
                        <h5>Recent orders</h5>
                        <div class="dropdown default">
                            <a class="btn btn-secondary dropdown-toggle" href="{{ route('admin.order') }}">
                                <span class="view-all">View all</span>
                            </a>
                        </div>
                    </div>
                    <div class="wg-table table-all-user">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th class="text-center">OrderNo</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Phone</th>
                                        <th class="text-center">Subtotal</th>
                                        <th class="text-center">Tax</th>
                                        <th class="text-center">Total</th>

                                        <th class="text-center">Status</th>
                                        <th class="text-center">Order Date</th>
                                        <th class="text-center">Total Items</th>
                                        <th class="text-center">Delivered On</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td class="text-center">{{ $order->id }}</td>
                                            <td class="text-center">{{ $order->name }}</td>
                                            <td class="text-center">{{ $order->phone }}</td>
                                            <td class="text-center">${{ $order->subtotal }}</td>
                                            <td class="text-center">${{ $order->tax }}</td>
                                            <td class="text-center">${{ $order->total }}</td>
                                            <td>
                                                @if ($order->status == 'delivered')
                                                    <span class="badge bg-success">Delivered</span>
                                                @elseif($order->status == 'canceled')
                                                    <span class="badge bg-danger">Canceled</span>
                                                @else
                                                    <span class="badge bg-warning">Ordered</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $order->created_at }}</td>
                                            <td class="text-center">{{ $order->orderItems->count() }}</td>
                                            <td class="text-center">{{ $order->delivered_date }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('admin.order-detail', ['order_id' => $order->id]) }}">
                                                    <div class="list-icon-function view-icon">
                                                        <div class="item eye">
                                                            <i class="icon-eye"></i>
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        (function ($) {
            var tfLineChart = (function () {
                var chartBar = function () {
                    var options = {
                        series: [{
                            name: 'Total',
                            data: [{!! $AmountM !!}]
                        },
                        {
                            name: 'Pending',
                            data: [{!! $OrderedAmountM !!}]
                        },
                        {
                            name: 'Delivered',
                            data: [{!! $DeliveredAmountM !!}]
                        },
                        {
                            name: 'Canceled',
                            data: [{!! $CanceledAmountM !!}]
                        }
                        ],
                        chart: {
                            type: 'bar',
                            height: 325,
                            toolbar: {
                                show: false,
                            },
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '10px',
                                endingShape: 'rounded'
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        legend: {
                            show: false,
                        },
                        colors: ['#2377FC', '#FFA500', '#078407', '#FF0000'],
                        stroke: {
                            show: false,
                        },
                        xaxis: {
                            labels: {
                                style: {
                                    colors: '#212529',
                                },
                            },
                            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep',
                                'Oct', 'Nov', 'Dec'
                            ],
                        },
                        yaxis: {
                            show: false,
                        },
                        fill: {
                            opacity: 1
                        },
                        tooltip: {
                            y: {
                                formatter: function (val) {
                                    return "$ " + val;
                                }
                            }
                        }
                    };

                    if ($("#line-chart-8").length > 0) {
                        var chart = new ApexCharts(document.querySelector("#line-chart-8"), options);
                        chart.render();
                    }
                };

                return {
                    init: function () { },
                    load: function () {
                        chartBar();
                    },
                    resize: function () { }
                };
            })();

            $(document).ready(function () { });
            $(window).on("load", function () {
                tfLineChart.load();
            });
            $(window).on("resize", function () { });
        })(jQuery);

    </script>
@endpush
