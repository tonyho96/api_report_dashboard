<?php

namespace App\Services;

use App\Models\Report;
use App\SyncReports;
use App\Services\MongoDBService;

use App\User;
use Request;
use DB;
use Auth;

class CronService {

	public static function syncReportsForOldestUser() {
		$user = User::where( 'role', config( 'user.role.User' ) )->orderBy( 'last_sync', 'asc' )->first();

		$reports         = MailChimpService::getReportUser( $user );
		$user->last_sync = date( 'Y-m-d H:i:s' );
		$user->save();

		foreach ( $reports as $report ) {
			MongoDBService::saveReport( $report, $user );
		}
	}

	public static function syncOldestReports() {
		$limit   = config('cron.sync_oldest_report_limit');
		$reports = Report::orderBy( 'last_synced', 'asc' )->limit( $limit )->get();

		foreach ( $reports as $report ) {
            $date = (date_diff(date_create($report->send_time),date_create(date('Y-m-d'))));
            if($date->days >= 30) {
                self::syncReportDetail($report);
            }
		}
	}

	// duration is about 80 seconds
	private static function syncReportDetail( $report ) {
		$report->last_synced = date( 'Y-m-d H:i:s' );
		$report->save();

		MongoDBService::saveSubscriberSummaries( $report );
		MongoDBService::saveClickDetails( $report );
		MongoDBService::saveClickDetailsMembers( $report );
		MongoDBService::saveRecipients( $report );
		MongoDBService::saveActivities( $report );
		MongoDBService::saveDomainPerformances( $report );
		MongoDBService::saveUnsubscribes( $report );
		MongoDBService::saveEmailActivities( $report );
	}
}