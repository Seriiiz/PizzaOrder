<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order_addon;
use App\Models\Addon;

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
        return $this->hasMany(Order_addon::class);
    }
}
