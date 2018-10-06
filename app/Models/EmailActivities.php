<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class EmailActivities extends Eloquent {

    use HybridRelations;
    protected $connection = 'mongodb';
    protected $collection = 'email_activities';
    protected $fillable   = [
                                'campaign_id',
                                'email_address',
                                'action',
                                'type'
                            ];
}
