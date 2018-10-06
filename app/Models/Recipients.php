<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class Recipients extends Eloquent {

    use HybridRelations;
    protected $connection = 'mongodb';
    protected $collection = 'recipients';
    protected $fillable   = [   'email_id',
                                'email_address',
                                'merge_fields',
                                'vip',
                                'status',
                                'open_count',
                                'last_open',
                                'absplit_group',
                                'gmt_offset',
                                'campaign_id',
                                'list_id',
                                'list_is_active',
                                '_links'
                            ];
}