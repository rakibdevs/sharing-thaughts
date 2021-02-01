<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attatchment extends Model
{
    //
    protected $fillable = ['page_id', 'url', 'name', 'created_at', 'updated_at'];

    public function page()
    {
        return $this->belongsTo('App\Pages','page_id','id');
    }
}
