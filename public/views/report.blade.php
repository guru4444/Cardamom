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
                  Reports
                </h2>
              </div>              
            </div>
          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
              <div class="row">
                  <div class="col">
                    <label>Start Date</label>
                    <input type="date" id="startDate" class="form-control">
                  </div>
                  <div class="col">
                    <label>End Date</label>
                    <input type="date" id="endDate" class="form-control">
                  </div>
                  <div class="col">
                    <button id="filterSalesBtn" class="btn btn-primary mt-4">Show Report</button>
                  </div>
                </div>
                
            <div class="row row-deck row-cards mt-4">          
            <div class="col-sm-6 col-lg-3">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="subheader">Total Sales</div>  
                    </div>
                    <div class="h1 mb-3"><span id="totalSales">0</span></div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-3">              
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="subheader">Total Cost</div>  
                    </div>
                    <div class="h1 mb-3"><span id="totalCost">0</span></div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-lg-3">              
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex align-items-center">
                      <div class="subheader">P/L</div>  
                    </div>
                    <div class="h1 mb-3"><span id="profitLoss">0</span></div>
                  </div>
                </div>
              </div>     
          </div>
          </div>         
        </div>
        <footer class="footer footer-transparent d-print-none">
        
        </footer>
      </div>
@endsection
@section('script')
<script type="text/javascript">
var totalSales = 0;
var totalCost = 0;

$(document).ready(function() {
  // Set default dates to current year
  var currentYear = new Date().getFullYear();
  $('#startDate').val(currentYear + '-01-01'); // First day of the current year
  $('#endDate').val(new Date().toISOString().split('T')[0]); // Today's date

  // Trigger the calculation for the current year on page load
  getTotalSales();

  $('#filterSalesBtn').click(function() {
    getTotalSales();
  });
});

// Function to get total sales
function getTotalSales() {
  var startDate = $('#startDate').val();
  var endDate = $('#endDate').val();

  $.ajax({
    url: '/total-sales',
    method: 'GET',
    data: { startDate: startDate, endDate: endDate },
    success: function(response) {
      totalSales = response.totalSales;
      $('#totalSales').text(totalSales);
      getTotalCost(); // Call getTotalCost after totalSales is set
    },
    error: function (xhr, status, error) {
      // Handle errors
    }
  });
}

// Function to Get Total Cost
function getTotalCost() {
  var startDate = $('#startDate').val();
  var endDate = $('#endDate').val();

  $.ajax({
    url: '/total-cost',
    method: 'GET',
    data: { startDate: startDate, endDate: endDate },
    success: function(response) {
      totalCost = response.totalCost;
      $('#totalCost').text(totalCost);
      calculateProfitLoss(); // Calculate P/L after totalCost is set
    },
    error: function(xhr, status, error) {
      // Handle errors
    }
  });
}

// Function to Calculate Profit/Loss
function calculateProfitLoss() {
  var profitLoss = totalSales - totalCost;
  $('#profitLoss').text(profitLoss.toFixed(2)); // Assuming profit/loss is a decimal value
  // Change color based on profit or loss
  if (profitLoss >= 0) {
    $('#profitLoss').css('color', 'green');
  } else {
    $('#profitLoss').css('color', 'red');
  }
}
</script>

@endsection
