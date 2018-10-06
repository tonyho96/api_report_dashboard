<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Services\MailChimpService;
use Illuminate\Support\Facades\Auth;

class MailChimpController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $report = MailChimpService::getReport();
        return $report;
    }

    public function test() {
	    $campaign_id = '54f0382311';

	    $report_detail = MailChimpService::getReportDetail($campaign_id);
	    $click_detail = MailChimpService::getClickDetail($campaign_id);
	    //$domain_performance = MailChimpService::getDomainPerformance($campaign_id);
	    $recipients = MailChimpService::getRecipientsData($campaign_id);
	    $user         = Auth::user();
	    $user_id                = $user->id;
	    $obj_user               = User::find( $user_id );
	    $user_time_zone = $obj_user->time_zone;

	    $data =  $click_detail['urls_clicked'];

	    for ($i = 0; $i < sizeof($data) ; $i++){

		    for ($j = $i + 1; $j < sizeof($data) ; $j++){
			    if( $data[$i]['url'] == $data[$j]['url'] ){
				    $data[$i]['total_clicks']  += $data[$j]['total_clicks'];
				    $data[$i]['unique_clicks']  += $data[$j]['unique_clicks'];
				    unset($data[$j]);
				    $data = array_values($data);
			    }
		    }
	    }
	    $click_detail['urls_clicked'] = $data;
	    $response = compact('report_detail','click_detail', 'recipients', 'user_time_zone');
	    return response()->json($response);
    }
}
