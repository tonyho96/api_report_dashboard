<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class ClickDetails extends Eloquent {

    use HybridRelations;
    protected $connection = 'mongodb';
    protected $collection = 'click_details';
    protected $fillable   = [   'id',
                                'url',
                                'total_clicks',
                                'click_percentage',
                                'unique_clicks',
                                'unique_click_percentage',
                                'last_click',
                                'campaign_id',
                                '_links'
                            ];
    protected $primaryKey = 'id';
}