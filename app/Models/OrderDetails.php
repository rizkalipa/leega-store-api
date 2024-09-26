<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;

    protected $guarded;

    protected $primaryKey = 'order_id';

    public $incrementing = false;

    public function product() {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
}
