@extends('dashboard.layouts.master')

@section('content')
<?php if($user_time_zone == ''){
	date_default_timezone_set('UTC');
}else{
	date_default_timezone_set($user_time_zone);
}
?>

@php
	function customDescTopLinkCompare( $a, $b ) {
		$a = $a['total_clicks'];
		$b = $b['total_clicks'];
		if ( $a == $b ) {
			return 0;
		}

		return ( $a > $b ) ? - 1 : 1;
	}
    function sortTopLinkClicked($array) {
        usort($array, "customDescTopLinkCompare");
        return $array;
    }

    function customDescOpenSubscriberCompare( $a, $b ) {
		$a = $a['open_count'];
		$b = $b['open_count'];
		if ( $a == $b ) {
			return 0;
		}

		return ( $a > $b ) ? - 1 : 1;
       }
    function sortMostOpenSubscribers($array) {
        usort($array,"customDescOpenSubscriberCompare");
        return $array;
    }
@endphp
	<div class="m-grid__item m-grid__item--fluid m-wrapper" style="max-width: 940px; margin: 0px auto; background-color: #FFFFFF;">
		<!-- BEGIN: Subheader -->
		@foreach ($report_detail as $report_detail)
		<div class="m-subheader ">
			<div class="d-flex align-items-center">
				<div class="mr-auto">
					<strong>{{$report_detail["campaign_title"]}}</strong>
					<h3 class="m-subheader__title ">
						Overview
					</h3>
				</div>

				<div class="pull-right">
					{{--{{json_encode($report_detail["timeseries"])}}--}}
					<strong>Sent</strong> {{date('d/m/y h:i a',strtotime($report_detail["send_time"]))}}
				</div>
			</div>
		</div>
		<hr>
		<!-- END: Subheader -->
		<div class="m-content">
			<h3 class="m-subheader__title ">
			<strong>{{ number_format($report_detail["emails_sent"]) }} Recipients</strong>
			</h3>

			<div class="row">
				<div class="col-sm-6">
					<p>
						<strong>List:</strong> {{$report_detail["list_name"]}}
					</p>

					<p>
						<strong>Subject:</strong> {{$report_detail["subject_line"]}}
					</p>
				</div>

				<div class="col-sm-6">
					<p>
						<strong>Delivered:</strong> {{date('D,d M Y h:i a',strtotime($report_detail["send_time"]))}}
					</p>
				</div>
			</div>

			<!-- <div class="row text-center">
				<div class="col-sm-4" style="border: 1px solid #ddd; padding: 30px 0px;">
					<h4>0</h4>
					Orders
				</div>

				<div class="col-sm-4" style="border: 1px solid #ddd;  padding: 30px 0px;">
					<h4>$0.00</h4>
					Average order revenue
				</div>

				<div class="col-sm-4" style="border: 1px solid #ddd;  padding: 30px 0px;">
					<h4>$0.00</h4>
					Total revenue
				</div>
			</div> -->

			<br/><br/>
			<div class="row">
				<div class="col-sm-6">
					<div class="m-widget25__progress">
						<p>
							<span class="m-widget25__progress-sub">
								<strong>Open rate</strong>
							</span>
							<span class="m-widget25__progress-number pull-right">
								<strong>{{number_format(($report_detail["opens"]["open_rate"]*100),1)}}%</strong>
							</span>
						</p>
						<div class="m--space-10"></div>
						<div class="progress m-progress--md">
							<div class="progress-bar m--bg-csblue" role="progressbar" style='width: {{number_format(($report_detail["opens"]["open_rate"]*100),1)}}%;' aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<br/>
						<p>
							<span class="m-widget25__progress-sub">
								List average
							</span>
							<span class="m-widget25__progress-number pull-right">
								<strong>{{number_format($report_detail["list_stats"]["open_rate"],1)}}%</strong>
							</span>
						</p>
						<p>
							<span class="m-widget25__progress-sub">
								Industry average (Legal)
							</span>
							<span class="m-widget25__progress-number pull-right">
								@if (!empty($report_detail["industry_stats"]))
								{{number_format(($report_detail["industry_stats"]["open_rate"]*100),1)}} %
								@else
								N/A
								@endif
							</span>
						</p>
					</div>
				</div>

				<div class="col-sm-6">
					<div class="m-widget25__progress">
						<p>
							<span class="m-widget25__progress-sub">
								<strong>Click rate</strong>
							</span>
							<span class="m-widget25__progress-number pull-right">
								<strong>{{number_format(($report_detail["clicks"]["click_rate"]*100),1)}}%</strong>
							</span>
						</p>
						<div class="m--space-10"></div>
						<div class="progress m-progress--md">
							<div class="progress-bar m--bg-csblue" role="progressbar" style='width: {{number_format(($report_detail["clicks"]["click_rate"]*100),1)}}%;' aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<br/>
						<p>
							<span class="m-widget25__progress-sub">
								List average
							</span>
							<span class="m-widget25__progress-number pull-right">
								<strong>{{number_format($report_detail["list_stats"]["click_rate"],1)}}%</strong>
							</span>
						</p>
						<p>
							<span class="m-widget25__progress-sub">
								Industry average (Legal)
							</span>
							<span class="m-widget25__progress-number pull-right">
								@if (!empty($report_detail["industry_stats"]))
								{{number_format(($report_detail["industry_stats"]["click_rate"]*100),1)}} %
								@else
								N/A
								@endif
							</span>
						</p>
					</div>
				</div>
			</div>

			<br/><br/>
			<div class="row row text-center">
				<div class="col-sm-3" style="border: 1px solid #ddd; padding: 30px 0px;">
					<h4><strong>{{number_format($report_detail["opens"]["unique_opens"])}}</strong></h4>
					Opened
				</div>

				<div class="col-sm-3" style="border: 1px solid #ddd; padding: 30px 0px;">
					<h4><strong>{{number_format($report_detail["clicks"]["unique_subscriber_clicks"])}}</strong></h4>
					Clicked
				</div>

				<div class="col-sm-3" style="border: 1px solid #ddd; padding: 30px 0px;">
					<h4><strong>{{number_format($report_detail["bounces"]["hard_bounces"] + $report_detail["bounces"]["soft_bounces"])}}</strong></h4>
					Bounced
				</div>

				<div class="col-sm-3" style="border: 1px solid #ddd; padding: 30px 0px;">
					<h4><strong>{{number_format($report_detail["unsubscribed"])}}</strong></h4>
					Unsubscribed
				</div>
			</div>

			<br/><br/>
			<div class="row">
				<div class="col-sm-6">
					<p>
						Successful deliveries
						<span class="pull-right"><strong>{{number_format(($report_detail["emails_sent"] - ( $report_detail["bounces"]["hard_bounces"] + $report_detail["bounces"]["soft_bounces"] + $report_detail["bounces"]["syntax_errors"] ))) }}</strong>&nbsp;{{number_format((  (($report_detail["emails_sent"] - ( $report_detail["bounces"]["hard_bounces"] + $report_detail["bounces"]["soft_bounces"] + $report_detail["bounces"]["syntax_errors"] )) / $report_detail["emails_sent"] )*100),1)}}%</span>
					</p>
					<p>
						Total opens
						<span class="pull-right"><strong>{{number_format($report_detail["opens"]["opens_total"])}}</strong></span>
					</p>
					<p>
						Last opened
						<span class="pull-right">{{date('D, M d, Y h:i A',strtotime($report_detail["opens"]["last_open"]))}}</span>
					</p>
					<p>
						Forwarded
						<span class="pull-right"><strong>
						@if(isset($report_detail["forwards"]["forwards_count"]))
						{{$report_detail["forwards"]["forwards_count"]}}
						@else N/A
						@endif
						</strong></span>
					</p>
				</div>

				<div class="col-sm-6">
					<p>
						Clicks per unique opens
						<span class="pull-right"><strong>{{number_format((($report_detail["clicks"]["unique_subscriber_clicks"] / $report_detail["opens"]["unique_opens"] )*100),1) }}%</strong></span>
					</p>
					<p>
						Total clicks
						<span class="pull-right"><strong>{{number_format($report_detail["clicks"]["clicks_total"])}}</strong></span>
					</p>
					<p>
						Last clicked
						<span class="pull-right">
						@if ($report_detail["clicks"]["last_click"] != '')
						{{date('D, M d, Y h:i A',strtotime($report_detail["clicks"]["last_click"]))}}
						@else N/A
						@endif
						</span>
					</p>
					<p>
						Abuse reports
						<span class="pull-right"><strong>{{$report_detail["abuse_reports"]}}</strong></span>
					</p>
				</div>
			</div>
		</div>

		<!-- BEGIN: Subheader -->
		<div class="m-subheader ">
			<div class="d-flex align-items-center">
				<div class="mr-auto">
					{{$report_detail["campaign_title"]}}
					<h3 class="m-subheader__title ">
						Subscriber activity
					</h3>
				</div>

				<div class="pull-right">
					<strong>Sent</strong> {{date('m/d/y h:i A',strtotime($report_detail["send_time"]))}}
				</div>
			</div>
		</div>
		<hr>
		<!-- END: Subheader -->
		<div class="m-content">

			<div class="row" style="margin-bottom: 15px;">
				<div class="col-xs-6">
					<h3 class="m-subheader__title ">
						{{ number_format($report_detail["emails_sent"]) }} Recipients
					</h3>
				</div>

				<div class="col-xs-6 text-right">
					<span style="margin-right: 30px;">Opens</span><span>Clicks</span>
				</div>
			</div>

			<!--begin::Portlet-->
			<div class="m-portlet m-portlet--tab">
				<div class="m-portlet__body">
					<div id="m_morris_2" style="height:500px;"></div>
				</div>
			</div>
			<!--end::Portlet-->

			<div class="mm-portlet__body">
				<h3><a href="{{ action('DashboardController@showClickReportsMembers', $campaign_id) }}">Click Performance</a></h3>
				<div>
					<div class="col-sm-offset-10 text-right col-sm-1"><strong>Clicks</strong></div>
				</div>
				@php
				$totalClickPerformance = 0;
				@endphp
				@foreach (sortTopLinkClicked($click_details) as $click_detail)
					@php

						$totalClickPerformance += $click_detail["total_clicks"];
					@endphp
					@if (!empty($click_detail['total_clicks']))
						<div style="padding-bottom: 35px; padding-top: 10px; border-bottom: .5px dotted #dddddd;">
							<div class="col-sm-10">
								<a href='{{$click_detail["url"]}}'>{{$click_detail["name"]}}</a>
							</div>
							<div class="col-sm-1 text-right">
								{{$click_detail["total_clicks"]}}
							</div>
							<div class="col-sm-1 text-right">
								{{$click_detail["percent_total_clicked"]}}%
							</div>
						</div>
					@endif
				@endforeach
				<div>
					<div class="col-sm-10"><strong>Total</strong></div>
					<div class="text-right col-sm-1"><strong>{{ $totalClickPerformance }}</strong></div>
				</div>
				<div class="clearfix"></div>
			</div>

			<div class="mm-portlet__body">
				<h3><a href="{{ action('DashboardController@showActivityReport', $campaign_id) }}">Top 10 Activity</a></h3>
				<div class="col-sm-offset-10 text-right col-sm-1"><strong>Clicks</strong></div>
				<div class="col-sm-1 text-right"><strong>Opens</strong></div>
				@foreach ($activity as $activity_detail)
						<div style="padding-bottom: 35px; padding-top: 10px; border-bottom: .5px dotted #dddddd;">
							<div class="col-sm-10">
								<a href='#'>{{$activity_detail["email_address"]}}</a>
							</div>
							<div class="col-sm-1 text-right">
								<strong>{{$activity_detail["click_count"]}}</strong>
							</div>
							<div class="col-sm-1 text-right">
								<strong>{{$activity_detail["open_count"]}}</strong>
							</div>
						</div>
				@endforeach
			</div>
			<div class="mm-portlet__body">
				<h3><a href="{{ action('DashboardController@showContactList', $campaign_id) }}">Contact List Management</a></h3>
				<div class="row row text-center" style="margin-bottom: 20px">
					<div class="col-sm-8" style="border: 1px solid #ddd; padding-bottom: 30px; padding-top: 13px">
						<p>Bounces</p>
						<div class="container-fluid">
							<div class="row text-center">
								<div class="col-sm-6" style="border: 1px solid #ddd; padding: 10px 0px;">
									Total Bounces
									<h4><strong>{{ number_format($report_detail["bounces"]["hard_bounces"] + $report_detail["bounces"]["soft_bounces"]) }}</strong></h4>
								</div>

								<div class="col-sm-3" style="border: 1px solid #ddd; padding: 10px 0px;">
									Hard
									<h4><strong>{{ number_format($report_detail["bounces"]["hard_bounces"]) }}</strong></h4>
								</div>

								<div class="col-sm-3" style="border: 1px solid #ddd; padding: 10px 0px;">
									Soft
									<h4><strong>{{ number_format($report_detail["bounces"]["soft_bounces"]) }}</strong></h4>
								</div>

							</div>
						</div>
					</div>
					<div class="col-sm-4" style="border: 1px solid #ddd; padding-bottom: 30px; padding-top: 13px">
						<p>Unsubscribed</p>
						<div class="container-fluid">
							<div class="row text-center">
								<div class="col-sm-12" style="border: 1px solid #ddd; padding: 10px 0px;">
									&nbsp;
									<h4><strong>{{number_format($report_detail["unsubscribed"])}}</strong></h4>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>

			<div class="mm-portlet__body">
				<h3>Subscribers with most opens</h3>
				@foreach (sortMostOpenSubscribers($domain_performance) as $domain)
					@if (!empty($domain['open_count']))
						<p style="padding-bottom: 15px; border-bottom: .5px dotted #dddddd;">
							<a href='{{$domain["email_address"]}}'>{{$domain["email_address"]}}</a>
							<strong class="pull-right">
							{{$domain["open_count"]}}
							</strong>
						</p>
					@endif
				@endforeach
			</div>
		</div>
	</div>
@endforeach
@stop

@push("scripts")
	<script>
        var demo2 = function() {
            // LINE CHART
            new Morris.Line({
                element: 'm_morris_2',
                data: {!! json_encode($report_detail["timeseries"]) !!},
                xkey: 'timestamp',
                ykeys: ['unique_opens', 'recipients_clicks'],
                labels: ['Unique Opens', 'Recipients Clicks'],
                resize: true
            });
        }
        if( $('#m_morris_2').length ) {
            demo2();
        }
	</script>
@endpush
