@extends('layouts.app')
@section('content')

<section class="search-banner bg-light text-black py-4" id="banner">
    <div class="container pt-0 my-0">
        <div class="row text-center pb-0">
            <div class="col-lg-12 pb-3">
                <h3>Employees on Holiday</h3>
            </div>
        </div>
        <form action="/staff_area/admin/filter_by_month" method="POST" class="form-inline" >
            @csrf
            <div class="container-fluid">
                <div class="row">
                    <div class="span6" id="browse_page_filter_div">
                        <span class = "label label-default pr-3 pl-3">Month: </span>
                        <input class="form-control" type="month" id="month" name="month" value= "{{$filterFormData['month']}}" required>

                        <input type="submit" name="search" class="btn btn-md btn-primary active" role="button" aria-pressed="true" value="Filter"/>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<div class="container-fluid pb-5">
    <table class="table">
        <thead class="thead">
            <tr>
                <!-- Table headers -->
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Department</th>
                <th>Number of days working</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($tableData as $data)
            <tr>
                <td>{{$data->id}}</td>
                <td>{{$data->name}}</td>
                <td>{{$data->email}}</td>
                <td>{{$data->role}}</td>
                <td>{{($data->department_name == "") ? 'N/A' : $data->department_name}}</td>
                <td>{{($data->days_working != "") ? $data->days_working : 'N/A'}}</td>
            </tr>
            @endforeach
           
        </tbody>
    </table>
</div>


@endsection
