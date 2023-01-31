@extends('layouts.home')

@section('content')
    @permission($data['permission'])
    <div class="home">
        <div class="row justify-content-center">
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header flex-column align-items-start" style="background: #f2f1ff;">
                        <div class="avatar bg-light-primary p-50 m-0">
                            <div class="avatar-content">
                                <i data-feather='dollar-sign'></i>
                            </div>
                        </div>
                        <h2 class="fw-bolder mt-1">{{ $data['today_sale'] . 'K' }}</h2>
                        <p class="card-text">Today Sale</p>
                    </div>
                    <div id="today_sale"></div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header flex-column align-items-start"  style="background: #f0fff0;">
                        <div class="avatar bg-light-success p-50 m-0">
                            <div class="avatar-content">
                                {{-- <i data-feather='dollar-sign'></i> --}}
                                <img src="{{ asset('assets/images/misc/statistic_3.png') }}" height="20" width="40" alt="Angular" />
                            </div>
                        </div>
                        <h2 class="fw-bolder mt-1">{{ $data['current_week_sale']. 'K' }}</h2>
                        <p class="card-text">Current Week</p>
                    </div>
                    <div id="current_week"></div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header flex-column align-items-start" style="background: #fff4f0;">
                        <div class="avatar bg-light-danger p-50 m-0">
                            <div class="avatar-content">
                                {{-- <i data-feather='dollar-sign'></i> --}}
                                <img src="{{ asset('assets/images/misc/statistic_1.png') }}" height="20" width="40" alt="Angular" />
                            </div>
                        </div>
                        <h2 class="fw-bolder mt-1">{{ $data['last_week_sale']. 'K'}}</h2>
                        <p class="card-text">Last 7 Days</p>
                    </div>
                    <div id="last_seven_days"></div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="card">
                    <div class="card-header flex-column align-items-start" style="background: #fffcf0;">
                        <div class="avatar bg-light-warning p-50 m-0">
                            <div class="avatar-content">
                                {{-- <i data-feather='dollar-sign'></i> --}}
                                <img src="{{ asset('assets/images/misc/statistic_2.png') }}" height="20" width="40" alt="Angular" />
                            </div>
                        </div>
                        <h2 class="fw-bolder mt-1">{{ $data['last_month_sale']. 'K'}}</h2>
                        <p class="card-text">Last Month</p>
                    </div>
                    <div id="last_month"></div>
                </div>
            </div>

        </div>
        <div class="row justify-content-center">
            <div class="col-lg-12 col-12">
                <div class="card card-revenue-budget">
                    {{-- <div class="row mx-0"> --}}
                    <div class="col-md-12 col-12 revenue-report-wrapper">
                        <div class="d-sm-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title mb-50 mb-sm-0">Revenue Report</h4>
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center me-2">
                                    <span class="bullet bullet-primary font-small-3 me-50 cursor-pointer"></span>
                                    <span>Earning</span>
                                </div>
                                <div class="d-flex align-items-center ms-75">
                                    <span class="bullet bullet-warning font-small-3 me-50 cursor-pointer"></span>
                                    <span>Expense</span>
                                </div>
                            </div>
                        </div>
                        <div id="ksd-revenue-report-chart"></div>
                    </div>
                    {{-- </div> --}}
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-6 col-12 ">
                <div class="card card-revenue-budget">
                    <div class="col-12 revenue-report-wrapper">
                        <div id="table-without-card">
                            <h5 class="mb-1">Sold Items</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th><span class="text-primary">Sold</span>/ <span class="text-warning">Remaining</span></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($data['buyable_types'] as $bt )
                                        <tr>
                                            <td>
                                                <img src="{{ $bt['image'] }}" class="me-75" height="20" width="20" />
                                                <span class="fw-bold">{{ $bt['name'] }}</span>
                                            </td>
                                            <td>
                                                <span class="text-primary">{{$bt['sold']}}</span>
                                                /
                                                <span class="text-warning">{{$bt['remain']}}</span>
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
            <div class="col-lg-6 col-12 ">
                <div class="card card-revenue-budget">
                    <div class="col-12 revenue-report-wrapper">
                        <div id="table-without-card">
                            <h5 class="mb-1">Receivable Amount</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Receivables</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($data['buyable_types'] as $bt )
                                        <tr>
                                            <td>
                                                <img src="{{ $bt['image'] }}" class="me-75" height="20" width="20" />
                                                <span class="fw-bold">{{ $bt['name'] }}</span>
                                            </td>
                                            <td>
                                                <span class="text-primary">{{$bt['receivables']}}</span>
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

    </div>
    @endpermission
@endsection
@section('pageJs')
    <!-- BEGIN: Page JS-->
    <script src="{{ asset('pages/dashboard/dashboard-ecommerce.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/js/scripts/cards/card-statistics.min.js') }}"></script>
    <!-- END: Page JS-->
@endsection
@section('script')
    <script>
        var sales = [];
        var saleArr = [];

        var expense = [];
        var expArr = [];

        var months = [];
        var monthsArr = [];

        sales  = <?php echo json_encode($data['earnings']); ?>;
        $.each(sales,function(key,val){
            saleArr.push(val);
        });

        expense  = <?php echo json_encode($data['expense']); ?>;
        $.each(expense,function(key,val){
            // console.log(val);
            expArr.push(val);
        });

        var months = <?php echo json_encode($data['categories']); ?>;
        $.each(months,function(key,val){
            monthsArr.push(val);
        });
        // console.log(monthsArr);

        var $revenueReportChart = document.querySelector('#ksd-revenue-report-chart');
        var $textMutedColor = '#b9b9c3';
        revenueReportChartOptions = {
            chart: {
                height: 230,
                stacked: true,
                type: 'bar',
                toolbar: { show: false }
            },
            plotOptions: {
                bar: {
                    columnWidth: '17%',
                    endingShape: 'rounded'
                },
                distributed: true
            },
            colors: [window.colors.solid.primary, window.colors.solid.warning],
            series: [
                {
                    name: 'Earning',
                    data: saleArr
                },
                {
                    name: 'Expense',
                    data: expArr
                }
            ],
            dataLabels: {
                enabled: false
            },
            legend: {
                show: false
            },
            grid: {
                padding: {
                    top: -20,
                    bottom: -10
                },
                yaxis: {
                    lines: { show: false }
                }
            },
            xaxis: {
                categories: monthsArr,
                labels: {
                    style: {
                        colors: $textMutedColor,
                        fontSize: '0.86rem'
                    }
                },
                axisTicks: {
                    show: false
                },
                axisBorder: {
                    show: false
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: $textMutedColor,
                        fontSize: '0.86rem'
                    }
                }
            }
        };
        revenueReportChart = new ApexCharts($revenueReportChart, revenueReportChartOptions);
        revenueReportChart.render();

    </script>
@endsection

