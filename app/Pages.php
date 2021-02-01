<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Str;

class Pages extends Model
{



    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pages';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['slug','title', 'content', 'section_id', 'shared', 'created_by', 'created_at', 'updated_at'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $with = ['share','attatchments'];

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

    public function section()
    {
        return $this->belongsTo('App\Sections');
    }

    public function user()
    {
        return $this->belongsTo('App\User','created_by','id');
    }


    public function share()
    {
        return $this->hasMany('App\Shares','page_id');
    }

    public function attatchments()
    {
        return $this->hasMany('App\Attatchment','page_id');
    }
    /*
    |---------------------------------------------
    | get auto generated excerpt
    |---------------------------------------------
    |
    */
    public function getAutoExcerptAttribute()
    {
        return Str::limit(strip_tags($this->content),150,'...');
    }

    /*
    |---------------------------------------------
    | get auto generated excerpt
    |---------------------------------------------
    |
    */
    public function getOwnAttribute()
    {
        return $this->created_by == auth()->id();
    }


    public function getSlugAttribute()
    {
        # remove ? mark from string
        $slug = preg_replace('/\?/u', ' ', trim($this->title));
        $slug = preg_replace('/\s+/u', '-', trim($slug));

        return $slug;
    }



}
