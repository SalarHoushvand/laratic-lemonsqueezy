<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use LemonSqueezy\Laravel\Billable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable 
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use Billable, HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'password',
        'phone',
        'country',
        'street',
        'city',
        'state',
        'zip',
        'timezone',
        'two_factor_enabled',
        'phone_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'phone_verified_at' => 'datetime',
            'two_factor_enabled' => 'boolean',
        ];
    }

    /**
     * Normalize phone number to digits only (e.g., 1234567890)
     */
    protected function phone(): Attribute
    {
        return Attribute::make(
            set: fn (?string $value) => $value ? preg_replace('/\D/', '', $value) : null,
        );
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    /**
     * Get the user's current plan name.
     */
    public function currentPlanName(): ?string
    {
        $subscription = $this->subscription();

        if (! $subscription || ! $subscription->valid()) {
            return null;
        }

        if (! $subscription->variant_id) {
            return null;
        }

        $plan = Plan::where('lemon_squeezy_variant_id', $subscription->variant_id)->first();

        return $plan?->name;
    }

    /**
     * Get the user's orders.
     */
    // public function orders()
    // {
    //     return $this->hasMany(Order::class);
    // }

    /**
     * Get the user's social logins.
     */
    public function socialLogins()
    {
        return $this->hasMany(SocialLogin::class);
    }
}
