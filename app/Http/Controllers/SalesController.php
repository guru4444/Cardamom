<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Customer;
use App\Models\Sale;


class SalesController extends Controller
{
    public function dash()
    {      
		$customers = Customer::all();
		$sales = Sale::paginate(10); // Paginate the initial sales data

        return view('sales', compact('customers', 'sales'));
    }
    public function getInventoryItems(Request $request)
		{
		    $grade = $request->input('grade');
		    $inventoryItems = Inventory::where('grade', $grade)->where('qty_av', '>', 0)->get();
		    return view('inventory_items_modal', compact('inventoryItems'));
		}

	public function recordSale(Request $request) {
		    $customerId = $request->input('customer_id');
		    $sale_qty = $request->input('sale_qty');
		    $sale_price = $request->input('sale_price');
		    $sale_grade = $request->input('sale_grade');
		    $sale_date = $request->input('sale_date');
			$inventory_items = $request->input('inventory_items'); // This would be a string like "1:5,2:3"


		    // Here, you would store the sale in your database, associating it with the given customer.
		    // Assuming you have a Sale model, it might look something like:

		    $sale = new Sale([
		        'customer_id' => $customerId,
		        'sale_qty' => $sale_qty,
		        'sale_price' => $sale_price,
		        'sale_grade' => $sale_grade,
		        'sale_date' => $sale_date,
		        'inventory_items' => $inventory_items,
		    ]);

		    $sale->save();

		    return response()->json(['success' => true]);
		}

	public function getSales(Request $request)
		{
		    $startDate = $request->startDate;
		    $endDate = $request->endDate;

		    // Fetch sales data between the start and end date
    		$sales = Sale::whereBetween('sale_date', [$startDate, $endDate])->paginate(10);

		    // Return the data as JSON
		    return response()->json(['success' => true, 'sales' => $sales]);
		}

		// In SalesController
	public function getSaleDetails($id)
	{
		$sale = Sale::findOrFail($id);
	    // Create a view to format the details and return it as HTML
	    $html = view('sale_details', compact('sale'))->render();
	    return response()->json(['success' => true, 'html' => $html]);
	}

	public function deleteSale($id) {
	    $sale = Sale::findOrFail($id);
	    $inventoryItems = explode(',', $sale->inventory_items);
	    
	    foreach($inventoryItems as $item) {
	        list($lotNumber, $quantity) = explode(':', $item);
	        // Update inventory
	        $inventory = Inventory::where('lot', $lotNumber)->first();
	        if($inventory) {
	            $inventory->increment('qty_av', $quantity);
	            $inventory->decrement('qty_sold', $quantity);
	            $inventory->save();
	        }
	    }
	    
	    // Delete sale
	    $sale->delete();
	    
	    return response()->json(['success' => true]);
	}




}
