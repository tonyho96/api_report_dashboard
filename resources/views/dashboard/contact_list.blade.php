@extends('dashboard.layouts.master')

@section('content')
    <style type="text/css">
        text[text-anchor="middle"]{
            opacity: 0;
        }
        div.m-wrapper{
            margin-bottom: 60px !important;
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
    </style>
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
                <h5><strong>Unsubscribes</strong></h5>
                    <br>
                    <div>
                        <div class="col-sm-5"><strong>Email</strong></div>
                        <div class="col-sm-5"><strong>Name</strong></div>
                        <div class="col-sm-2 text-right"><strong>Reason</strong></div>
                    </div>
                    @foreach($datas["unsubscribes"] as $data)
                        <div style="padding-bottom: 35px; padding-top: 10px; border-bottom: .5px dotted #dddddd;">
                            <div class="col-sm-4">
                                {{ $data['email_address'] }}
                            </div>
                            <div class="col-sm-4 text-center">
                                {{ $data['merge_fields']['FNAME'] }} {{ $data['merge_fields']['LNAME'] }}
                            </div>
                            <div class="col-sm-4 text-right">
                                {{$data["reason"]}}
                            </div>
                        </div>
                    @endforeach
                <div class="pagination pull-right">
                    <a href="{{ (app('request')->input('page') && app('request')->input('page') > 1) ? route('contact-list', ['campaign_id' => $data['campaign_id'], 'page' => app('request')->input('page')-1]) : ( ( app('request')->input('page') && (app('request')->input('page') - 1 == 0) ) ?  route('contact-list', ['campaign_id' => $data['campaign_id']]) :'javascript:void(0)'  ) }}" >Previous Page</a>
                    <a href="{{ app('request')->input('page') ? route('contact-list', ['campaign_id' => $data['campaign_id'], 'page' => app('request')->input('page')+1]): route('contact-list', ['campaign_id' => $data['campaign_id'], 'page' => '1']) }}" >Next Page</a>
                </div>
                <br>
                <br>
                <br>
                <h5><strong>Bounce</strong></h5>
                    <br>
                    <div>
                        <div class="col-sm-5"><strong>Email</strong></div>
                        <div class="col-sm-5"><strong>Name</strong></div>
                        <div class="col-sm-2 text-right"><strong>Bounce Type</strong></div>
                    </div>
                    @foreach($datas["bounce"] as $data)
                        <div style="padding-bottom: 35px; padding-top: 10px; border-bottom: .5px dotted #dddddd;">
                            <div class="col-sm-4">
                                {{ $data['email_address'] }}
                            </div>
                            <div class="col-sm-4 text-center">
                            </div>
                            <div class="col-sm-4 text-right">
                                {{$data["type"]}}
                            </div>
                        </div>
                    @endforeach

            </div>
        </div>
    </div>
@stop
