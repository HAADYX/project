<?php

namespace App\Models;
use App\Scopes\PermScope;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table ='books';
    protected $guarded=[];
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new PermScope);
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function hotel()
    {
        return $this->belongsTo('App\Models\Hotel','hotel_id');
    }
}
