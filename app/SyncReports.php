<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class SyncReports extends Model {

    protected $table = 'sync_reports';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'user_id', 'report_id', 'last_synced'
    ];
}
