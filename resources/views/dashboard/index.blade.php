@extends('dashboard.layouts.master')

@section('content')
	<style type="text/css">
		text[text-anchor="middle"]{
			opacity: 0;
		}
		#scrolling_horizontal h3 {
			color: #407791;
			margin-bottom: 5px;
			font-size: 18px;
		}
		#scrolling_horizontal p {
			margin-bottom: 0px;
		}
		#scrolling_horizontal .input-group {
			justify-content: end;
		}
		.pagination {
    		display: inline-block;
		}

		.pagination a {
			border: 1px solid #ddd; /* Gray */
			color: black;
			float: left;
			padding: 8px 16px;
			text-decoration: none;
			transition: background-color .3s;
		}

		.pagination a.active {
			background-color: #4CAF50;
			color: white;
		}

		.pagination a:hover:not(.active) {background-color: #ddd;}
		.openinfo, .clickinfo{width:8%;}
	</style>
	<div class="m-grid__item m-grid__item--fluid m-wrapper">
		<!-- BEGIN: Subheader -->
		<div class="m-subheader ">
			<div class="d-flex align-items-center">
				<div class="mr-auto">
					<h3 class="m-subheader__title ">
						Report
					</h3>
				</div>
				{{--<div>--}}
					{{--<span class="m-subheader__daterange" id="m_dashboard_daterangepicker">--}}
						{{--<span class="m-subheader__daterange-label">--}}
							{{--<span class="m-subheader__daterange-title"></span>--}}
							{{--<span class="m-subheader__daterange-date m--font-brand"></span>--}}
						{{--</span>--}}
						{{--<a href="#" class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">--}}
							{{--<i class="la la-angle-down"></i>--}}
						{{--</a>--}}
					{{--</span>--}}
				{{--</div>--}}
			</div>
		</div>
		<!-- END: Subheader -->

		<div class="m-content">

			<div class="m-portlet m-portlet--full-height ">
				<div class="m-portlet__head">
					<div class="m-portlet__head-tools">
						<ul class="nav nav-pills nav-pills--brand m-nav-pills--align-left m-nav-pills--btn-pill m-nav-pills--btn-sm" role="tablist">
							<li class="nav-item m-tabs__item">
								<a class="nav-link m-tabs__link active" data-toggle="tab" href="#overview" role="tab">
									Overview
								</a>
							</li>
							<li class="nav-item m-tabs__item">
								<a class="nav-link m-tabs__link" data-toggle="tab" href="#revenue" role="tab">
									Revenue
								</a>
							</li>
						</ul>
					</div>
				</div>

				<div class="m-portlet__body">

					<div class="tab-content">
						<div class="tab-pane active" id="overview">
							<!--begin::Portlet-->
							<div class="m-portlet m-portlet--tab">
								<div class="m-portlet__body">
									<div id="m_morris_1" style="height:500px;"></div>
								</div>
							</div>
							<!--end::Portlet-->
						</div>

						<div class="tab-pane" id="revenue">
						</div>
					</div>

				</div>
			</div>

			<div class="m-portlet m-portlet--mobile">
				<div class="m-portlet__body">
					<!--begin: Datatable -->
					<div class="table-responsive" id="scrolling_horizontal">
						<table class="table">
							<thead>
								<tr>
									<td>
										<span style="width: 40px;">
											<label class="m-checkbox m-checkbox--single m-checkbox--all m-checkbox--solid m-checkbox--brand">
												<input type="checkbox"><span></span>
											</label>
										</span>
									</td>
									<td>
										<a href="javascript:void(0)" class="btn btn-sm btn-default">Folders <i class="fa fa-chevron-down" aria-hidden="true" style="font-size: 11px;"></i></a>
										<a href="javascript:void(0)" class="btn btn-sm btn-default">Filter <i class="fa fa-chevron-down" aria-hidden="true" style="font-size: 11px;"></i></a>
									</td>
									<td></td>
									<td></td>
									<td></td>
									
									<td class="text-right">
										<a href="javascript:void(0)" class="btn btn-sm btn-default">Download All Reports</a>
									</td>
								</tr>
							</thead>

							<tbody>
							@isset($reports)
							@foreach($reports as $report)
								<tr>
									<td>
										<span style="width: 40px;">
											<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"><input value="1" type="checkbox"><span></span></label>
										</span>
									</td>
									<td>
										<h3>{{$report['campaign_title']}}</h3>
										<p>{{$report['type']}}</p>
										<small>{{date('D,d M Y h:i a', strtotime($report["send_time"]))}}</small>
									</td>
									<td class="subscriberinfo">
										<h4>{{ number_format($report['emails_sent']) }}</h4>
										<small>Subscribers</small>
									</td>
									<td class="openinfo" >
										<h4 class="openrate">{{number_format(($report["opens"]["open_rate"]*100),1)}}%</h4>
										<h4 class="uniqueopen" style="display:none">{{$report['opens']['unique_opens']}}</h4>
										<small>Opens</small>
									</td>
									<td class="clickinfo">
										<h4 class="clickrate">{{number_format(($report["clicks"]["click_rate"]*100),1)}}%</h4>
										<h4 class="uniqueclick" style="display:none">{{$report['clicks']['unique_subscriber_clicks']}}</h4>
										<small>Clicks</small>
										
									</td>
									<td>
										<div class="input-group ">
										
											<a href="{{ route('report', ['campaign_id' => $report['id']]) }}" class="btn btn-sm btn-default">
												View Report
											</a>
											<div class="input-group-append dropdown">
												<a href="#" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
													<!-- <i class="fa fa-chevron-down" aria-hidden="true" style="font-size: 11px;"></i> -->
												</a>
												<ul class="dropdown-menu">
													<li>
														<a href="{{ route('downloadreport', ['campaign_id' => $report['id']]) }}"  >
														Download Report
														</a>
													</li>
												</ul>
											</div>																														
										</div>
									</td>
								</tr>
							@endforeach
							@endisset
							</tbody>
						</table>
						<div class="pagination pull-right">
							<a href="{{ (app('request')->input('page') && app('request')->input('page') > 1) ? route('dashboard', ['page' => app('request')->input('page')-1]) : ( ( app('request')->input('page') && (app('request')->input('page') - 1 == 0) ) ?  route('dashboard') :'javascript:void(0)'  ) }}" >Previous Page</a>
							<a href="{{ app('request')->input('page') ? route('dashboard', ['page' => app('request')->input('page')+1]): route('dashboard', ['page' => '1']) }}" >Next Page</a>
						</div>
					</div>
					<!--end: Datatable -->
				</div>
			</div>

		</div>
	</div>
@stop

@push('scripts')
	<script>
		var dashboardChartStringData = '{!! json_encode($chartData, JSON_UNESCAPED_UNICODE) !!}';
		var dashboardChartData = JSON.parse(dashboardChartStringData);

        var MorrisChartsDemo = function() {
            //== Private functions
            var demo1 = function() {
                // LINE CHART
                new Morris.Line({
                    // ID of the element in which to draw the chart.
                    element: 'm_morris_1',
                    // Chart data records -- each entry in this array corresponds to a point on
                    // the chart.
                    data: dashboardChartData.data,
                    // The name of the data record attribute that contains x-values.
                    xkey: 'y',
                    parseTime: false,
                    // A list of names of data record attributes that contain y-values.
                    ykeys: ['a', 'b', 'c'],
                    // Labels for the ykeys -- will be displayed when you hover over the
                    // chart.
                    labels: ['Click rate','Open rate', 'Industry avg. open rate'],
                    lineColors: ['#1F86B7','#8EC2BD', '#F45F33'],
                    smooth: true,
                    postUnits: '%',
                    resize: true
                });
            };

            return {
                // public functions
                init: function() {
                    if( $('#m_morris_1').length ) {
                        demo1();
                    }

                }
            };
        }();

        jQuery(document).ready(function() {
            MorrisChartsDemo.init();
        });
	</script>
@endpush