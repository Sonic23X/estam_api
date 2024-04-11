<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'noService',
        'tariff',
        'connectedPower',
        'contractedPower',
        'monthlyConsumption',
        'annualConsumption',
        'user_id',
    ];

    protected $casts = [
        'monthlyConsumption' => 'array',
        'annualConsumption' => 'array',
    ];

    public function user() : \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
