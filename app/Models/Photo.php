<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    public function post_category()
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }

}
