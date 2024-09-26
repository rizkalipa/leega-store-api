<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public const STATUS_DEFAULT = 'N';

    protected $guarded = [];

    public function order_details() {
        return $this->hasMany('App\Models\OrderDetails', 'order_id');
    }
}
