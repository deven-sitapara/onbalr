<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'details',
        'start_date',
        'end_date',
        'price',
        'currency',
        'payment_plan_active',
        'installments',
        'discount_code',
        'discount_expiration',
        'discount_amount',
        'redemption_limit',
        'registration_type',
        'required_fields',
        'custom_questions',
        'donations_enabled',
        'donation_presets',
        'allow_custom_donation',
        'min_donation',
        'max_donation',
        'user_id'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'price' => 'decimal:2',
        'payment_plan_active' => 'boolean',
        'installments' => 'array',
        'required_fields' => 'array',
        'custom_questions' => 'array',
        'donations_enabled' => 'boolean',
        'donation_presets' => 'array',
        'allow_custom_donation' => 'boolean',
        'min_donation' => 'decimal:2',
        'max_donation' => 'decimal:2',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
