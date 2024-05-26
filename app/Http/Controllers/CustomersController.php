<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomersController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customers', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
		{
		    $validatedData = $request->validate([
		        'name' => 'required|max:255',
		        'email' => 'required|email|unique:customers',
		        'address' => 'required',
		        'phone_number' => 'required'
		    ]);

		    Customer::create($validatedData);
		    if ($request->ajax() || $request->wantsJson()) {
			        return response()->json(['success' => 'Customer added successfully.']);
			    }

   			 return redirect('/customers')->with('success', 'Customer added successfully.');
		}


    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:customers,email,'.$customer->id,
            'address' => 'required',
            'phone_number' => 'required'
        ]);

        $customer->update($validatedData);

        return redirect('/customers')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect('/customers')->with('success', 'Customer deleted successfully.');
    }
}
