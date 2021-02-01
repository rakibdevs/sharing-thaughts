<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{



    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sections';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'slug', 'topic_id', 'created_by', 'created_at', 'updated_at'];

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



    public function topic()
    {
        return $this->belongsTo('App\Topics');
    }


    public function page()
    {
        return $this->hasMany('App\Pages','section_id');
    }


    # verify and return custom slug string
    public function slugify($text)
    {
        # remove ? mark from string
        $slug = preg_replace('/\?/u', ' ', trim($text));
        $slug = preg_replace('/\s+/u', '-', trim($slug));

        # slug repeat check
        $latest = $this->whereRaw("slug REGEXP '^{$slug}(-[0-9]+)?$'")
                       ->latest('id')
                       ->value('slug');

        if($latest){
            $pieces = explode('-', $latest);
            $number = intval(end($pieces));
            $slug .= '-' . ($number + 1);
        }

        

        return $slug;
    }

}
