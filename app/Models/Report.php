<?php

namespace App\Models;

use App\User;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class Report extends Eloquent{

	use HybridRelations;
	protected $connection = 'mongodb';
	protected $collection = 'reports';
	protected $fillable   = [   'id',
                                'campaign_title',
                                'type',
                                'list_id',
                                'list_is_active',
                                'list_name',
                                'subject_line',
                                'preview_text',
                                'emails_sent',
                                'abuse_reports',
                                'unsubscribed',
                                'send_time',
                                'bounces',
                                'forwards',
                                'opens',
                                'clicks',
                                'facebook_likes',
                                'industry_stats',
                                'list_stats',
                                'timeseries',
                                'ecommerce',
                                'delivery_status',
                                '_links',
                                'last_synced',
								'user_id'
                            ];
	protected $primaryKey = 'id';

	public function user() {
		return User::where('id', $this->user_id)->first();
	}
}