<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;
    // Cast the `product_type_id` field to an array or JSON
    protected $casts = [
        'product_type_id' => 'array',  // For storing it as an array (in case you're using JSON column)
    ];
    protected $fillable = [
        'name',
    ];

    public function subProductType()
    {
        return $this->hasMany(SubProductType::class, 'product_type_id');
    }
    public function product()
    {
        return $this->hasMany(Product::class, 'product_type_id');
    }

    

}