<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegionLabel extends Model
{
    protected $table = 'region_label';

    public $timestamps = false;

    protected $primaryKey = 'name';
}
