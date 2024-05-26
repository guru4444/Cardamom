@extends('layouts.master_layout')

@section('content')
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
                  Sales
                </h2>
              </div>
              
            </div>
          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
              <div class="card">
              <!-- <p style="text-align: center;font-size: 20px;margin-top: 10px;">Create Sale</p> -->
                <div class="card-body">
                        <div class="row">

                           <div class="col-lg-3">
                            <label class="form-label">Customer</label>
                            <select id="customerDropdown" class="form-select mb-3">
                                <option value="">Select Customer</option>
                                @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                          </div>  

                           <div class="col-lg-2">
                            <label class="form-label">Grade</label>
                            <select id="gradeDropdown" class="form-select mb-3">
                                <option value="">Select Grade</option>
                                <option value="8mm">8mm</option>
                                <option value="7mm">7mm</option>
                                <option value="6mm">6mm</option>
                                <!-- Add more grade options as needed -->
                            </select>
                          </div>


                          <div class="col-lg-2">
                            <label class="form-label">Selling Price</label>
                            <input type="number" class="form-control" id="sellingPrice" required>
                          </div>

                          <div class="col-lg-2">
                              <label class="form-label">Sale Date</label>
                              <input type="date" class="form-control" id="saleDate" required>
                            </div>

                          <div class="col-lg-2">
                              <label class="form-label">Choose</label>
                              <button id="chooseInventoryBtn" class="btn btn-primary " style="margin-bottom: 10px;" data-bs-toggle="modal" data-bs-target="#modal-choose-inventory">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-minus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                  <path d="M5 12l14 0"></path>
                                </svg>
                                Create Sale
                              </button>
                            </div>
                                       
<!-- 
                          <div class="col-lg-4">
                            <label class="form-label">Sale Quantity</label>
                            <input type="number" class="form-control" id="saleQuantity" required>
                          </div>
 -->

                                                
                        </div>
                      </div>

              </div>
            </div>    
            <br>
            <div class="container-xl">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                     <div class="col-lg-4">
                        <label class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="startDate">
                      </div>
                      <div class="col-lg-4">
                        <label class="form-label">End Date</label>
                        <input type="date" class="form-control" id="endDate">
                      </div>
                      <div class="col-lg-4">
                        <label class="form-label">Filter</label>                        
                        <button id="filterSalesBtn" class="btn btn-success">Filter Sales</button>
                      </div>
                  </div>

                  <!-- Sales table -->
                      <div class="table-responsive">
                          <table class="table table-striped table-hover mt-4" id="salesTable">
                              <thead>
                                  <tr>
                                      <th>Date</th>
                                      <th>Customer</th>
                                      <th>Grade</th>
                                      <th>Quantity</th>
                                      <th>Selling Price</th>
                                      <th>Action</th>
                                      <!-- Add more columns as needed -->
                                  </tr>
                              </thead>
                              <tbody>
                                  
                              </tbody>
                          </table>
                          <!-- Pagination links container -->
                             <div class="pagination">
                                   {{ $sales->links() }}
                             </div>


                      </div>



                </div>
              </div>
            </div>

        </div>
        <footer class="footer footer-transparent d-print-none">
        
        </footer>
      </div>

      <!-- Inventory Modal -->
<div class="modal fade" id="inventoryModal" tabindex="-1" role="dialog">
    <!-- Modal content goes here -->
</div>
@endsection

@section('script')
<script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function () {

    var today = new Date().toISOString().split('T')[0];
    document.getElementById('startDate').value = today;
    document.getElementById('endDate').value = today;
    document.getElementById('saleDate').value = today;

    document.getElementById('chooseInventoryBtn').addEventListener('click', function () {
      var customerId = document.getElementById('customerDropdown').value;
      var selectedGrade = document.getElementById('gradeDropdown').value;
      var sellingPrice = document.getElementById('sellingPrice').value;
      var saleDate = document.getElementById('saleDate').value;

      // Validation
      if (!customerId) {
          alert('Please select customer.');
          return;
      }
      if (!selectedGrade) {
          alert('Please choose grade.');
          return;
      }
      if (!sellingPrice) {
          alert('Please enter selling price.');
          return;
      }
      if (!saleDate) {
          alert('Please enter selling date.');
          return;
      }

      // AJAX Request to fetch inventory items
      $.ajax({
          url: '/get-inventory-items',
          method: 'POST',
          data: { grade: selectedGrade },
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(response) {
              // Populate the modal with the response and show it
              $('#inventoryModal').html(response).modal('show');
              function updateTotalSalesValue() {
                          let total = 0;
                          // Iterate over all the sales value inputs and sum them
                          $('.sell-quantity').each(function() {
                            let value = parseFloat($(this).val()) || 0;
                            total += value;
                          });
                          // Update the total sales value container
                          $('#totalSalesValue').text(total.toFixed(2));
                        }

                        // Call updateTotalSalesValue whenever a sales value input changes
                        $(document).on('input', '.sell-quantity', function() {
                          updateTotalSalesValue();
                        });

                        // Initialize the total sales value when the modal is shown
                        $('#inventoryModal').on('shown.bs.modal', function () {
                          updateTotalSalesValue();
                        });
          },
          error: function(jqXHR, textStatus, errorThrown) {
              alert('Server error. Please try again.');
              console.error("Error status: ", textStatus);
              console.error("Error thrown: ", errorThrown);
              console.error("Server response: ", jqXHR.responseText);
          }
      });
    });
  });

