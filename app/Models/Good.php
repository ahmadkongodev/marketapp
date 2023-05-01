<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    use HasFactory;
    protected $fillable = [
     //   'good_image',
        'good_name',
        'good_description',
        'good_quantity',
        'good_unit_price',
    ];
    public $timestamps=false;
    public function uploadImage($image)
    {
        $path = $image->store('images');
        $this->image = $path;
    }
}
