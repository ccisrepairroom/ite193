<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubProductType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'product_type_id',
       
    ];
    public function productType()
    {
        return $this->belongsTo(ProductType::class, 'product_type_id');
    }

}