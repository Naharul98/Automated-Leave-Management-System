@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="row">
        <div class="col-sm-12 pt-4 pb-0 mt-0 mb-0">
          @if($requestData->approval ==1)
          <h4 class="text-center mt-0 pt-0">Holiday Request Was Approved</h4>
          @else
          <h4 class="text-center mt-0 pt-0">Holiday Request Was Rejected</h4>
          @endif
<div class="text-center"> {{($requestData->was_requested_by_suggestion ==1) ? '(Request was suggested by system)' : ''}} </div>
        </div>
      </div>
    </div>
  </div>
</div>
          
<div class="container">
  <div class="row">
    <div class="col-lg-7 pt-2">
      <div class="card">
        <div class="card-header pb-2 pt-2">Request Details</div>
        <div class="card-body">
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif
          <div class="row">
            <legend class="col-form-label col-sm-12 pt-0">
              <div class="list-group">
                <div class="d-flex w-100 justify-content-between mb-2">
                  <h4 class="mb-1">{{$requestData->date_from}} To {{$requestData->date_to}}</h4>
                  <small><strong>Requested By - {{$requestData->name}}</strong></small>
                </div>
                <p class="mb-1">Requested at - {{$requestData->requested_at}}</p>
                <p><strong>Request Reason: </strong>{{$requestData->reason}}</p>
              </div>
            </legend>

            <br>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-5 pt-2">
      <div class="card">
      @if($requestData->approval ==1)         
        <div class="alert alert-success pb-2 pt-2"><strong>Constraint Check <span class="badge badge-pill badge-success">&#10003;</span></strong> </div>
        <div class="card-body text-success">
          <div class="row">
            <legend class="col-form-label col-sm-12 pt-0" >
              <h6>No constraints were violated, Holiday was approved.</h6></legend>
            <br>
          </div>
        </div>       
      @else
        <div class="alert alert-danger pb-2 pt-2"><strong>Constraint Check <span class="badge badge-pill badge-danger">&#10005;</span></strong> </div>
        <div class="card-body text-danger">
          <div class="row">
            <legend class="col-form-label col-sm-12 pt-0" >
            <ul>
              @foreach ($violations as $violation)
                <li>{{$violation->reason}}</li>
                @endforeach
          </ul>
          </legend>
            <br>
          </div>
        </div>  
      @endif
      </div>
      </div>
    </div>
  </div>
</div>
<br>
<br>
@endsection
