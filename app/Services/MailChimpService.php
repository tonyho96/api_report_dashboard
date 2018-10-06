<?php

namespace App\Services;

use App\Models\ClickDetails;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;


class MailChimpService {
	public static function getReport() {
		$client = new Client();
		$user   = Auth::user();

		$username = config( 'services.mailchimp.username' );
		if ( isset( $user->mailchimp_api_key ) ) {
			$API_key = $user->mailchimp_api_key;
			$tmp     = explode( '-', $API_key )[1];
			$offset  = 0;

			do {
				$res      = [];
				$response = $client->request( 'GET', 'https://' . $tmp . '.api.mailchimp.com/3.0/reports/?count=1000&offset=' . $offset, [ 'auth' => [ $username, $API_key ] ] );

				$response = json_decode( $response->getBody()->getContents(), true );
				$offset   += count( $response['reports'] );
				$res      = array_merge( $res, $response['reports'] );
			} while ( $offset < $response['total_items'] );

			return $res;
		} else {
			return [];
		}

	}

	public static function getReportUser( $user ) {
		$client = new Client();


		$username = config( 'services.mailchimp.username' );
		if ( isset( $user->mailchimp_api_key ) ) {
			$API_key = $user->mailchimp_api_key;
			$tmp     = explode( '-', $API_key )[1];
			$offset  = 0;
			$res     = [];

			do {
				$response = $client->request( 'GET', 'https://' . $tmp . '.api.mailchimp.com/3.0/reports/?count=1000&offset=' . $offset, [ 'auth' => [ $username, $API_key ] ] );

				$response = json_decode( $response->getBody()->getContents(), true );
				$offset   += count( $response['reports'] );
				$res      = array_merge( $res, $response['reports'] );
			} while ( $offset < $response['total_items'] );

			return $res;
		} else {
			return [];
		}
	}

	public static function getReportDetail( $campaign_id ) {
		$client = new Client();
		$user   = Auth::user();

		$username = config( 'services.mailchimp.username' );

		if ( isset( $user->mailchimp_api_key ) ) {
			$API_key = $user->mailchimp_api_key;
			$tmp     = explode( '-', $API_key )[1];

			$res = $client->request( 'GET', 'https://' . $tmp . '.api.mailchimp.com/3.0/reports/' . $campaign_id, [
				'auth' => [ $username, $API_key ]
			] );

			return json_decode( $res->getBody()->getContents(), true );
		} else {
			return [];
		}
	}

	public static function getClickDetail( $campaign_id ) {
		$client = new Client();
		$user   = Auth::user();

		$username = config( 'services.mailchimp.username' );

		if ( isset( $user->mailchimp_api_key ) ) {

			$API_key = $user->mailchimp_api_key;
			$tmp     = explode( '-', $API_key )[1];

			$res = $client->request( 'GET', 'https://' . $tmp . '.api.mailchimp.com/3.0/reports/' . $campaign_id . '/click-details', [
				'auth' => [ $username, $API_key ]
			] );

			return json_decode( $res->getBody()->getContents(), true );
		} else {
			return [];
		}
	}

	public static function getClickDetailUser( $campaign_id, $user ) {
		$client   = new Client();
		$username = config( 'services.mailchimp.username' );

		if ( isset( $user->mailchimp_api_key ) ) {

			$API_key = $user->mailchimp_api_key;
			$tmp     = explode( '-', $API_key )[1];

			$res = $client->request( 'GET', 'https://' . $tmp . '.api.mailchimp.com/3.0/reports/' . $campaign_id . '/click-details', [
				'auth' => [ $username, $API_key ]
			] );

			return json_decode( $res->getBody()->getContents(), true );
		} else {
			return [];
		}
	}

	public static function getLinkDetailMembers( $campaignId, $linkId ) {
		$client = new Client();
		$user   = Auth::user();

		$username = config( 'services.mailchimp.username' );

		if ( isset( $user->mailchimp_api_key ) ) {

			$API_key = $user->mailchimp_api_key;
			$tmp     = explode( '-', $API_key )[1];

			$res = $client->request( 'GET', "https://$tmp.api.mailchimp.com/3.0/reports/$campaignId/click-details/$linkId/members", [
				'auth' => [ $username, $API_key ]
			] );

			return json_decode( $res->getBody()->getContents(), true );
		} else {
			return [];
		}
	}

