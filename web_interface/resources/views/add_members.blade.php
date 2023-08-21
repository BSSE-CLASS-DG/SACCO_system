
@extends('layouts.app', ['activePage' => 'table', 'title' => 'Light Bootstrap Dashboard Laravel by Creative Tim & UPDIVISION', 'navName' => 'Table List', 'activeButton' => 'laravel'])

@section('content')
    
    <!-- Your view content here -->
    
    <div class="content">
      <div class="container">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
          <div class="card card-register card-plain text-center">
              <div class="card-body ">
                  <div class="row">
                      <div class="col-md-5 ml-auto">
                          
                      </div>
<div class="col-md-4 mr-auto">
  <form method="POST" action="/admin/addmembers">
      @csrf
      <div class="card card-plain">
          <div class="content">
              <div class="form-group">
                <label for="member_number">Enter Member Number:</label>
                <input type="text" id="member_number" name="member_number" class="form-control" placeholder="M001" required>
              </div>

              <div class="form-group">   {{-- is-invalid make border red --}}
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
              </div>
              <div class="form-group">   {{-- is-invalid make border red --}}
                <label for="username">Username:</label>
                <input type="username" id="username" name="username" class="form-control" required>
              </div>

              <div class="form-group">
                <label for="password">Password:</label>
                  <input type="password" name="password" class="form-control" required >
              </div>
              <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                  <input type="phone_number" name="phone_number" class="form-control" required >
              </div>
             
              

              <div class="footer text-center">
                  <button type="submit" class="btn btn-fill btn-neutral btn-wd">{{ __('Add member') }}</button>
              </div>
          </div>
      </div>
  </form>
</div>
</div>
</div>
</div>
</div>
</div>

@endsection
