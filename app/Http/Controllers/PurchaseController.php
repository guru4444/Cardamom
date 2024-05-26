<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;

class PurchaseController extends Controller
{
    public function dash()
    {      
		$purchases_done = Purchase::all();              
        return view('purchase',compact('purchases_done'));
    }
}
