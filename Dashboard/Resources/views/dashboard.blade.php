@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3> {{ $statistics['lastMonthCount'] }} <span class="no-bold" style="font-size: 14px;"> visits</span></h3>
                    <p>Durring last month</p>
                </div>
                <a href="javascript:void(0)" class="small-box-footer" style="opacity: 0;"><span>Products <i class="fa fa-arrow-circle-right"></i></span></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3> {{ $statistics['lastDayCount'] }} <span class="no-bold" style="font-size: 14px;"> visits</span></h3>
                    <p>Today</p>
                </div>
                <a href="javascript:void(0)" class="small-box-footer" style="opacity: 0;">Orders <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3> {{ $statistics['all'] }} <span class="no-bold" style="font-size: 14px;"> visits</span></h3>
                    <p> In database</p>
                </div>
                <a href="javascript:void(0)" class="small-box-footer" style="opacity: 0;">News <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3> {{ $statistics['uniqueIpAddresses'] }} <span class="no-bold" style="font-size: 14px;"> unique visitors</span></h3>
                    <p> In last 6 months</p>
                </div>
                <a href="javascript:void(0)" class="small-box-footer" style="opacity: 0;">{{ trans('dashboard::messages.more_info') }} <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Visits</h3>
                </div>
                <div class="box-body">
                    <div id="bar-chart" style="height: 450px;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Most visiting cities</h3>
                </div>
                <div class="box-body chart-responsive">
                    <div class="chart" id="sales-chart" style="height: 300px; position: relative;"></div>
                </div>
            </div>
        </div>
    </div>  
@stop

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.categories.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    @parent
    <script type="text/javascript">
        $(document).ready(function () {
            
            var bar_data = {
              data: {!! $statistics['perMonth'] !!},
              color: "#3c8dbc"
            };
            $.plot("#bar-chart", [bar_data], {
              grid: {
                borderWidth: 1,
                borderColor: "#f3f3f3",
                tickColor: "#f3f3f3"
              },
              series: {
                bars: {
                  show: true,
                  barWidth: 0.5,
                  align: "center"
                }
              },
              xaxis: {
                mode: "categories",
                tickLength: 0
              }
            });
            
            var donut = new Morris.Donut({
              element: 'sales-chart',
              resize: true,
              colors: ["#3c8dbc", "#f56954", "#00a65a"],
              data: [
                {label: "Download Sales", value: 12},
                {label: "In-Store Sales", value: 30},
                {label: "Mail-Order Sales", value: 20}
              ],
              hideHover: 'auto'
            });

        });
    </script>
@stop