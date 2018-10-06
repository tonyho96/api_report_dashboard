<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class SubscriberSummaries extends Eloquent {

    use HybridRelations;
    protected $connection = 'mongodb';
    protected $collection = 'subscriber_summaries';
    protected $fillable   = [   'id',
	                            'campaign_id',
                                'web_id',
                                'name',
                                'contact',
                                'permission_reminder',
                                'use_archive_bar',
                                'campaign_defaults',
                                'notify_on_subscribe',
                                'notify_on_unsubscribe',
                                'date_created',
                                'list_rating',
                                'email_type_option',
                                'subscribe_url_short',
                                'subscribe_url_long',
                                'beamer_address',
                                'visibility',
                                'double_optin',
                                'modules',
                                'stats',
                                '_links',
                            ];
    protected $primaryKey = 'id';
}