<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    public function type_product() {
        return $this->belongsTo('App\Models\Type', 'type', 'id');
    }

    public function sub_type_product() {
        return $this->belongsTo('App\Models\SubType', 'sub_type', 'id');
    }
}
