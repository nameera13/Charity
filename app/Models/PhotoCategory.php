<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoCategory extends Model
{
    use HasFactory;

    public function photo()
    {
        return $this->hasMany(Photo::class, 'photo_category_id');
    }
}
