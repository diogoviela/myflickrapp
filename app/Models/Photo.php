<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $table = 'images';

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'image',
        'thumbnail',
    ];

}
