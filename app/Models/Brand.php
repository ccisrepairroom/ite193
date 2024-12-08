<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'brand_image',
        'vendor_id',
       
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
    public function product()
    {
        return $this->hasMany(Product::class, 'brand_id');
    }

   
}