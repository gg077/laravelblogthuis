<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    /** @use HasFactory<\Database\Factories\PhotoFactory> */
    use HasFactory;

    protected $fillable = ['path' , 'alternate_text'];

    public function user()
    {
        return $this->hasOne(User::class, 'photo_id');
    }
}
