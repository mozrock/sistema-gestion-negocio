<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceRecord extends Model
{
    protected $fillable = [
        'worker_id',
        'service_id',
        'payment_method_id',
        'created_by',
        'service_date',
        'start_time',
        'end_time',
        'service_price',
        'room_cost',
        'security_cost',
        'advance_payment',
        'additional_cost',
        'night_cost',
        'wipes_cost',
        'fine_amount',
        'fine_description',
        'notes',
        'total_discounts',
        'net_total',
        'owner_total',
        'worker_total',
        'pending_balance',
    ];

    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}