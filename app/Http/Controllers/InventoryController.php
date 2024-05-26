<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;


class InventoryController extends Controller
{
    public function dash()
    {      
		$Inventories = Inventory::all();       
        $InventoryItems = Inventory::where('qty_av', '>', 0)->get();

        return view('inventory',compact('Inventories','InventoryItems'));
    }

    public function filterByDateRange(Request $request)
		{
		    $fromDate = $request->input('from_date');
		    $toDate = $request->input('to_date');
		    $grade = $request->input('grade');
		    $Inventories = Inventory::whereDate('created_at', '>=', $fromDate)
    ->whereDate('created_at', '<=', $toDate)
    ->when($grade, function ($query, $grade) {
        return $query->where('grade', $grade);
    })
    ->get();
		    return view('filtered_inventory', compact('Inventories'));
		}

    public function saveInventory(Request $request)
		{
    $data = $request->input('inventoryData'); // Access the 'inventoryData' key in the request data

		    foreach ($data as $inventoryData) {
		        Inventory::create([
		            'lot' => $inventoryData['lot_no'],
		            'grade' => $inventoryData['grade'],
		            'qty' => $inventoryData['quantity'],
		            'qty_av' => $inventoryData['quantity'],
		            'costperkg' => $inventoryData['costperkg'],
		            'totalcost' => $inventoryData['totalcost'],
		        ]);
		    }

		    return response()->json(['message' => 'Inventory saved successfully']);
		}

		public function sellItem(Request $request)
{
    $inventoryId = $request->input('inventoryId');
    $quantityToSell = $request->input('quantity');

    // Fetch the item
    $item = Inventory::find($inventoryId);

    if (!$item) {
        return response()->json(['success' => false, 'message' => 'Item not found']);
    }

    // Check if there's enough available quantity to sell
    if ($item->qty_av < $quantityToSell) {
        return response()->json(['success' => false, 'message' => 'Not enough quantity available']);
    }

    // Update the quantities
    $item->qty_av -= $quantityToSell;     // Decrease the available quantity
    $item->qty_sold += $quantityToSell;   // Increase the sold quantity
    $item->save();

    return response()->json(['success' => true, 'newAvailableQty' => $item->qty_av, 'newSoldQty' => $item->qty_sold]);
}


}
