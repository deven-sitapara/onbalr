<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'program_id',
        'first_name',
        'last_name',
        'email',
        'mobile_number',
        'registration_type'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
