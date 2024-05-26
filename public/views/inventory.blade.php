@extends('layouts.master_layout')

@section('head')
@endsection

@section('content')
@php
    $totalKgAvailable = 0;
    $totalKgSold = 0;
    $totalCostPerKg = 0;
    $count = count($InventoryItems);
    
    foreach ($InventoryItems as $inventory) {
        $totalKgAvailable += $inventory['qty_av'];
    }

    foreach ($InventoryItems as $inventory) {
        $totalKgSold += $inventory['qty_sold'];
    }

    foreach ($InventoryItems as $inventory) {
        $totalCostPerKg += $inventory['costperkg'];
    }

    $averageCostPerKg = $count > 0 ? $totalCostPerKg / $count : 0;

    $sumtotalCost = 0;
    $count = count($InventoryItems);
    
    foreach ($InventoryItems as $inventory) {
        $sumtotalCost += $inventory['totalcost'];
    }

    $averagetotalCost = $count > 0 ? $sumtotalCost / $count : 0;

@endphp

<div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                  Dash
                </div>
                <h2 class="page-title">
                  inventory
                </h2>
              </div>
              
            </div>
          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
         <div class="container-xl">
            <div class="card">
              <div class="card-body">
                <a href="#" class="btn btn-primary d-none d-sm-inline-block" style="margin-bottom: 10px;" data-bs-toggle="modal" data-bs-target="#modal-inventory">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                    New inventory
                  </a>
                  <form id="date-filter-form">
                    @csrf
                    <div class="row">
                    <div class="col-lg-3">
                        <label class="form-label">From Date</label>
                        <input type="date" class="form-control" name="from_date">
                    </div>

                    <div class="col-lg-3">
                        <label class="form-label">To Date</label>
                        <input type="date" class="form-control" name="to_date">
                    </div>


                  <div class="col-lg-4">
                      <label class="form-label">Grade</label>
                      <select class="form-select" name="grade">
                          <option value="">Select Grade</option>
                          <option value="8mm">8mm</option>
                          <option value="7mm">7mm</option>
                          <option value="6mm">6mm</option>
                          <!-- Add more grade options as needed -->
                      </select>
                  </div>
                   <div class="col-lg-2" style="margin-top: 25px;">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                  </div>

                </form>
                <br>
                <div id="filtered-data-container">
                        <!-- Display filtered data here -->
                    </div>
                
                <div id="table-default" class="table-responsive">
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
                        <!-- <th>Action</th> -->
                    </tr>
                </thead>
                <tbody class="table-tbody">
                    @foreach($InventoryItems as $inventory)
                    <tr>
                        <td class="sort-lot">{{$inventory['lot']}}</td>
                        <td class="sort-grade">{{$inventory['grade']}}</td>
                        <td class="sort-quantity">{{$inventory['qty']}}</td>
                        <td class="sort-quantity-available">{{$inventory['qty_av']}}</td>
                        <td class="sort-quantity-sold">{{$inventory['qty_sold']}}</td>
                        <td class="sort-quantity">{{$inventory['costperkg']}}</td>
                        <td class="sort-quantity">{{$inventory['totalcost']}}</td>
                        <td class="sort-date">{{ \Carbon\Carbon::parse($inventory['created_at'])->format('d M Y H:i:s') }}</td>
                       <!--  <td>
                            <button class="btn btn-primary sellBtn" data-id="{{$inventory['id']}}" data-qty="{{$inventory['qty']}}" data-toggle="modal" data-target="#sellModal">Sell</button>
                        </td> -->

                    </tr>
                    @endforeach
                </tbody>
            </table>
                </div>
              

              <div id="all_info">
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
              </div>

              </div>
            </div>
          </div>
        </div>
        <footer class="footer footer-transparent d-print-none">
        
        </footer>
      </div>

      <div class="modal modal-blur fade" id="modal-inventory" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">New inventory</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
         <label for="numOfRows">Number of Rows:</label>
    <input type="number" id="numOfRows" value="1" min="1">
         <button class="btn btn-success add-row">Add</button>

        <div class="container" style="margin-top: 30px;">

          <div class="row">
            <div class="col-lg-2">
              <div class="mb-3">
                <div class="form-label">Lot No.</div>
                <input type="text" class="form-control" name="lot_no[]" placeholder="Lot no.">
              </div>
            </div>
            <div class="col-lg-2">
              <div class="mb-3">
                <div class="form-label">Grade</div>
                <select class="form-select" name="grade[]">
                  <option value="8mm" selected>8mm</option>
                  <option value="7mm">7mm</option>
                  <option value="6mm">6mm</option>
                </select>
              </div>
            </div>
            <div class="col-lg-2">
              <div class="mb-3">
                <div class="form-label">Quantity</div>
                <input type="text" class="form-control" name="quantity[]" placeholder="quantity">
              </div>
            </div>
             <div class="col-lg-2">
              <div class="mb-3">
                <div class="form-label">Cost per kg</div>
                <input type="text" class="form-control" name="cost1kg[]" placeholder="">
              </div>
            </div>
            <div class="col-lg-2">
              <div class="mb-3">
                <div class="form-label">Total Cost</div>
                <input type="text" class="form-control" name="totalcost[]" placeholder="Total Cost">
              </div>
            </div>

            <div class="col-lg-2">
              <div class="mb-3">
                <button class="btn  btn-danger remove-row" style="margin-top: 28px;">
                  <!-- "X" sign icon -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon"  viewBox="0 0 16 16" fill="currentColor">
                    <path d="M3.293 3.293a1 1 0 0 1 1.414 0L8 6.586l3.293-3.293a1 1 0 1 1 1.414 1.414L9.414 8l3.293 3.293a1 1 0 0 1-1.414 1.414L8 9.414l-3.293 3.293a1 1 0 0 1-1.414-1.414L6.586 8 3.293 4.707a1 1 0 0 1 0-1.414z"></path>
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
          Cancel
        </a>
        <a href="#" id="createInventoryButton" class="btn btn-square btn-primary ms-auto" data-bs-dismiss="modal">
  <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="16" height="16" viewBox="0 0 16 16" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h16v16H0z" fill="none"/><path d="M8 4v8m-4-4h8"></path></svg>
  Create new inventory
