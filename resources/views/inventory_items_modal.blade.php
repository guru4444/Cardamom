<div class="modal-dialog" role="document">
    <div class="modal-content">
        <!-- Modal Header -->
        <!-- Modal Body -->
        <div class="modal-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Quantity</th>
                        <th>Cost/kg</th>
                        <th>Available</th>
                        <th>sold</th>
                        <th>Grade</th>
                        <th>Sell</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inventoryItems as $item)
                        <tr>                            
                            <td>{{ $item->qty }}</td>
                            <td>Rs.{{ $item->costperkg }}</td>
                            <td>{{ $item->qty_av }}</td>
                            <td>{{ $item->qty_sold }}</td>
                            <td>{{ $item->grade }}</td>
                            <td>
                            <input type="number" class="form-control sell-quantity" data-id="{{ $item['id'] }}" data-lot="{{ $item['lot'] }}" data-available="{{ $item['qty_av'] }}"  max="{{ $item['qty_av'] }}" min="1">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Modal Footer -->
        <div class="modal-footer">
                 <div>
                    <h5>Total Sales: <span id="totalSalesValue">0</span></h5>
                  </div>
                <button type="button" class="btn btn-primary" id="updateInventoryButton">Submit</button>
          </div>
    </div>
</div>
