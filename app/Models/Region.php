<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    use SoftDeletes;

    protected $table = 'regions';

    public $timestamps = true;

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    protected $fillable = [
        'name', 'parent_id', 'order'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('name', function(Builder $builder) {
            $builder->orderBy('name', 'ASC');
        });
    }

    public function parentRegion(){
    	return $this->belongsTo('App\Models\Region', 'parent_id');
    }

    public function regions(){
    	return $this->hasMany('App\Models\Region', 'parent_id');
    }
}