</a>

      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="sellModal" tabindex="-1" aria-labelledby="sellModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="sellModalLabel">Sell Quantity</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="sellForm">
          <input type="hidden" id="inventoryId" name="inventoryId">
          <div class="form-group">
            <label for="quantity">Quantity to Sell</label>
            <input type="number" class="form-control" id="quantity" required>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')


<script type="text/javascript">
 
$(document).on('click', '.sellBtn', function() {
    const inventoryId = $(this).data('id');
    
    // Bind the inventoryId to the modal
    $('#sellModal').data('inventory-id', inventoryId);
});

$('#sellForm').on('submit', function(event) {
    event.preventDefault();

    const inventoryId = $('#sellModal').data('inventory-id');
    const quantityToSell = $('#quantity').val();

    $.ajax({
        url: '/sell-item',
        method: 'POST',
        data: {
            inventoryId: inventoryId,
            quantity: quantityToSell
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                $('#sellModal').modal('hide');
                alert('Quantity updated successfully!');
                location.reload();
            } else {
                alert(response.message);
                location.reload();
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Server error. Please try again.');
            console.error("Error status: ", textStatus);
        console.error("Error thrown: ", errorThrown);
        console.error("Server response: ", jqXHR.responseText);
        }
    });
});

</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="{{ asset('theme/code/demo/dist/libs/list.js/dist/list.min.js?1684106062')}}" defer></script>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
      const list = new List('table-default', {
        sortClass: 'table-sort',
        listClass: 'table-tbody',
        valueNames: [ 'sort-name', 'sort-type', 'sort-city', 'sort-score',
            { attr: 'data-date', name: 'sort-date' },
            { attr: 'data-progress', name: 'sort-progress' },
            'sort-quantity'
        ]
      });
      })
    </script>


<!-- Inside your Blade template -->
<script>
    $(document).ready(function () {
        // Handle form submission using AJAX
        $('#date-filter-form').submit(function (event) {
            event.preventDefault(); // Prevent the form from submitting traditionally
            $("#table-default").hide();
            $("#all_info").hide();
            const formData = $(this).serialize(); // Serialize form data

            // Make an AJAX request to filter inventory data
            $.ajax({
                url: '{{ route('filterByDateRange') }}', 
                type: 'POST',
                data: formData,
                beforeSend: function () {
                    // Hide the table and show a loading spinner
                    $('#filtered-data-container').html('<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');
                },
                success: function (data) {
                    // Hide the loading spinner and show the filtered data
                    $('#filtered-data-container').html(data);
                },
                error: function (xhr, status, error) {
                     console.error("Status: " + status);
            console.error("Error: " + error);
            console.error(xhr.responseText); 
                },
                complete: function () {
                    // Show the table again after the AJAX request is complete
                }
            });
        });
    });
</script>

