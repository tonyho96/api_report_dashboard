<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class Activities extends Eloquent {

    use HybridRelations;
    protected $connection = 'mongodb';
    protected $collection = 'activities';
    protected $fillable   = [   'campaign_id',
                                'list_id',
                                'list_is_active',
                                'email_id',
                                'email_address',
                                'activity',
                                '_links'
                            ];
}