	public static function getLinkDetailMembersUser( $campaignId, $linkId, $user ) {
		$client   = new Client();
		$username = config( 'services.mailchimp.username' );

		if ( isset( $user->mailchimp_api_key ) ) {

			$API_key = $user->mailchimp_api_key;
			$tmp     = explode( '-', $API_key )[1];

			$res = $client->request( 'GET', "https://$tmp.api.mailchimp.com/3.0/reports/$campaignId/click-details/$linkId/members", [
				'auth' => [ $username, $API_key ]
			] );

			return json_decode( $res->getBody()->getContents(), true );
		} else {
			return [];
		}

	}

	public static function getDomainPerformance( $campaign_id ) {
		$client   = new Client();
		$user     = Auth::user();
		$username = config( 'services.mailchimp.username' );

		if ( isset( $user->mailchimp_api_key ) ) {
			$API_key = $user->mailchimp_api_key;
			$tmp     = explode( '-', $API_key )[1];


			$res = $client->request( 'GET', 'https://' . $tmp . '.api.mailchimp.com/3.0/reports/' . $campaign_id . '/domain-performance', [
				'auth' => [ $username, $API_key ]
			] );

			return json_decode( $res->getBody()->getContents(), true );
		} else {
			return [];
		}

	}

	public static function getDomainPerformanceUser( $campaign_id, $user ) {
		$client   = new Client();
		$username = config( 'services.mailchimp.username' );

		if ( isset( $user->mailchimp_api_key ) ) {
			$API_key = $user->mailchimp_api_key;
			$tmp     = explode( '-', $API_key )[1];

			$res = $client->request( 'GET', 'https://' . $tmp . '.api.mailchimp.com/3.0/reports/' . $campaign_id . '/domain-performance', [
				'auth' => [ $username, $API_key ]
			] );

			return json_decode( $res->getBody()->getContents(), true );
		} else {
			return [];
		}
	}

	public static function getSubscribers( $list_id ) {
		$client   = new Client();
		$user     = Auth::user();
		$username = config( 'services.mailchimp.username' );

		if ( isset( $user->mailchimp_api_key ) ) {
			$API_key = $user->mailchimp_api_key;
			$tmp     = explode( '-', $API_key )[1];

			$res = $client->request( 'GET', 'https://' . $tmp . '.api.mailchimp.com/3.0/lists/' . $list_id, [
				'auth' => [ $username, $API_key ]
			] );

			return json_decode( $res->getBody()->getContents(), true );
		} else {
			return [];
		}
	}

	public static function getSubscribersuser( $list_id, $user ) {
		$client   = new Client();
		$username = config( 'services.mailchimp.username' );

		if ( isset( $user->mailchimp_api_key ) ) {
			$API_key = $user->mailchimp_api_key;
			$tmp     = explode( '-', $API_key )[1];

			$res = $client->request( 'GET', 'https://' . $tmp . '.api.mailchimp.com/3.0/lists/' . $list_id, [
				'auth' => [ $username, $API_key ]
			] );

			return json_decode( $res->getBody()->getContents(), true );
		} else {
			return [];
		}

	}

	public static function buildReportChart( $reports ) {
		$res = [
			'labels' => [ 'Clicks', 'Opens', 'Industry Opens' ],
			'data'   => []
		];
		foreach ( $reports as $report ) {
			$res['data'][] = [
				'y' => $report['campaign_title'],
				'a' => number_format( $report['clicks']['click_rate'] * 100, 1 ),
				'b' => number_format( $report['opens']['open_rate'] * 100, 1 ),
				'c' => isset( $report['industry_stats']['open_rate'] ) ? number_format( $report['industry_stats']['open_rate'] * 100, 1 ) : 0
			];
		}

		return $res;
	}

	public static function getRecipientsData( $campaign_id ) {
		$client = new Client();
		$user   = Auth::user();

		$username = config( 'services.mailchimp.username' );

		if ( isset( $user->mailchimp_api_key ) ) {
			$API_key = $user->mailchimp_api_key;
			$tmp     = explode( '-', $API_key )[1];

			$res = $client->request( 'GET', 'https://' . $tmp . '.api.mailchimp.com/3.0/reports/' . $campaign_id . '/sent-to', [
				'auth' => [ $username, $API_key ]
			] );

			return json_decode( $res->getBody()->getContents(), true );
		} else {
			return [];
		}
	}

	public static function getRecipientsDataUser( $campaign_id, $user ) {
		$client = new Client();

		$username = config( 'services.mailchimp.username' );

		if ( isset( $user->mailchimp_api_key ) ) {
			$API_key = $user->mailchimp_api_key;
			$tmp     = explode( '-', $API_key )[1];

			$res = $client->request( 'GET', 'https://' . $tmp . '.api.mailchimp.com/3.0/reports/' . $campaign_id . '/sent-to', [
				'auth' => [ $username, $API_key ]
			] );

			return json_decode( $res->getBody()->getContents(), true );
		} else {
			return [];
		}

	}

