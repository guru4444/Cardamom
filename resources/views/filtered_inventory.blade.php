<!-- filtered_inventory.blade.php -->
@php
    $totalKgAvailable = 0;
    $totalKgSold = 0;
    $totalCostPerKg = 0;
    $count = count($Inventories);
    
    foreach ($Inventories as $inventory) {
        $totalKgAvailable += $inventory['qty_av'];
    }

    foreach ($Inventories as $inventory) {
        $totalKgSold += $inventory['qty_sold'];
    }

    foreach ($Inventories as $inventory) {
        $totalCostPerKg += $inventory['costperkg'];
    }

    $averageCostPerKg = $count > 0 ? $totalCostPerKg / $count : 0;

    $sumtotalCost = 0;
    $count = count($Inventories);
    
    foreach ($Inventories as $inventory) {
        $sumtotalCost += $inventory['totalcost'];
    }

    $averagetotalCost = $count > 0 ? $sumtotalCost / $count : 0;

@endphp
<table class="table">
    <thead>
        <tr>
            <th><button class="table-sort" data-sort="sort-">Lot</button></th>
            <th><button class="table-sort" data-sort="sort-grade">Grade</button></th>
            <th><button class="table-sort" data-sort="sort-quantity">Quantity</button></th>
            <th><button class="table-sort" data-sort="sort-quantity-available">Qa</button></th>
            <th><button class="table-sort" data-sort="sort-quantity-sold">Qs</button></th>
            <th><button class="table-sort" data-sort="sort-costperkg">Cost/kg</button></th>
            <th><button class="table-sort" data-sort="sort-totalcost">Total Cost</button></th>
            <th><button class="table-sort" data-sort="sort-date">Date</button></th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody class="table-tbody">
        @foreach($Inventories as $inventory)
        <tr>
            <td class="sort-lot">{{$inventory['lot']}}</td>
            <td class="sort-grade">{{$inventory['grade']}}</td>
            <td class="sort-quantity">{{$inventory['qty']}}</td>
            <td class="sort-quantity-available">{{$inventory['qty_av']}}</td>
            <td class="sort-quantity-sold">{{$inventory['qty_sold']}}</td>
            <td class="sort-quantity">{{$inventory['costperkg']}}</td>
            <td class="sort-quantity">{{$inventory['totalcost']}}</td>
            <td class="sort-date">{{ \Carbon\Carbon::parse($inventory['created_at'])->format('d M Y H:i:s') }}</td>
            <td>
                <button class="btn btn-primary sellBtn" data-id="{{$inventory['id']}}" data-qty="{{$inventory['qty']}}" data-toggle="modal" data-target="#sellModal">Sell</button>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>
<div class="alert alert-primary" role="alert" style="font-size: 15px; text-align: center;">
    <strong>Average Cost Per Kg: {{ number_format($averageCostPerKg, 2) }} </strong>
</div>
<div class="alert alert-success" role="alert" style="font-size: 15px; text-align: center;">
    <strong>Average Total cost: {{ number_format($averagetotalCost, 2) }} </strong>
</div>

<div class="alert alert-info" role="alert" style="font-size: 15px; text-align: center;">
    <strong>Total Kg Available: {{ $totalKgAvailable }} </strong>
</div>

<div class="alert alert-danger" role="alert" style="font-size: 15px; text-align: center;">
    <strong>Total Kg Sold: {{ $totalKgSold }} </strong>
</div>

