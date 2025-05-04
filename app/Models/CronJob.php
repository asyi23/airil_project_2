<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CronJob extends Model
{
    protected $table = 'tbl_cron_job';

    protected $primaryKey = 'cron_job_id';

    const CREATED_AT = 'cron_job_created';
    const UPDATED_AT = 'cron_job_updated';
    protected $dateFormat = 'Y-m-d H:i:s';

    protected $fillable = [
        'cron_job_name' , 'cron_job_finished'
    ];


}
