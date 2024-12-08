<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'store_image',
        'location',
        'opening_hours',
       
    ];

    public function marketBasket()
    {
        return $this->hasMany(MarketBasket::class, 'store_id');
    }
    public function inventory()
    {
        return $this->hasMany(Inventory::class, 'store_id');
    }
    public function reorderRequest()
    {
        return $this->hasMany(ReorderRequest::class, 'store_id');
    }
}