$(document).on('click', '#updateInventoryButton', function() {
      validationPassed = true;
      var allRequests = [];
      $('.sell-quantity').each(function() {
          var inventoryId = $(this).data('id');
          var quantityToSell = $(this).val();
          var availableQuantity = parseFloat($(this).data('available'));

          if (quantityToSell > availableQuantity) {
            alert('Sell quantity exceeds available quantity.');
                validationPassed = false;
                return false; // break the loop
            }

          if (quantityToSell > 0) {
              var request = $.ajax({
                  url: '/sell-item',
                  method: 'POST',
                  data: {
                    inventoryId: inventoryId,
                    quantity: quantityToSell
                  },
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
              });
              allRequests.push(request);
          }
      });

      $.when.apply($, allRequests).then(function() {

          if (!validationPassed) {
                  return; // Stop the function if validation fails
              }


          var customerId = document.getElementById('customerDropdown').value;
          var saleQuantity = document.getElementById('totalSalesValue').textContent;
          var sellingPrice = document.getElementById('sellingPrice').value;
          var selectedGrade = document.getElementById('gradeDropdown').value;          
          var saleDate = document.getElementById('saleDate').value;          


        

          let inventoryItems = [];
              $('.sell-quantity').each(function() {
                  let inventory_lot = $(this).data('lot');
                  let quantityToSell = $(this).val();
                  if (quantityToSell > 0) {
                      inventoryItems.push(`${inventory_lot}:${quantityToSell}`);
                  }
              });

          let inventoryItemsString = inventoryItems.join(',');

          // AJAX Request to record the sale
          $.ajax({
              url: '/record-sale',
              method: 'POST',
              data: {
                  customer_id: customerId,
                  sale_qty: saleQuantity,
                  sale_price: sellingPrice,
                  sale_grade: selectedGrade,
                  sale_date: saleDate,
                  inventory_items: inventoryItemsString                  
              },
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              success: function(response) {
                  if (response.success) {
                      alert('Sale recorded successfully!');
                      location.reload();                      
                  } else {
                      alert(response.message);
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
  });
</script>


<script type="text/javascript">

document.getElementById('recordSaleBtn').addEventListener('click', function () {
    
});

</script>

<script type="text/javascript">
  document.getElementById('chooseInventoryBtn').addEventListener('click', function () {
      
  });
</script>


<script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function () {

    

    loadSalesData();

     $('#filterSalesBtn').click(function() {
        loadSalesData(); // Load sales data on filter button click
    });

    function loadSalesData() {
    var startDate = $('#startDate').val();
    var endDate = $('#endDate').val();

     // Show loading text
    var tableBody = $('#salesTable tbody');
    tableBody.html('<tr><td colspan="6" style="text-align: center;">Loading...</td></tr>');

    $.ajax({
            url: '/get-sales', // Adjust this URL to your route
            method: 'GET',
            data: { startDate: startDate, endDate: endDate },
            success: function(response) {
              console.log(response);
                if(response.success) {
                    var salesData = response.sales.data; // Adjust according to your response structure
                    var tableBody = $('#salesTable tbody');
                    tableBody.empty(); // Clear existing data

                    salesData.forEach(function(sale) {
                        tableBody.append(
                            '<tr>' +
                            '<td>' + sale.sale_date + '</td>' +
                            '<td>' + sale.customer_id  + '</td>' +
                            '<td>' + sale.sale_grade + '</td>' +
                            '<td>' + sale.sale_qty  + '</td>' +
                            '<td>' + sale.sale_price  + '</td>' +
                            '<td>' +'<button class="btn btn-info toggle-details-btn" data-sale-id="' + sale.id + '">More</button>' +' '+'<button class="btn btn-danger delete-sale-btn" data-sale-id="' + sale.id + '">Delete</button>' +'</td>' +
                            '</tr>'+
                            '<tr class="sale-details-row" id="details-' + sale.id + '" style="display: none;">' +
                            '<td colspan="6">Loading details...</td>' +
                            '</tr>'
                             
                         );
                    });
                    
                    // Update pagination links
                    $('.pagination').html(response.sales.links); 

                      $(document).on('click', '.toggle-details-btn', function() {

                            var saleId = $(this).data('sale-id');
                            var detailsRow = $('#details-' + saleId);
                            // Toggle the visibility of the details row
                            detailsRow.toggle();

                                // AJAX call to get more details if the row is visible
                            if (detailsRow.is(':visible')) {                                
                                $.ajax({
                                    url: '/get-sale-details/' + saleId,
                                    method: 'GET',
                                    success: function(response) {
                                        if(response.success) {
                                            // Populate the details row with the response data
                                            detailsRow.find('td').html(response.html);
                                        } else {
                                            alert(response.message);
                                        }
                                    },
                                    error: function() {
                                        alert('Could not retrieve details.');
                                    }
                                });
                              }
                        });

                      $(document).on('click', '.delete-sale-btn', function() {
                            var saleId = $(this).data('sale-id');
                            // Confirm deletion
                            if(confirm('Are you sure you want to delete this sale?')) {
                                // AJAX call to delete the sale
                                $.ajax({
                                    url: '/delete-sale/' + saleId,
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function(response) {
                                        if(response.success) {
                                            alert('Sale deleted successfully.');
                                            // Reload or update the table
                                        } else {
                                            alert(response.message);
                                        }
                                    },
                                    error: function() {
                                        alert('Error deleting sale.');
                                    }
                                });
                            }
                        });


                } else {
                    alert(response.message);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Server error. Please try again.');
                console.error("Error status: ", textStatus);
                console.error("Error thrown: ", errorThrown);
                console.error("Server response: ", jqXHR.responseText);
                }
            });
            }

    });




</script>


@endsection