	public static function convertURLToName( $url ) {
		$clean_url = preg_replace( '/\?.*/', '', $url );
		$clean_url = preg_replace( '/\.pdf$/i', '', $clean_url );
		$clean_url = preg_replace( '/[_\-]/', ' ', $clean_url );
		$clean_url = trim( $clean_url, "/" );

		preg_match( '/([^\/]+)$/', $clean_url, $name_array );
		$name = @$name_array[0];
		if ( empty( $name ) ) {
			$name = $clean_url;
		}

		if ( stripos( $name, ' ' ) !== false ) {
			return ucwords( $name );
		}

		return $name;
	}

	public static function getClickDetailData( $campaign_id ) {
		$click_detail  = MailChimpService::getClickDetail( $campaign_id );
		$urls_clicked  = [];
		$total_clicked = 0;
		foreach ( $click_detail['urls_clicked'] as $click ) {
			$url = $click['url'];
			if ( isset( $urls_clicked[ $url ] ) ) {
				$urls_clicked[ $url ]['total_clicks']  += $click['total_clicks'];
				$urls_clicked[ $url ]['unique_clicks'] += $click['unique_clicks'];
			} else {
				$urls_clicked[ $url ] = $click;
			}
			$total_clicked += $click['total_clicks'];
		}

		foreach ( $urls_clicked as $key => $value ) {
			$urls_clicked[ $key ]['percent_total_clicked'] = number_format( $value['total_clicks'] * 100 / $total_clicked, 0 );
		}
		$click_detail['urls_clicked'] = array_values( $urls_clicked );

		foreach ( $click_detail['urls_clicked'] as $key => $value ) {
			$name                                         = MailChimpService::convertURLToName( $value['url'] );
			$click_detail['urls_clicked'][ $key ]['name'] = $name;
		}

		return $click_detail;
	}

	public static function getClickDetailDataUser( $campaignId ) {
		$clickDetails  = ClickDetails::where('campaign_id', $campaignId)->get()->toArray();
		$urlsClicked  = [];
		$totalClicked = 0;
		foreach ( $clickDetails as $click ) {

			$url = $click['url'];
			if ( isset( $urlsClicked[ $url ] ) ) {
				$urlsClicked[ $url ]['total_clicks']  += $click['total_clicks'];
				$urlsClicked[ $url ]['unique_clicks'] += $click['unique_clicks'];
			} else {
				$urlsClicked[ $url ] = $click;
			}
			$totalClicked += $click['total_clicks'];
		}
		//Fix Division by zero
		if($totalClicked == 0){
            $totalClicked = 1;
        }

		foreach ( $urlsClicked as $key => $value ) {
			$urlsClicked[ $key ]['percent_total_clicked'] = number_format( $value['total_clicks'] * 100 / $totalClicked, 0 );
		}
		$clickDetails = array_values( $urlsClicked );

		foreach ( $clickDetails as $key => $value ) {
			$name                                         = MailChimpService::convertURLToName( $value['url'] );
			$clickDetails[ $key ]['name'] = $name;
		}

		return $clickDetails;
	}

	public static function getActivity( $campaign_id ) {
		$client = new Client();
		$user   = Auth::user();

		$username = config( 'services.mailchimp.username' );

		if ( isset( $user->mailchimp_api_key ) ) {
			$API_key = $user->mailchimp_api_key;
			$tmp     = explode( '-', $API_key )[1];

			$total = 10;
			$res   = $client->request( 'GET', 'https://' . $tmp . '.api.mailchimp.com/3.0/reports/' . $campaign_id . '/email-activity?count=' . $total . '&sort_field=activity&sort_dir=DESC', [
				'auth' => [ $username, $API_key ]
			] );

			return json_decode( $res->getBody()->getContents(), true );
		} else {
			return [];
		}

	}

	public static function getActivityUser( $campaign_id, $user ) {
		$client   = new Client();
		$username = config( 'services.mailchimp.username' );

		if ( isset( $user->mailchimp_api_key ) ) {
			$API_key = $user->mailchimp_api_key;
			$tmp     = explode( '-', $API_key )[1];

			$total = 10;
			$res   = $client->request( 'GET', 'https://' . $tmp . '.api.mailchimp.com/3.0/reports/' . $campaign_id . '/email-activity?count=' . $total . '&sort_field=activity&sort_dir=DESC', [
				'auth' => [ $username, $API_key ]
			] );

			return json_decode( $res->getBody()->getContents(), true );
		} else {
			return [];
		}

	}

