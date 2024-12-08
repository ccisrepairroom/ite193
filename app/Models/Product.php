<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'product_image',
        'size',
        'upc_code',
        'price',
        'brand_id',
        'product_type_id',

       
    ];
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }
    public function basketItem()
    {
        return $this->hasMany(BasketItem::class, 'product_id');
    }
    public function inventory()
    {
        return $this->hasMany(Inventory::class, 'product_id');
    }
    public function reorderRequest()
    {
        return $this->hasMany(ReorderRequest::class, 'product_id');
    }

}