<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Inventory;


class ReportController extends Controller
{
  public function dash()
    {      
        return view('report');
    }

 	public function getTotalSales(Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;

        // Calculate total sales between the provided dates
        $totalSales = Sale::whereBetween('sale_date', [$startDate, $endDate])
                          ->sum('sale_price'); // Replace 'sale_amount' with your column name for total sale value

        return response()->json(['totalSales' => $totalSales]);
    }

    public function getTotalCost(Request $request)
	{
	    $startDate = $request->startDate;
	    $endDate = $request->endDate;

	    // Here you need to define how you calculate the total cost from your inventory
	    $totalCost = Inventory::whereBetween('created_at', [$startDate, $endDate])->sum('totalcost'); // Example

	    return response()->json(['totalCost' => $totalCost]);
	}


}
