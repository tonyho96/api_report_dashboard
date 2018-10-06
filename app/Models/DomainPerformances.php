<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class DomainPerformances extends Eloquent {

    use HybridRelations;
    protected $connection = 'mongodb';
    protected $collection = 'domain_performances';
    protected $fillable   = [
                                'campaign_id',
                                'domain',
                                'emails_sent',
                                'bounces',
                                'opens',
                                'clicks',
                                'unsubs',
                                'delivered',
                                'emails_pct',
                                'bounces_pct',
                                'opens_pct',
                                'clicks_pct',
                                'unsubs_pct',
                            ];
}
