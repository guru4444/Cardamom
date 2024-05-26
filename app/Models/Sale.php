<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id', 'sale_qty', 'sale_price','sale_grade', 'sale_date', 'inventory_items'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }


}
