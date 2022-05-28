<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Hotel extends Model  implements TranslatableContract
{
    use Translatable;
    protected $table ='hotels';
    protected $guarded=[];
    public $translatedAttributes = ['name','description'];
    protected $casts=['images_path','order_count'];
    public function getImagesPathAttribute(){
       return $this->slider != null ?  asset('uploads/hotels/'.$this->slider) : asset('uploads/hotels/default.png');
    }
   
    public function books()
    {
        return $this->hasMany('App\Models\Book','hotel_id');
    }
    public function category()
    {
        return $this->belongsTo('App\Models\Category','category_id');
    }
}
