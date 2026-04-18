<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * The payments table uses order_id as primary key.
     * (The id column exists but is nullable in this schema.)
     */
    protected $primaryKey = 'order_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'order_id',
        'action_id',
        'amount',
        'status',
        'user_id',
        'customer_name',
        'product_name',
        'payment_proof',
        'verification_status'
    ];

    protected $casts = [
        'amount' => 'decimal:2'
    ];
    public $timestamps = false;


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
