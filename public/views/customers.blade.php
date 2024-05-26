@extends('layouts.master_layout')

@section('content')
<div class="page-wrapper">
  <!-- Page header -->
  @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

  <div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
            Dashboard
          </div>
          <h2 class="page-title">
            Customers
          </h2>
        </div>
        <!-- Button to trigger modal -->
        <div class="col-auto ms-auto d-print-none">
          <div class="btn-list">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
              Add Customer
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Page body -->
  <div class="page-body">
    <div class="container-xl">
      <!-- Customers Table -->
      <div class="card">
        <div class="table-responsive">
          <table class="table table-vcenter card-table">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Address</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($customers as $customer)
              <tr>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->phone_number }}</td>
                <td>{{ $customer->address }}</td>
                <td>
                  <!-- Edit Button -->
                  <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editCustomerModal-{{ $customer->id }}">Edit</button>

                  <!-- Delete Button -->
                  <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <footer class="footer footer-transparent d-print-none">
    <!-- Footer content -->
  </footer>
</div>

<!-- Add Customer Modal -->
<div class="modal modal-blur fade" id="addCustomerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form name="customerForm" action="{{ route('customers.store') }}" method="POST" onsubmit="return submitForm(event)">
          @csrf
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" name="name" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" class="form-control" name="address" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Contact</label>
            <input type="text" class="form-control" name="phone_number" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary ms-auto">Add Customer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@foreach ($customers as $customer)
<!-- Edit Customer Modal -->
<div class="modal modal-blur fade" id="editCustomerModal-{{ $customer->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Customer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('customers.update', $customer->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" name="name" value="{{ $customer->name }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="{{ $customer->email }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" class="form-control" name="address" value="{{ $customer->address }}" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Contact</label>
            <input type="text" class="form-control" name="phone_number" value="{{ $customer->phone_number }}" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary ms-auto">Update Customer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach
@endsection
@section('script')
<script type="text/javascript">
 function submitForm(event) {
  event.preventDefault(); // This will prevent the form from submitting normally
  var formData = new FormData(document.forms['customerForm']);

  fetch('{{ route('customers.store') }}', {
    method: 'POST',
    body: formData,
    headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
      'Accept': 'application/json', // Expect a JSON response
    }
  })
  .then(response => response.json()) // Convert the response to JSON
  .then(data => {
    console.log('Success:', data);
    if (data.success) {
               location.reload();
    }
  })
  .catch((error) => {
            console.error("Error: " + error);
  });
}


</script>
@endsection
