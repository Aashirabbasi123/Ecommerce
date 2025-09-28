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
    <div class="container-fluid py-4">
        <div class="row">
            <!-- Total Orders -->
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <h6 class="text-uppercase text-muted mb-1">Total Orders</h6>
                        <h2 class="mb-0">{{ $dashboardDatas[0]->Total ?? 0 }}</h2>
                    </div>
                </div>
            </div>

            <!-- Pending Orders -->
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <h6 class="text-uppercase text-warning mb-1">Pending Orders</h6>
                        <h2 class="mb-0">{{ $dashboardDatas[0]->TotalPending ?? 0 }}</h2>
                        <small class="text-muted">Rs
                            {{ number_format($dashboardDatas[0]->TotalPendingAmount ?? 0, 0) }}</small>
                    </div>
                </div>
            </div>

            <!-- Delivered Orders -->
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <h6 class="text-uppercase text-success mb-1">Delivered Orders</h6>
                        <h2 class="mb-0">{{ $dashboardDatas[0]->TotalDelivered ?? 0 }}</h2>
                        <small class="text-muted">Rs
                            {{ number_format($dashboardDatas[0]->TotalDeliveredAmount ?? 0, 0) }}</small>
                    </div>
                </div>
            </div>

            <!-- Canceled Orders -->
            <div class="col-xl-3 col-sm-6 mb-4">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <h6 class="text-uppercase text-danger mb-1">Canceled Orders</h6>
                        <h2 class="mb-0">{{ $dashboardDatas[0]->TotalCanceled ?? 0 }}</h2>
                        <small class="text-muted">Rs
                            {{ number_format($dashboardDatas[0]->TotalCanceledAmount ?? 0, 0) }}</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Recent Orders</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-items-center table-bordered mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Order #</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->name }}</td>
                                            <td>{{ $order->phone }}</td>
                                            <td>Rs {{ number_format($order->total, 0) }}</td>
                                            <td>
                                                @if($order->status == 'delivered')
                                                    <span class="badge bg-success">Delivered</span>
                                                @elseif($order->status == 'canceled')
                                                    <span class="badge bg-danger">Canceled</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @endif
                                            </td>
                                            <td>{{ $order->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No orders found</td>
                                        </tr>
                                    @endforelse
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
                            data: [{!! $PendingAmountM !!}]
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
