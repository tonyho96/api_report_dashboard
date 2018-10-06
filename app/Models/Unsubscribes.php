<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class Unsubscribes extends Eloquent {

    use HybridRelations;
    protected $connection = 'mongodb';
    protected $collection = 'unsubscribes';
    protected $fillable   = [   
                                'email_id',
                                'email_address',
                                'merge_fields',
                                'vip',
                                'timestamp',
                                'reason',
                                'campaign_id',
                                'list_id',
                                'list_is_active',
                                '_links'
                            ];
}
