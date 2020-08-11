@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="row">
        <div class="col-sm-12 pt-4 pb-0 mt-0 mb-0">
          @if($approval ==1)
          <h4 class="text-center mt-0 pt-0">Holiday Request Was Approved</h4>
          @else
          <h4 class="text-center mt-0 pt-0">Holiday Request Was Rejected</h4>
          @endif
          
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
        <div class="card-body mb-4">
          @if (session('status'))
          <div class="alert alert-success" role="alert">
            {{ session('status') }}
          </div>
          @endif
          <div class="row">

            <legend class="col-form-label col-sm-12 pt-0">
              <div class="list-group">
                <div class="d-flex w-100 justify-content-between mb-2">
                  <h4 class="mb-1">{{$request_data->date_from}} To {{$request_data->date_to}}</h4>
                  <small>Requested By - {{$request_data->name}}</small>
                </div>
                <p class="mb-1"><strong>Request Reason:</strong></p>
                <small>{{$request_data->reason}}</small>
              </div>
            </legend>

            <br>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-5 pt-2">
    <div class="card">
      @if($approval ==1)         
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
<br>

@if($approval ==0)
  @if($alternatives["error"] ==null)
<div class="container">
  <div class="row">
    <div class="col-lg-12 pt-2">

        <div class="card-header pb-2 pt-2"><div class="text-center"><h3>Nearest Available Alternatives</h3></div>

          <div class="row">
        <table class="table">
        <thead class="thead">
            <tr>
                <th><div class="text-center">From</div></th>
                <th><div class="text-center">To</div></th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            
              @if($alternatives["lowerSuggestion"] !=null)
              <tr>
                <td><div class="text-center">{{$alternatives["lowerSuggestion"][0]}}</div></td>
                <td><div class="text-center">{{$alternatives["lowerSuggestion"][1]}}</div></td>
                <td>
                  <div class="text-center">
                    <form action="/user_area/request_holiday_from_alternative/" method="post">
                      @csrf
                       <input type="hidden" id="date_from" name="date_from" value="{{$alternatives["lowerSuggestion"][0]}}">
                       <input type="hidden" id="date_to" name="date_to" value="{{$alternatives["lowerSuggestion"][1]}}">
                       <input type="hidden" id="reason" name="reason" value="{{$request_data->reason}}">
                       <button type="submit" class="btn btn-primary">Request Alternative</button>
                    </form>

                  </div>
                </td>
                </tr>
                @endif

              @if($alternatives["upperSuggestion"] !=null)
              <tr>
                <td><div class="text-center">{{$alternatives["upperSuggestion"][0]}}</div></td>
                <td><div class="text-center">{{$alternatives["upperSuggestion"][1]}}</div></td>
                <td>
                  <div class="text-center">
                    <form action="/user_area/request_holiday_from_alternative/" method="post">
                      @csrf
                       <input type="hidden" id="date_from" name="date_from" value="{{$alternatives["upperSuggestion"][0]}}">
                       <input type="hidden" id="date_to" name="date_to" value="{{$alternatives["upperSuggestion"][1]}}">
                       <input type="hidden" id="reason" name="reason" value="{{$request_data->reason}}">
                       <button type="submit" class="btn btn-primary">Request Alternative</button>
                    </form>
                  </div>
                </td>
                </tr>
              @endif
            
        </tbody>
    </table>
            <br>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
  @else
  <div class="container">
  <div class="row">
    <div class="col-lg-12 pt-2">
      <div class="text-center text-danger"><h5>{{$alternatives["error"]}}</h5></div>
    </div>
  </div>
</div>
  @endif
@endif

@endsection
