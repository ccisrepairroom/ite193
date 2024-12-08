<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'vendor_image',
        'location',
        'contact_number',
       
    ];

    public function brand()
    {
        return $this->hasMany(Brand::class, 'vendor_id');
    }
    public function reorderRequest()
    {
        return $this->hasMany(ReorderRequest::class, 'vendor_id');
    }
    public function shipment()
    {
        return $this->hasMany(Shipment::class, 'vendor_id');
    }
}