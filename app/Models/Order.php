<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Transaction;

class Order extends Model
{
    use HasFactory;

    /**
     * Order belongs to a User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Order has many OrderItems.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Order has one Transaction.
     */
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    /**
     * (Optional) Order may have a shipping address.
     * Uncomment if using Address model:
     */
    // public function address()
    // {
    //     return $this->belongsTo(Address::class);
    // }
}
