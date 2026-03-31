<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'amount',
        'status',
        'user_id'
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
