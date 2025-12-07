<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'country',
        'message',
        'data_processing_consent',
        'phone_consent',
        'marketing_consent',
    ];

    protected $casts = [
        'data_processing_consent' => 'boolean',
        'phone_consent' => 'boolean',
        'marketing_consent' => 'boolean',
    ];
}
