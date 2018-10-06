<?php

namespace App\Http\Controllers;

use App\Models\ClickDetails;
use App\Models\Activities;
use App\Models\ClickDetailsMembers;
use App\Models\EmailActivities;
use App\Models\Recipients;
use App\Models\Report;
use App\Models\Unsubscribes;
use App\Models\SubscriberSummaries;
use App\Services\MongoDBService;
use App\SyncReports;
use Request;
use App\Services\MailChimpService;
use Illuminate\Support\Facades\Mail;
use PDF;
use Illuminate\Support\Facades\Auth;
use DateTimeZone;
use DateTime;
use App\User;
use DB;

class DashboardController extends Controller {

	public function index() {
		$reports = Report::orderBy('send_time','desc')->where( 'user_id', Auth::user()->id )->paginate( 10 );

		$subscribers = [];
		$listIds     = [];
		foreach ( $reports as $report ) {
			$listIds[] = $report->list_id;
		}

		$subscriberSummaries = SubscriberSummaries::whereIn( 'id', $listIds )->get();
		foreach ( $subscriberSummaries as $tmp ) {
			if ( isset( $tmp->stats['member_count'] ) ) {
				$subscribers[ $tmp->id ] = $tmp->stats['member_count'];
			}
		}

		$reports   = $reports->toArray()['data'];
		$chartData = MailChimpService::buildReportChart( $reports );

		return view( 'dashboard.index', [ 'reports' => $reports, 'subscribers' => $subscribers, 'chartData' => $chartData ] );
	}

    public function showProfile() {

        static $regions = array(
            DateTimeZone::AFRICA,
            DateTimeZone::AMERICA,
            DateTimeZone::ANTARCTICA,
            DateTimeZone::ASIA,
            DateTimeZone::ATLANTIC,
            DateTimeZone::AUSTRALIA,
            DateTimeZone::EUROPE,
            DateTimeZone::INDIAN,
            DateTimeZone::PACIFIC,
        );

        $timezones = array();
        foreach( $regions as $region )
        {
            $timezones = array_merge( $timezones, DateTimeZone::listIdentifiers( $region ) );
        }

        $timezone_offsets = array();
        foreach( $timezones as $timezone )
        {
            $tz = new DateTimeZone($timezone);
            $timezone_offsets[$timezone] = $tz->getOffset(new DateTime);
        }

        // sort timezone by offset
        asort($timezone_offsets);

        $timezone_list = array();
        foreach( $timezone_offsets as $timezone => $offset )
        {
            $offset_prefix = $offset < 0 ? '-' : '+';
            $offset_formatted = gmdate( 'H:i', abs($offset) );

            $pretty_offset = "UTC${offset_prefix}${offset_formatted}";

            $timezone_list[$timezone] = "(${pretty_offset}) $timezone";
        }

        $user         = Auth::user();
        $user_id                = $user->id;
        $obj_user               = User::find( $user_id );
        $user_time_zone = $obj_user->time_zone;
        return view('dashboard.profile',['timezone_list' => $timezone_list,'user_time_zone'=> $user_time_zone]);
    }

    public function saveProfile() {

        $time_zone = Request::input('time_zone');
        $user         = Auth::user();
        $user_id                = $user->id;
        $obj_user               = User::find( $user_id );
        $obj_user->time_zone = $time_zone;
        $obj_user->save();
        return redirect()->back();
    }

