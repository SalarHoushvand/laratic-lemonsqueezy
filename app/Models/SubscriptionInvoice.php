<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use LemonSqueezy\Laravel\LemonSqueezy;
use LemonSqueezy\Laravel\Subscription;

/**
 * @property int $id
 * @property string|int $billable_id
 * @property string $billable_type
 * @property string $lemon_squeezy_id
 * @property string $subscription_id
 * @property string $customer_id
 * @property string $currency
 * @property int $subtotal
 * @property int $discount_total
 * @property int $tax
 * @property int $total
 * @property string $status
 * @property string|null $invoice_url
 * @property bool $refunded
 * @property CarbonInterface|null $refunded_at
 * @property string $billing_reason
 * @property string|null $card_brand
 * @property string|null $card_last_four
 * @property CarbonInterface $invoiced_at
 * @property CarbonInterface|null $created_at
 * @property CarbonInterface|null $updated_at
 * @property Billable $billable
 * @property Subscription $subscription
 */
class SubscriptionInvoice extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';

    public const STATUS_PAID = 'paid';

    public const STATUS_VOID = 'void';

    public const STATUS_REFUNDED = 'refunded';

    public const STATUS_PARTIAL_REFUND = 'partial_refund';

    public const BILLING_REASON_INITIAL = 'initial';

    public const BILLING_REASON_RENEWAL = 'renewal';

    public const BILLING_REASON_UPGRADE = 'upgrade';

    public const BILLING_REASON_DOWNGRADE = 'downgrade';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lemon_squeezy_subscription_invoices';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'subtotal' => 'integer',
        'discount_total' => 'integer',
        'tax' => 'integer',
        'total' => 'integer',
        'refunded' => 'boolean',
        'refunded_at' => 'datetime',
        'invoiced_at' => 'datetime',
    ];

    /**
     * Get the billable model related to the invoice.
     */
    public function billable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the subscription that this invoice belongs to.
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class, 'subscription_id', 'lemon_squeezy_id');
    }

    /**
     * Check if the invoice is pending.
     */
    public function pending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Filter query by pending.
     */
    public function scopePending(Builder $query): void
    {
        $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Check if the invoice is paid.
     */
    public function paid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }

    /**
     * Filter query by paid.
     */
    public function scopePaid(Builder $query): void
    {
        $query->where('status', self::STATUS_PAID);
    }

    /**
     * Check if the invoice is void.
     */
    public function void(): bool
    {
        return $this->status === self::STATUS_VOID;
    }

    /**
     * Filter query by void.
     */
    public function scopeVoid(Builder $query): void
    {
        $query->where('status', self::STATUS_VOID);
    }

    /**
     * Check if the invoice is refunded.
     */
    public function refunded(): bool
    {
        return $this->status === self::STATUS_REFUNDED;
    }

    /**
     * Filter query by refunded.
     */
    public function scopeRefunded(Builder $query): void
    {
        $query->where('status', self::STATUS_REFUNDED);
    }

    /**
     * Check if the invoice is partially refunded.
     */
    public function partiallyRefunded(): bool
    {
        return $this->status === self::STATUS_PARTIAL_REFUND;
    }

    /**
     * Filter query by partially refunded.
     */
    public function scopePartiallyRefunded(Builder $query): void
    {
        $query->where('status', self::STATUS_PARTIAL_REFUND);
    }

    /**
     * Check if the invoice is for initial billing.
     */
    public function isInitial(): bool
    {
        return $this->billing_reason === self::BILLING_REASON_INITIAL;
    }

    /**
     * Filter query by initial billing reason.
     */
    public function scopeInitial(Builder $query): void
    {
        $query->where('billing_reason', self::BILLING_REASON_INITIAL);
    }

    /**
     * Check if the invoice is for renewal billing.
     */
    public function isRenewal(): bool
    {
        return $this->billing_reason === self::BILLING_REASON_RENEWAL;
    }

    /**
     * Filter query by renewal billing reason.
     */
    public function scopeRenewal(Builder $query): void
    {
        $query->where('billing_reason', self::BILLING_REASON_RENEWAL);
    }

    /**
     * Check if the invoice is for upgrade billing.
     */
    public function isUpgrade(): bool
    {
        return $this->billing_reason === self::BILLING_REASON_UPGRADE;
    }

    /**
     * Filter query by upgrade billing reason.
     */
    public function scopeUpgrade(Builder $query): void
    {
        $query->where('billing_reason', self::BILLING_REASON_UPGRADE);
    }

    /**
     * Check if the invoice is for downgrade billing.
     */
    public function isDowngrade(): bool
    {
        return $this->billing_reason === self::BILLING_REASON_DOWNGRADE;
    }

    /**
     * Filter query by downgrade billing reason.
     */
    public function scopeDowngrade(Builder $query): void
    {
        $query->where('billing_reason', self::BILLING_REASON_DOWNGRADE);
    }

    /**
     * Get the invoice's subtotal.
     */
    public function subtotal(): string
    {
        return LemonSqueezy::formatAmount($this->subtotal, $this->currency);
    }

    /**
     * Get the invoice's discount total.
     */
    public function discount(): string
    {
        return LemonSqueezy::formatAmount($this->discount_total, $this->currency);
    }

    /**
     * Get the invoice's tax.
     */
    public function tax(): string
    {
        return LemonSqueezy::formatAmount($this->tax, $this->currency);
    }

    /**
     * Get the invoice's total.
     */
    public function total(): string
    {
        return LemonSqueezy::formatAmount($this->total, $this->currency);
    }

    /**
     * Sync the invoice with the given attributes from webhook.
     */
    public function sync(array $attributes): self
    {
        $this->update([
            'customer_id' => (string) ($attributes['customer_id'] ?? $this->customer_id),
            'currency' => $attributes['currency'] ?? $this->currency,
            'subtotal' => (int) ($attributes['subtotal'] ?? $this->subtotal),
            'discount_total' => (int) ($attributes['discount_total'] ?? $this->discount_total),
            'tax' => (int) ($attributes['tax'] ?? $this->tax),
            'total' => (int) ($attributes['total'] ?? $this->total),
            'status' => $attributes['status'] ?? $this->status,
            'invoice_url' => $attributes['urls']['invoice_url'] ?? $this->invoice_url,
            'refunded' => (bool) ($attributes['refunded'] ?? $this->refunded),
            'refunded_at' => isset($attributes['refunded_at']) ? Carbon::make($attributes['refunded_at']) : $this->refunded_at,
            'billing_reason' => $attributes['billing_reason'] ?? $this->billing_reason,
            'card_brand' => $attributes['card_brand'] ?? $this->card_brand,
            'card_last_four' => $attributes['card_last_four'] ?? $this->card_last_four,
            'invoiced_at' => isset($attributes['created_at']) ? Carbon::make($attributes['created_at']) : $this->invoiced_at,
        ]);

        return $this;
    }
}

