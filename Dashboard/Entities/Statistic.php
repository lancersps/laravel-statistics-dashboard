<?php

namespace Modules\Dashboard\Entities;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model {
    
    protected $table = 'statistics__statistics';
    protected $fillable = [
        'ip',
        'country_code',
        'country_name',
        'region_code',
        'region_name',
        'city',
        'zip_code',
        'time_zone',
        'latitude',
        'longitude',
    ];
    
    
}
