<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasketItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'market_basket_id',
        'product_id',


       
    ];

    public function marketBasket()
    {
        return $this->belongsTo(MarketBasket::class, 'market_basket_id');
    }
    public function product()
    {
        return $this->hasMany(Product::class, 'product_id');
    }
}