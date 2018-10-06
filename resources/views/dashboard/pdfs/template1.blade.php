<?php if(Auth::user()->time_zone == ''){
	date_default_timezone_set('UTC');
}else{
	date_default_timezone_set(Auth::user()->time_zone);
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<title></title>
		<style type="text/css">
			section {
				page-break-inside: avoid;
			}
			section {
				page-break-after: always;
			}
			section:last-child {
				page-break-after: auto;
			}
			.table-div {
				display: table !important;
				width: 100%;
			}
			.table-cell-div {
				display: table-cell !important;
				vertical-align: top;
				width: 50%;
			}
			.cell-9 {
				width: 90% !important;
			}
			.cell-1 {
				width: 10% !important;
			}
			.text-center {
				text-align: center !important;
			}
			.text-right {
				text-align: right !important;
			}
			h3,
			p {
				margin: 0px !important;
				margin-bottom: 15px;
			}
			a {
				color: #000000;
				text-decoration: none;
			}
			.bot-15 {
				margin-bottom: 15px;
			}
			.has-border {
				border: 1px solid #000000;
			}
			.header {
				border-bottom: 1px solid #000000;
			}

			.bar1 {
				border: 1px solid #000000;
				height: 15px;
				margin-bottom: 30px;
				position: relative;
			}
			.bar1 span {
				position: absolute;
				left: 0px;
				top: 0px;
				height: 15px;
				background-color: #000000;
			}
			#chart {
				margin-bottom: 50px;
			}
			table {
				padding: 10px 20px;
			}
			table tr th {
				border-top: 1px solid #dddddd;
				border-bottom: 1px solid #dddddd;
			}
			table tr td {
				border-bottom: 1px dashed #dddddd;
			}
			table tr th,
			table tr td {
				padding: 10px;
			}
			.header h3 {
				font-style: italic;
			}
		</style>
	</head>
	<body>
		<section>
			<div class="header">
				<div class="table-div">
					<div class="table-cell-div">
						<strong>{{$report_detail["campaign_title"]}}</strong>
						<h3>Overview</h3>
					</div>

					<div class="table-cell-div text-right">
						<strong>Sent&nbsp;</strong>{{date('m/d/y h:i A',strtotime($report_detail["send_time"]))}}
					</div>
				</div>
			</div>

			<div class="content">
				<br/>
				<h3><i>{{ number_format($report_detail["emails_sent"]) }} Recipients</i></h3>
				<br/>

				<div class="table-div">
					<div class="table-cell-div">
						<p>
							<strong>List:&nbsp;</strong>
							{{$report_detail["list_name"]}}
						</p>

						<p>
							<strong>Subject:&nbsp;</strong>
							{{$report_detail["subject_line"]}}
						</p>
					</div>

					<div class="table-cell-div">
						<p>
							<strong>Delivered:&nbsp;</strong>
							{{date('D,d M Y h:i a',strtotime($report_detail["send_time"]))}}
						</p>
					</div>
				</div>

				<!-- <div class="table-div">
					<div class="table-cell-div text-center has-border" style="border-right: 0px; border-color: #dddddd;">
						<strong>0</strong>
						<br/>
						<span>Order</span>
					</div>

					<div class="table-cell-div text-center has-border" style="border-right: 0px; border-color: #dddddd;">
						<strong>$0.00</strong>
						<br/>
						<span>Average order revenue</span>
					</div>

					<div class="table-cell-div text-center has-border" style="border-color: #dddddd;">
						<strong>$0.00</strong>
						<br/>
						<span>Total revenue</span>
					</div>
				</div> -->

				<div class="table-div">
					<div class="table-cell-div" style="padding-right: 15px;">

						<div class="table-div bot-15">
							<div class="table-cell-div">
								<strong>Open rate</strong>
							</div>

							<div class="table-cell-div text-right">
								<strong>{{number_format(($report_detail["opens"]["open_rate"]*100),1)}}%</strong>
							</div>
						</div>

						<div class="bar1">
							<span style='width:{{number_format(($report_detail["opens"]["open_rate"]*100),1)}}%;'></span>
						</div>

						<div class="table-div bot-15">
							<div class="table-cell-div">
								<small>List average</small>
							</div>

							<div class="table-cell-div text-right">
								<small><strong>{{number_format($report_detail["list_stats"]["open_rate"],1)}}%</strong></small>
							</div>
						</div>

						<div class="table-div bot-15">
							<div class="table-cell-div">
								<small>Industry average (Legal)</small>
							</div>

							<div class="table-cell-div text-right">
								<strong>
								@if (!empty($report_detail["industry_stats"]))
								{{number_format(($report_detail["industry_stats"]["open_rate"]*100),1)}}%
								@else
								N/A 
								@endif
								</strong>
							</div>
						</div>

					</div>

					<div class="table-cell-div" style="padding-left: 15px;">

						<div class="table-div bot-15">
							<div class="table-cell-div">
								<strong>Click rate</strong>
							</div>

							<div class="table-cell-div text-right">
								<strong>{{number_format(($report_detail["clicks"]["click_rate"]*100),1)}}%</strong>
							</div>
						</div>

						<div class="bar1">
							<span style='width:{{number_format(($report_detail["clicks"]["click_rate"]*100),1)}}%;'></span>
						</div>

						<div class="table-div bot-15">
							<div class="table-cell-div">
								<small>List average</small>
							</div>

							<div class="table-cell-div text-right">
								<small><strong>{{number_format($report_detail["list_stats"]["click_rate"],1)}}%</strong></small>
							</div>
						</div>

						<div class="table-div bot-15">
							<div class="table-cell-div">
								<small>Industry average (Legal)</small>
							</div>

							<div class="table-cell-div text-right">
								<strong>
								@if (!empty($report_detail["industry_stats"]))
								{{number_format(($report_detail["industry_stats"]["click_rate"]*100),1)}}%
								@else
								N/A 
								@endif
								</strong>
							</div>
						</div>

					</div>
				</div>
				
				<br/>

				<div class="table-div">
					<div class="table-cell-div text-center has-border" style="border-right: 0px; border-color: #dddddd;">
						<br/><br/>
						<strong style="font-size: 20px !important;">{{number_format($report_detail["opens"]["unique_opens"])}}</strong>
						<br/>
						<span>Opened</span>
						<br/><br/><br/>
					</div>

					<div class="table-cell-div text-center has-border" style="border-right: 0px; border-color: #dddddd;">
						<br/><br/>
						<strong style="font-size: 20px !important;">{{number_format($report_detail["clicks"]["unique_subscriber_clicks"])}}</strong>
						<br/>
						<span>Clicked</span>
						<br/><br/><br/>
					</div>

					<div class="table-cell-div text-center has-border" style="border-right: 0px; border-color: #dddddd;">
						<br/><br/>
						<strong style="font-size: 20px !important;">{{number_format($report_detail["bounces"]["hard_bounces"] + $report_detail["bounces"]["soft_bounces"])}}</strong>
						<br/>
						<span>Bounced</span>
						<br/><br/><br/>
					</div>

					<br/><br/>

					<div class="table-cell-div text-center has-border" style="border-color: #dddddd;">
						<br/><br/>
						<strong style="font-size: 20px !important;">{{number_format($report_detail["unsubscribed"])}}</strong>
						<br/>
						<span>Unsubscribed</span>
						<br/><br/><br/>
					</div>
				</div>

				<div class="table-div">
					<div class="table-cell-div" style="padding-right: 15px;">

						<div class="table-div bot-15">
							<div class="table-cell-div">
								<small>Successful deliveries</small>
							</div>

							<div class="table-cell-div text-right">
								<strong>{{number_format(($report_detail["emails_sent"] - ( $report_detail["bounces"]["hard_bounces"] + $report_detail["bounces"]["soft_bounces"] + $report_detail["bounces"]["syntax_errors"] ))) }}</strong>&nbsp;{{number_format((  (($report_detail["emails_sent"] - ( $report_detail["bounces"]["hard_bounces"] + $report_detail["bounces"]["soft_bounces"] + $report_detail["bounces"]["syntax_errors"] )) / $report_detail["emails_sent"] )*100),1)}}%
							</div>
						</div>

						<div class="table-div bot-15">
							<div class="table-cell-div">
								<small>Total opens</small>
							</div>

							<div class="table-cell-div text-right">
								<strong>{{number_format($report_detail["opens"]["opens_total"])}}</strong>
							</div>
						</div>

						<div class="table-div bot-15">
							<div class="table-cell-div">
								<small>Last opened</small>
							</div>

							<div class="table-cell-div text-right">
							{{date('D, M d, Y h:i A',strtotime($report_detail["opens"]["last_open"]))}}
							</div>
						</div>

						<div class="table-div bot-15">
							<div class="table-cell-div">
								<small>Forwarded</small>
							</div>

							<div class="table-cell-div text-right">
								<strong>
								@if(isset($report_detail["forwards"]["forwards_count"]))
								{{$report_detail["forwards"]["forwards_count"]}}
								@else N/A 
								@endif
								</strong>
							</div>
						</div>

					</div>

					<div class="table-cell-div" style="padding-left: 15px;">

						<div class="table-div bot-15">
							<div class="table-cell-div">
								<small>Clicks per unique opens</small>
							</div>

							<div class="table-cell-div text-right">
								<strong>{{number_format((($report_detail["clicks"]["unique_subscriber_clicks"] / $report_detail["opens"]["unique_opens"] )*100),1) }}%</strong>
							</div>
						</div>

						<div class="table-div bot-15">
							<div class="table-cell-div">
								<small>Total clicks</small>
							</div>

							<div class="table-cell-div text-right">
								<strong>{{number_format($report_detail["clicks"]["clicks_total"])}}</strong>
							</div>
						</div>

						<div class="table-div bot-15">
							<div class="table-cell-div">
								<small>Last clicked</small>
							</div>

							<div class="table-cell-div text-right">
							@if ($report_detail["clicks"]["last_click"] != '')
							{{date('D, M d, Y h:i A',strtotime($report_detail["clicks"]["last_click"]))}}
							@else N/A
							@endif
							</div>
						</div>

						<div class="table-div bot-15">
							<div class="table-cell-div">
								<small>Abuse reports</small>
							</div>

							<div class="table-cell-div text-right">
							{{$report_detail["abuse_reports"]}}
							</div>
						</div>

					</div>
				</div>
			</div>
		</section>

		<section>
			<div class="header">
				<div class="table-div">
					<div class="table-cell-div">
						<strong>{{$report_detail["campaign_title"]}}</strong>
						<h3>Subscriber activity</h3>
					</div>

					<div class="table-cell-div text-right">
						<strong>Sent&nbsp;</strong>{{date('d/m/y h:i A',strtotime($report_detail["send_time"]))}}
					</div>
				</div>
			</div>

			<div class="content">
				{{--<div class="table-div">--}}
					{{--<div class="table-cell-div">--}}
						{{--<br/>--}}
						{{--<h3><i>24-hour performance</i></h3>--}}
						{{--<br/>--}}
					{{--</div>--}}

					{{--<div class="table-cell-div text-right" style="vertical-align: middle;">--}}
						{{--<span style="margin-right: 30px;">Opens</span>--}}
						{{--<span>clicks</span>--}}
					{{--</div>--}}
				{{--</div>--}}

				{{--<div id="chart">--}}
					{{--<img src="{{ asset('pdf-images/chart.png') }}" width="110%" alt="Chart" />--}}
				{{--</div>--}}
				
				<h3><i>Top links clicked</i></h3>
				@foreach ($click_details["urls_clicked"] as $click_detail) 
				<div class="table-div" style="border-bottom: 1px solid #dddddd; padding: 15px 0px;">
					<div class="table-cell-div cell-9">
						<a href='{{$click_detail["url"]}}'>{{$click_detail["url"]}}</a>
					</div>
					<div class="table-cell-div cell-1 text-right">
						<strong>{{$click_detail["total_clicks"]}}</strong>
					</div>
				</div>
				@endforeach

	
				<br/><br/>

				<h3><i>Subscribers with most opens</i></h3>
				@foreach ($domain_performance["domains"] as $domain) 
				<div class="table-div" style="border-bottom: 1px solid #dddddd; padding: 15px 0px;">
					<div class="table-cell-div cell-9">
						<a href='{{$domain["domain"]}}'>{{$domain["domain"]}}</a>
					</div>
					<div class="table-cell-div cell-1 text-right">
						<strong>{{$domain["opens"]}}</strong>
					</div>
				</div>
				@endforeach
			</div>
		</section>

		<section>
			<div class="header">
				<div class="table-div">
					<div class="table-cell-div">
						<strong>{{$report_detail["campaign_title"]}}</strong>
						<h3>Click performance</h3>
					</div>

					<div class="table-cell-div text-right">
						<strong>Sent&nbsp;</strong>{{date('m/d/y h:i A',strtotime($report_detail["send_time"]))}}
					</div>
				</div>
			</div>

			<div class="content">

				<table border="0" cellpadding="0" style="width: 100%;">
					<tr>
						<th width="70%">URL</th>
						<th class="text-right" width="15%">Total</th>
						<th class="text-right" width="15%">Unique</th>
					</tr>
					@foreach ($click_details["urls_clicked"] as $click_detail) 
					<tr>
						<td>
							<a href='{{$click_detail["url"]}}'>{{$click_detail["url"]}}</a>
						</td>
						<td class="text-right">
						{{$click_detail["total_clicks"]}} <strong>({{number_format($click_detail["click_percentage"],1)}}%)</strong>
						</td>
						<td class="text-right">
						{{$click_detail["unique_clicks"]}} <strong>({{number_format($click_detail["unique_click_percentage"],1)}}%)</strong>
						</td>
					</tr>
					@endforeach
			

				</table>
			</div>
		</section>
	</body>
</html>

