<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;
    protected $fillable = [
        'shipment_date',
        'delivery_date',
        'vendor_id',
        'reorder_request_id',
       
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
    public function reorderRequest()
    {
        return $this->belongsTo(ReorderRequest::class, 'reorder_request_id');
    }

}