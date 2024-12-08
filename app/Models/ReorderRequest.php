<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReorderRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'quantity',
        'request_date',
        'status',
        'shipment_location',
        'product_id',
        'store_id',
        'vendor_id',



       
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'reorder_request_id');
    }
}