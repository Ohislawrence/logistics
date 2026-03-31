<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tracking_id',
        'recipient_name',
        'recipient_phone',
        'pickup_address',
        'delivery_address',
        'cost',
        'assigned_to',
        'status',
        'notes',
        'paid',
        'paid_at',
        'paid_by',
    ];

    protected $casts = [
        'paid' => 'boolean',
        'paid_at' => 'datetime',
        'cost' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::creating(function (Order $order) {
            if (empty($order->tracking_id)) {
                do {
                    $candidate = strtoupper(Str::random(10));
                } while (self::where('tracking_id', $candidate)->exists());

                $order->tracking_id = $candidate;
            }
        });
    }

    public function progresses(): HasMany
    {
        return $this->hasMany(OrderProgress::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function paidBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'paid_by');
    }
}
