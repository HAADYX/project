<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Category extends Model implements TranslatableContract
{
    use Translatable;
    protected $table ='categories';
    protected $guarded=[];
    public $translatedAttributes = ['name'];
    protected $appended = ['image_path'];

    public function getImagePathAttribute(){
        return $this->image != null ? asset('uploads/categories/'.$this->image) :  asset('uploads/categories/default.jpg') ;
    }

}
