<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public const STATUS_DEFAULT = 'N';
    public const STATUS_CHECKOUT = 'C';

    protected $guarded = [];

    protected $primaryKey = 'id';

    public function product() {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
}
