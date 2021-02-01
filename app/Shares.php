<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shares extends Model
{



    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'shares';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['page_id', 'shared_with', 'created_at', 'updated_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    public function page()
    {
        return $this->belongsTo('App\Pages');
    }

    public function user()
    {
        return $this->belongsTo('App\User','shared_with');
    }

}
