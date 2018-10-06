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
                <h3><strong>Click Activity</strong></h3>
                @foreach ($data as $link_name => $link_detail)
                    <h5><strong>{{ $link_name }}</strong></h5>
                    <br>
                    <div>
                        <div class="col-sm-5"><strong>Email</strong></div>
                        <div class="col-sm-5"><strong>Name</strong></div>
                        <div class="col-sm-2 text-right"><strong>Clicks</strong></div>
                    </div>
                    @foreach($link_detail as $member => $key)
                        @foreach($key as $key1 => $key2)
                        <div style="padding-bottom: 35px; padding-top: 10px; border-bottom: .5px dotted #dddddd;">
                            <div class="col-sm-5">
                                {{ $key2->email_address }}
                            </div>
                            <div class="col-sm-5">
                            </div>
                            <div class="col-sm-2 text-right">
                                <strong>{{$key2->clicks}}</strong>
                            </div>
                        </div>
                        @endforeach
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
@stop
