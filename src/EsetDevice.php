<?php

namespace Armincms\Eset;
 
use Illuminate\Database\Eloquent\{Model, SoftDeletes};   

class EsetDevice extends Model
{   
    use SoftDeletes; 

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'json',
    ]; 
}