	public function showReport( $campaign_id ) {

		//$report_detail = MailChimpService::getReportDetail( $campaign_id );
        $report_detail = Report::where('id', $campaign_id)->get();
		//$click_detail  = MailChimpService::getClickDetailData($campaign_id);
        $click_detail = ClickDetails::where('campaign_id', $campaign_id)->get();
		//$domain_performance = MailChimpService::getDomainPerformance($campaign_id);
        //$recipients     = MailChimpService::getRecipientsData( $campaign_id );
        $recipients = Recipients::where('campaign_id', $campaign_id)->get();
        //$activities = MailChimpService::getActivity( $campaign_id );
        $activities = Activities::where('campaign_id', $campaign_id)->get();
		$user           = Auth::user();
		$user_id        = $user->id;
		$obj_user       = User::find( $user_id );
		$user_time_zone = $obj_user->time_zone;
        $tmp = [];
//        foreach($activities["emails"] as $email_detail){
//            if(!empty($email_detail["activity"])){
//                $click_count = 0;
//                $open_count = 0;
//                foreach($email_detail["activity"] as $activity_detail){
//                    if ($activity_detail["action"] == "click"){
//                        $click_count++;
//                    }else{
//                        $open_count++;
//                    }
//                }
//                $email_detail["click_count"] = $click_count;
//                $email_detail["open_count"] = $open_count;
//               array_push($tmp,$email_detail);
//            }
//        }
        foreach($activities as $email_details){
            if(!empty($email_details->activity)) {
                $click_count = 0;
                $open_count = 0;
                foreach ($email_details->activity as $email_detail) {
                    if ($email_detail["action"] == "click") {
                        $click_count++;
                    } else {
                        $open_count++;
                    }
                }
                $email_details["click_count"] = $click_count;
                $email_details["open_count"] = $open_count;

                array_push($tmp, $email_details);

            }

        }



        $click_detail = collect($click_detail)->sortBy('total_clicks')->reverse()->toArray();
        $total_clicked = 0;
        foreach ( $click_detail as $value => $key ) {
            $name = MailChimpService::convertURLToName( $key['url'] );
            $click_detail[$value]['name'] = $name;
            $total_clicked += number_format($key['total_clicks']);
        }
        //Fix Division by zero
        if($total_clicked == 0) {
            $total_clicked = 1;
        }
        foreach ($click_detail as $value => $key ) {
            $click_detail[$value]['percent_total_clicked'] = number_format($key['total_clicks'] * 100 / $total_clicked, 0);
        }

        $recipients = collect($recipients)->sortBy('sent_to')->reverse()->toArray();
        $tmp = collect($tmp)->sortBy('click_count')->reverse()->toArray();
        $tmp = array_values($tmp);
        $tmp = array_slice($tmp,0,10);


		return view( 'dashboard.report', [ 'report_detail' => $report_detail, 'click_details' => $click_detail, 'domain_performance' => $recipients, 'user_time_zone' => $user_time_zone, 'activity' => $tmp,'campaign_id' => $campaign_id ] );
	}

    public function downloadReport($campaign_id) {

        $report_detail = MailChimpService::getReportDetail($campaign_id);
        $click_detail = MailChimpService::getClickDetailData($campaign_id);

        $domain_performance = MailChimpService::getDomainPerformance($campaign_id);


        $pdf = PDF::loadView('dashboard.pdfs.template1',['report_detail' => $report_detail, 'click_details' => $click_detail, 'domain_performance' => $domain_performance])->setPaper('a4');
        return $pdf->stream();
    }

    public function showClickReportsMembers($campaign_id)
    {

        //$report_detail = MailChimpService::getReportDetail( $campaign_id );
        $report_detail = Report::where('id', $campaign_id)->get();
        foreach ($report_detail as $report_detail) {
            $campaign_title = $report_detail->campaign_title;
        }
//	    $clicks_detail = MailChimpService::getClickDetailData($campaign_id);

        $clicks_detail = ClickDetails::where('campaign_id', $campaign_id)->get();


        $data = [];
//    	foreach ($clicks_detail['urls_clicked'] as $click) {
//    		if (empty($click['total_clicks']))
//    			continue;
//
//    		$link_id = $click['id'];
//    		$link_name = $click['name'];
//
//            $link_detail = ClickDetailsMembers::where('campaign_id',$campaign_id )->where('url_id',$link_id)->get();
//
//    		$data[$link_name] = $link_detail;
//	    }
        foreach ($clicks_detail as $click) {
            if (empty($click->total_clicks))
                continue;

            $link_id = $click->id;

            $link_name = MailChimpService::convertURLToName($click->url);

            $link_detail = ClickDetailsMembers::where('campaign_id', $campaign_id)->where('url_id', $link_id)->get();
            $data[$link_name][$link_id] = $link_detail;
        }



	    //$campaign_title = $report_detail['campaign_title'];
	    return view('dashboard.click_reports_members', compact('data', 'campaign_title'));
    }

