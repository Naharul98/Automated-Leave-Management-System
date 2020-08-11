@extends('layouts.app')

@section('content')
@if (session('status'))
   <p class="alert alert-success">{{ session('status') }}</p>
@endif
    <div class="container">
    <div class="jumbotron text-center">
        <h1>Welcome To Holiday Reservation System!</h1>
        <p class="lead pt-3">Simply follow the three step process to request a holiday from your manager.</p>
        <p class="leads">You will be informed of the holiday request outcome via email.</p>
    </div>
  </div>

  <div class="container" style="text-align: center;">
  <div class="row">
    <div class="col-sm-4">
      <h3>Step 1: Login</h3>
      <br>
      <hr class="my-2">
      <p>Please login to the website using your work email address and your designated password given by your manager. Please note you will be prompted to change your password during your initial login for security purposes
    </div>
    <div class="col-sm-4">
      <h3>Step 2: Reserve holiday</h3>
      <br>
      <hr class="my-2">
      <p>After login you will be able to see your current holiday entitlement left and will be able to see previously booked holidays. In addition, you will have the option to request a holiday from your manager. After filling in details, you will be able to request.
    </div>
    <div class="col-sm-4">
      <h3>Step 3: Recieve confirmation</h3>
      <br>
      <hr class="my-2">
      <p>Once you have requested a holiday, your manager will be informed of the request and depending on different constraints of the organization, your manager will either approve/disapprove your request. Either way, you will receive email informing you of the outcome.
    </div>
  </div>
</div>
@endsection
