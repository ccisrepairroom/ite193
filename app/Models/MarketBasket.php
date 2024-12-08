<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketBasket extends Model
{
    use HasFactory;
    protected $fillable = [
        'total_amount',
        'purchase_date',
        'location',
        'contact_number',
        'user_id',
        'store_id',


       
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
    public function basketItem()
    {
        return $this->hasMany(BasketItem::class, 'market_basket_id');
    }
}