	public static function getUnsubscribesData( $campaign_id ) {
		$client = new Client();
		$user   = Auth::user();

		$username = config( 'services.mailchimp.username' );

		if ( isset( $user->mailchimp_api_key ) ) {
			$API_key = $user->mailchimp_api_key;
			$tmp     = explode( '-', $API_key )[1];

			$offset = 0;
			$res    = [];
			do {
				$response = $client->request( 'GET', 'https://' . $tmp . '.api.mailchimp.com/3.0/reports/' . $campaign_id . '/unsubscribed?count=1000&offset=' . $offset, [
					'auth' => [ $username, $API_key ]
				] );
				$response = json_decode( $response->getBody()->getContents(), true );
				$offset   += count( $response['reports'] );
				$res      = array_merge( $res, $response['unsubscribes'] );
			} while ( $offset < $response['total_items'] );

			return $res;
		} else {
			return [];
		}

	}

	public static function getUnsubscribesDataUser( $campaign_id, $user ) {
		$client = new Client();

		$username = config( 'services.mailchimp.username' );

		if ( isset( $user->mailchimp_api_key ) ) {
			$API_key = $user->mailchimp_api_key;
			$tmp     = explode( '-', $API_key )[1];

			$offset = 0;
			$res    = [];
			do {
				$response = $client->request( 'GET', 'https://' . $tmp . '.api.mailchimp.com/3.0/reports/' . $campaign_id . '/unsubscribed?count=1000&offset=' . $offset, [
					'auth' => [ $username, $API_key ]
				] );
				$response = json_decode( $response->getBody()->getContents(), true );
				$offset   += count( $response['unsubscribes'] );
				$res      = array_merge( $res, $response['unsubscribes'] );
			} while ( $offset < $response['total_items'] );

			return $res;
		} else {
			return [];
		}

	}

	public static function getHardBounce( $campaign_id ) {
		$client = new Client();
		$user   = Auth::user();

		$username = config( 'services.mailchimp.username' );

		if ( isset( $user->mailchimp_api_key ) ) {
			$API_key = $user->mailchimp_api_key;
			$tmp     = explode( '-', $API_key )[1];
			$res     = $client->request( 'GET', 'https://' . $tmp . '.api.mailchimp.com/3.0/reports/' . $campaign_id . '/email-activity?count=1', [ 'auth' => [ $username, $API_key ] ] );
			$total   = json_decode( $res->getBody()->getContents(), true )["total_items"];
			$res     = $client->request( 'GET', 'https://' . $tmp . '.api.mailchimp.com/3.0/reports/' . $campaign_id . '/email-activity?count=' . $total, [
				'auth' => [ $username, $API_key ]
			] );

			$datas  = json_decode( $res->getBody()->getContents(), true )["emails"];
			$result = [];
			foreach ( $datas as $data ) {
				foreach ( $data["activity"] as $activity ) {
					if ( isset( $activity["type"] ) && $activity["type"] == 'hard' ) {
						array_push( $result, [ 'email_address' => $data["email_address"], 'action' => $activity["action"], 'type' => $activity["type"] ] );
					}
				}
			}

			return $result;
		} else {
			return '';
		}

	}

	public static function getHardBounceUser( $campaign_id, $user ) {
		$client   = new Client();
		$username = config( 'services.mailchimp.username' );

		if ( isset( $user->mailchimp_api_key ) ) {
			$API_key = $user->mailchimp_api_key;
			$tmp     = explode( '-', $API_key )[1];

            $offset = 0;
            $result = [];
            do {
                $res = $client->request('GET', 'https://' . $tmp . '.api.mailchimp.com/3.0/reports/' . $campaign_id . '/email-activity?count=300&offset=' . $offset, ['auth' => [$username, $API_key]]);
//                $total = json_decode($res->getBody()->getContents(), true)["total_items"];
//                $res = $client->request('GET', 'https://' . $tmp . '.api.mailchimp.com/3.0/reports/' . $campaign_id . '/email-activity?count=' . $total, [
//                    'auth' => [$username, $API_key]
//                ]);

                $res = json_decode($res->getBody()->getContents(), true);

                $offset   += count( $res['emails'] );


                foreach ($res["emails"] as $data) {
                    foreach ($data["activity"] as $activity) {
                        if (isset($activity["type"]) && $activity["type"] == 'hard') {
                            array_push($result, ['email_address' => $data["email_address"], 'action' => $activity["action"], 'type' => $activity["type"]]);
                        }
                    }
                }
            }while($offset < $res['total_items']);

			return $result;
		} else {
			return [];
		}

	}

}