    public function showActivityReport($campaign_id) {

        //$activities = MailChimpService::getActivity( $campaign_id );
        $activities = Activities::where('campaign_id', $campaign_id)->get();
        //$report_detail = MailChimpService::getReportDetail( $campaign_id );
        $report_detail = Report::where('id', $campaign_id)->get();
        foreach ($report_detail as $report_detail) {
            $campaign_title = $report_detail->campaign_title;
        }
    	$tmp = [];

//        foreach($activities["emails"] as $email_detail){
//            if(!empty($email_detail["activity"])){
//                $click_count = 0;
//                $open_count = 0;
//                foreach($email_detail["activity"] as $activity_detail){
//                    if ($activity_detail["action"] == "click"){
//                        $click_count++;
//                    }else{
//                        $open_count++;
//                    }
//                }
//                $email_detail["click_count"] = $click_count;
//                $email_detail["open_count"] = $open_count;
//               array_push($tmp,$email_detail);
//            }
//
//        }
        $email_details = [];
        foreach($activities as $email_details){

            if(!empty($email_details->activity)) {
                $click_count = 0;
                $open_count = 0;
                foreach ($email_details->activity as $email_detail) {
                    if ($email_detail["action"] == "click") {
                        $click_count++;
                    } else {
                        $open_count++;
                    }
                }
                $email_details["click_count"] = $click_count;
                $email_details["open_count"] = $open_count;

                array_push($tmp, $email_details);

            }

        }

        $tmp = collect($tmp)->sortBy('click_count')->reverse()->toArray();
        $tmp = array_values($tmp);

        //$campaign_title = $report_detail['campaign_title'];
	    return view('dashboard.activity_report_detail', compact('tmp', 'campaign_title'));
    }

    public function showContactList($campaign_id){

        //$report_detail = MailChimpService::getReportDetail( $campaign_id );
        $report_detail = Report::where('id',$campaign_id)->get();
        foreach ($report_detail as $report_detail){
            $campaign_title = $report_detail->campaign_title;
        }
        $page = Request::input('page');
        //$unsubscribes_detail = MailChimpService::getUnsubscribesData($campaign_id, $page);
        $unsubscribes_detail = Unsubscribes::where('campaign_id',$campaign_id)->get();
        $bounce_details = EmailActivities::where('campaign_id',$campaign_id)->get();

//        dd($unsubscribes_detail);

        $datas = [];
        $datas["unsubscribes"] = [];
        $datas["bounce"] = [];
//        foreach ($unsubscribes_detail["unsubscribes"] as $unsubscribe_detail){
//            array_push($datas["unsubscribes"], [
//                "email_id"      => $unsubscribe_detail["email_id"],
//                "email_address" => $unsubscribe_detail["email_address"],
//                "reason"        => $unsubscribe_detail["reason"],
//                "merge_fields"  => $unsubscribe_detail["merge_fields"],
//                "campaign_id"   => $campaign_id
//            ]);
//        }
        foreach ($unsubscribes_detail as $unsubscribe_detail){
            array_push($datas["unsubscribes"], [
                "email_id"      => $unsubscribe_detail->email_id,
                "email_address" => $unsubscribe_detail->email_address,
                "reason"        => $unsubscribe_detail->reason,
                "merge_fields"  => $unsubscribe_detail->merge_fields,
                "campaign_id"   => $campaign_id
            ]);
        }

        foreach ($bounce_details as $bounce_detail){
            array_push($datas["bounce"], [
                "email_address" => $bounce_detail->email_address,
                "type"          => $bounce_detail->type,
            ]);
        }

        //$campaign_title = $report_detail['campaign_title'];
        return view('dashboard.contact_list', compact('datas', 'campaign_title'));
    }
}
