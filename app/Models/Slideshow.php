<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
            
class Slideshow extends Model
{
    protected $table = 'slideshow';
    protected $primaryKey = 'Id_slideshow';

    protected $fillable = [
        'gambar_slideshow',
    ];
    public $timestamps = false;
            
}