<!-- JavaScript code (place this within a <script> tag) -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Function to update total cost for a specific row
        function updateTotalCostForRow(row) {
            const costPerKgInput = row.querySelector('input[name="cost1kg[]"]');
            const quantityInput = row.querySelector('input[name="quantity[]"]');
            const totalCostInput = row.querySelector('input[name="totalcost[]"]');

            costPerKgInput.addEventListener('input', function () {
                calculateAndUpdateTotalCost(row);
            });
            quantityInput.addEventListener('input', function () {
                calculateAndUpdateTotalCost(row);
            });

            function calculateAndUpdateTotalCost(row) {
                const costPerKg = parseFloat(costPerKgInput.value) || 0;
                const quantity = parseFloat(quantityInput.value) || 0;
                const totalCost = costPerKg * quantity;
                totalCostInput.value = totalCost.toFixed(2); // Round to 2 decimal places
            }

            // Initialize total cost when the page loads and for dynamically added rows
            calculateAndUpdateTotalCost(row);
        }

        // Function to add a new row within the modal
        function addRow() {
            const modalContent = document.querySelector('.modal-body .container');
            const row = modalContent.querySelector('.row');
            // Get the number of rows to add from the textbox
            const numOfRows = parseInt(document.getElementById('numOfRows').value) || 1;

        for (let i = 0; i < numOfRows; i++) {

            const newRow = row.cloneNode(true);

            // Clear input values in the new row
            const inputs = newRow.querySelectorAll('input');
            inputs.forEach(input => {
                input.value = '';
            });

            // Append the new row to the modal content
            modalContent.appendChild(newRow);

            // Add event listeners and update total cost for the new row
            updateTotalCostForRow(newRow);

            // Add event listener to the new row's "Remove" button
            const newRemoveBtn = newRow.querySelector('.remove-row');
            newRemoveBtn.addEventListener('click', function () {
                modalContent.removeChild(newRow);
            });
           }
      }

        // Add event listener to the initial "Add Row" button within the modal
        const addBtn = document.querySelector('.modal-body .add-row');
        addBtn.addEventListener('click', addRow);

        // Initialize total cost for existing rows
        const rows = document.querySelectorAll('.modal-body .row');
        rows.forEach(row => {
            updateTotalCostForRow(row);
        });

        // Make the totalcost input fields readonly
        const totalCostInputs = document.querySelectorAll('input[name="totalcost[]"]');
        totalCostInputs.forEach(input => {
            input.readOnly = true;
        });
    });
</script>
 

    <script type="text/javascript">

// Function to remove a row within the modal
function removeRow(event) {
  const rowToRemove = event.target.closest('.row');
  const modalContent = document.querySelector('.modal-body .container');
  const rows = modalContent.querySelectorAll('.row');

  // Check if there is more than one row and the row is not the first row before removing
  if (rows.length > 1 && rowToRemove !== rows[0]) {
    modalContent.removeChild(rowToRemove);
  }
}

// Add event listener to the initial "Add Row" button within the modal
const addBtn = document.querySelector('.modal-body .add-row');
addBtn.addEventListener('click', addRow);

// Add event listener to the "Remove" buttons within the modal
const removeButtons = document.querySelectorAll('.modal-body .remove-row');
removeButtons.forEach(btn => {
  btn.addEventListener('click', removeRow);
});

    </script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const costPerKgInput = document.querySelector('input[name="cost1kg[]"]');
        const quantityInput = document.querySelector('input[name="quantity[]"]');

        costPerKgInput.addEventListener('input', restrictToPositiveFloat);
        quantityInput.addEventListener('input', restrictToPositiveFloat);

        function restrictToPositiveFloat(event) {
            let inputValue = event.target.value;
            inputValue = inputValue.replace(/[^0-9.]/g, '');

            const decimalCount = (inputValue.match(/\./g) || []).length;
            if (decimalCount > 1) {
                inputValue = inputValue.slice(0, -1);
            }

            event.target.value = inputValue;
        }
    });
</script>




    <script type="text/javascript">
      function createInventory() {
    const rows = document.querySelectorAll('.modal-body .row');
    const inventoryData = [];

    rows.forEach(row => {
         const lotNoInput = row.querySelector('input[name="lot_no[]"]');
        const gradeSelect = row.querySelector('select[name="grade[]"]');
        const quantityInput = row.querySelector('input[name="quantity[]"]');
        const costperkgInput = row.querySelector('input[name="cost1kg[]"]');
        const totalcostInput = row.querySelector('input[name="totalcost[]"]');

        // Check if these inputs exist within the current row
        if (lotNoInput && gradeSelect && quantityInput) {
            const lotNo = lotNoInput.value;
            const grade = gradeSelect.value;
            const quantity = quantityInput.value;
            const costperkg = costperkgInput.value;
            const totalcost = totalcostInput.value;

            inventoryData.push({ lot_no: lotNo, grade: grade, quantity: quantity, costperkg: costperkg, totalcost: totalcost });
        }
    });

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// Include the CSRF token in the request headers
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });

    // Send the data to the server using AJAX
    $.ajax({
        url: '/save-inventory',
        method: 'POST',
        data: { inventoryData: inventoryData },
        success: function (response) {
            // Handle the success response here
            console.log(response.message);
                        location.reload();

        },
        error: function (xhr, status, error) {
            // Handle any errors here
            console.error("Status: " + status);
            console.error("Error: " + error);
            console.error(xhr.responseText); // Log the response text for more details
          }
    });
}

    document.addEventListener("DOMContentLoaded", function() {
    const createInventoryButton = document.getElementById('createInventoryButton');
    createInventoryButton.addEventListener('click', createInventory);
});

    </script>
@endsection
