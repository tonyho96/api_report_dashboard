@extends('dashboard.layouts.master')

@section('content')
	<?php if ( Auth::user()->time_zone == '' ) {
		date_default_timezone_set( 'UTC' );
	} else {
		date_default_timezone_set( Auth::user()->time_zone );
	}
	?>
    <div class="m-grid__item m-grid__item--fluid m-wrapper" style="max-width: 940px; margin: 0px auto; background-color: #FFFFFF;">
        <!-- BEGIN: Subheader -->
        <div class="m-subheader ">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h2>{{ $campaign_title }}</h2>
                </div>
            </div>
        </div>
        <hr>
        <!-- END: Subheader -->
        <div class="m-content">
            <div class="mm-portlet__body">
                <h3><strong>All Activity</strong></h3>
                    <br>
                    <div>
                        <div class="col-sm-5"><strong>Email</strong></div>
                        <div class="col-sm-2 text-right"><strong>Clicks</strong></div>
                        <div class="col-sm-4 text-right"><strong>Opens</strong></div>
                    </div>
                    @foreach($tmp as $activity_detail)
                        <div style="padding-bottom: 35px; padding-top: 10px; border-bottom: .5px dotted #dddddd;">
                            <div class="col-sm-5">
                                {{$activity_detail['email_address']}}
                            </div>
                            <div class="col-sm-2 text-right">
                            <strong>{{$activity_detail['click_count']}}</strong>
                            </div>
                            <div class="col-sm-4 text-right">
                                <strong>{{$activity_detail['open_count']}}</strong>
                            </div>
                        </div>
                    @endforeach
            </div>
        </div>
    </div>
@stop
