<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class ClickDetailsMembers extends Eloquent {

    use HybridRelations;
    protected $connection = 'mongodb';
    protected $collection = 'click_detail_members';
    protected $fillable   = [   'email_id',
                                'email_address',
                                'merge_fields',
                                'vip',
                                'clicks',
                                'campaign_id',
                                'url_id',
                                'list_id',
                                'list_is_active',
                                '_links'
                            ];
}