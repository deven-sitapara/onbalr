<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsitePages extends Model
{
    use HasFactory;

    protected $table = 'website_pages'; // Table name

    protected $fillable = [
        'title',
        'slug',
        'html',
        'css',
    ];
}
