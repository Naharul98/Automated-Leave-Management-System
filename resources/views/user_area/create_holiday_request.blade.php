@extends('layouts.app')

@section('content')
<br>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Holiday Request Details</div>
        <div class="container">
          <form action="/user_area/request_new_holiday/" method="post">
            @csrf
            <br>
            <fieldset class="form-group">
              <div class="row">
                <legend class="col-form-label col-sm-3 pt-0">Date From:</legend>
                <div class="col-sm-9">
                  <div class="form-date">
                    <input class="form-control" type="date" id="date_from" name="date_from" required onchange="fixDateRange();">
                  </div>
                </div>
              </div>
            </fieldset>
            <div class="form-group row">
              <label for="date_to" class="col-sm-3 col-form-label">Date To:</label>
              <div class="col-sm-9">
                <div class="dropdown">
                  <input class="form-control" type="date" id="date_to" name="date_to" required onchange="fixDateRange();">
                </div>
              </div>
            </div>
            <div class="form-group row" id="Description">
              <label for="reason" class="col-sm-3 pt-0 col-form-label">Reason:</label>
              <div class="col-sm-9">
                <textarea class="form-control" type="textarea" id="reason" placeholder="Reason" name="reason" rows="5" required></textarea>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-sm-3"></div>
              <div class="col-sm-9">
                <button type="submit" class="btn btn-primary">Request Holiday Booking</button>
              </div>
            </div>
          </form>
          <br>
        </div>
      </div>
    </div>
  </div>
</div>


<br>
<script>
  function fixDateRange()
  {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1;
    var yyyy = today.getFullYear();
    if(dd<10)
    {
        dd='0'+dd
    } 
    if(mm<10)
    {
        mm='0'+mm
    } 
    
    today = yyyy+'-'+mm+'-'+dd;
    var lastDateOfYear = yyyy+'-'+'12'+'-'+'31';


    document.getElementById("date_from").setAttribute("min", today);
    document.getElementById("date_to").setAttribute("min", today);
    document.getElementById("date_to").setAttribute("max", lastDateOfYear);

    if($("#date_from").val() != "")
    {
      document.getElementById("date_to").setAttribute("min", $("#date_from").val());
      if($("#date_to").val() != "")
      {
        if(Date.parse($("#date_to").val()) < Date.parse($("#date_from").val()))
        {
          document.getElementById("date_to").value = $("#date_from").val();
        }
      }
    }
}
fixDateRange();
</script>
@endsection
