<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'details',
        'price',
        'currency',
        'is_active'
    ];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
