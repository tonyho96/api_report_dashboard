<?php

namespace App\Services;

use App\Models\ClickDetails;
use App\Models\ClickDetailsMembers;
use App\Models\EmailActivities;
use App\Models\Report;
use App\Models\SubscriberSummaries;
use App\Models\Recipients;
use App\Models\Activities;
use App\Models\DomainPerformances;
use App\Models\Unsubscribes;
use App\User;
use Request;

class MongoDBService {

	public static function saveReport( $report, $user ) {
		$reportData = Report::find( $report['id'] );

		if ( ! $reportData ) {
			$data              = new Report( $report );
			$data->last_synced = date( 'Y-m-d H:i:s', strtotime( '- 29 DAY' ) );
			$data->user_id     = $user->id;
			$data->save();
		} else {
			//$report['last_synced'] = date( 'Y-m-d H:i:s' );
			$reportData->update( $report );
			$reportData->user_id = $user->id;
			$reportData->save();
		}
	}

	public static function saveSubscriberSummaries( $report ) {
		$user = $report->user();

		$subscriberSummaries                = MailChimpService::getSubscribersuser( $report['list_id'], $user );
		$subscriberSummaries['campaign_id'] = $report['id'];
		$existedSubscriber                  = SubscriberSummaries::find( $subscriberSummaries['id'] );

		if ( $existedSubscriber ) {
			$existedSubscriber->update( $subscriberSummaries );
		} else {
			$existedSubscriber = new SubscriberSummaries( $subscriberSummaries );
		}
		$existedSubscriber->save();
	}

	public static function saveClickDetails( $report ) {
		$user = $report->user();

		$clickDetailUsers = MailChimpService::getClickDetailUser( $report['id'], $user );

		foreach ( $clickDetailUsers['urls_clicked'] as $clickDetailUser ) {
			$existedClickDetail = ClickDetails::find( $clickDetailUser['id'] );

			if ( $existedClickDetail ) {
				$existedClickDetail->update( $clickDetailUser );
			} else {
				$existedClickDetail = new ClickDetails( $clickDetailUser );
			}
			$existedClickDetail->save();
		}
	}

	public static function saveClickDetailsMembers( $report ) {
		$user = $report->user();

		$clicksDetails = MailChimpService::getClickDetailDataUser( $report['id'] );
		foreach ( $clicksDetails as $clicksDetail ) {
			if ( empty( $clicksDetail['total_clicks'] ) ) {
				continue;
			}

			$linkDetailMemberUsers = MailChimpService::getLinkDetailMembersUser( $report['id'], $clicksDetail['id'], $user );

			foreach ( $linkDetailMemberUsers['members'] as $linkDetailMemberUser ) {
				$existedClickDetailMember = ClickDetailsMembers::where( 'email_id', $linkDetailMemberUser['email_id'] )->where( 'campaign_id', $report['id'] )->first();

				if ( $existedClickDetailMember ) {
					$existedClickDetailMember->update( $linkDetailMemberUser );
				} else {
					$existedClickDetailMember = new ClickDetailsMembers( $linkDetailMemberUser );
				}
				$existedClickDetailMember->save();
			}
		}
	}

	public static function saveRecipients( $report ) {
		$user                = $report->user();
		$recipientsDataUsers = MailChimpService::getRecipientsDataUser( $report['id'], $user );
		foreach ( $recipientsDataUsers['sent_to'] as $recipient ) {
			$existedRecipients = Recipients::where( 'email_id', $recipient['email_id'] )->where( 'campaign_id', $report['id'] )->first();

			if ( $existedRecipients ) {
				$existedRecipients->update( $recipient );
			} else {
				$existedRecipients = new Recipients( $recipient );
			}
			$existedRecipients->save();

		}

	}

	public static function saveActivities( $report ) {
		$user = $report->user();

		$activities = MailChimpService::getActivityUser( $report['id'], $user );
		foreach ( $activities['emails'] as $activity ) {
			$existedActivity = Activities::where( 'email_id', $activity['email_id'] )->where( 'campaign_id', $report['id'] )->where( 'list_id', $activity['list_id'] )->first();

			if ( $existedActivity ) {
				$existedActivity->update( $activity );
			} else {
				$existedActivity = new Activities( $activity );
			}
			$existedActivity->save();
		}
	}

	public static function saveDomainPerformances( $report ) {
		$user = $report->user();

		$domains = MailChimpService::getDomainPerformanceUser( $report['id'], $user );
		foreach ( $domains['domains'] as $domain ) {
			$domain['campaign_id'] = $report['id'];
			$existedDomain         = DomainPerformances::where( 'campaign_id', $report['id'] )->where( 'domain', $domain['domain'] )->first();

			if ( $existedDomain ) {
				$existedDomain->update( $domain );
			} else {
				$existedDomain = new DomainPerformances( $domain );

			}
			$existedDomain->save();
		}
	}

	public static function saveUnsubscribes( $report ) {
		$user = $report->user();

		$unsubscribes = MailChimpService::getUnsubscribesDataUser( $report['id'], $user );
		foreach ( $unsubscribes as $unsubscribe ) {
			$existedUnscubsribes = Unsubscribes::where( 'email_id', $unsubscribe['email_id'] )->where( 'campaign_id', $report['id'] )->first();

			if ( $existedUnscubsribes ) {
				$existedUnscubsribes->update( $unsubscribe );
			} else {
				$existedUnscubsribes = new Unsubscribes( $unsubscribe );

			}
			$existedUnscubsribes->save();

		}
	}

	public static function saveEmailActivities( $report ) {
		$user = $report->user();

		$hardBounceUsers = MailChimpService::getHardBounceUser( $report['id'], $user );
		foreach ( $hardBounceUsers as $hardBounceUser ) {
			$existedEmailActivity = EmailActivities::where( 'campaign_id', $report['id'] )->where( 'email_address', $hardBounceUser['email_address'] )->first();

			if ( $existedEmailActivity ) {
				$existedEmailActivity->update( [
					'action' => $hardBounceUser['action'],
					'type'   => $hardBounceUser['type']
				] );
			} else {
				$existedEmailActivity = new EmailActivities( [
					'campaign_id'   => $report['id'],
					'email_address' => $hardBounceUser['email_address'],
					'action'        => $hardBounceUser['action'],
					'type'          => $hardBounceUser['type']
				] );
			}
			$existedEmailActivity->save();
		}
	}
}