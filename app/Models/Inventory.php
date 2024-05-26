<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'Inventory';
    public $timestamps = true;
     protected $fillable = [
        'lot', // Add 'lot' to the fillable array
        'grade',
        'qty',
        'qty_av',
        'costperkg',
        'totalcost',
    ];
}
