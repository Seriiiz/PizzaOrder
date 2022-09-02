<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Addon;
use App\Models\Listing;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_contact',
        'customer_email',
        'customer_address',
        'flavor',
        'size',
        'delivery_time',
        'remarks'
    ];

    public function addons(){
        return $this->belongsToMany(Addon::class, 'order_addons');
    }
}
