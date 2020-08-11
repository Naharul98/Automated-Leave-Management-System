@extends('layouts.app')
@section('content')

<section class="search-banner bg-light text-black py-4" id="banner">
    <div class="container pt-0 my-0">
        <div class="row text-center pb-0">
            <div class="col-lg-12 pb-3">
                <h3>Requests Rejected by system</h3>
            </div>
        </div>
    </div>
</section>
<div class="container-fluid pb-5">
    <table class="table">
        <thead class="thead">
            <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Role</th>
                <th>Department</th>
                <th>Request From</th>
                <th>Request To</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>

            <!-- Populate table with admins -->
            @foreach ($requestData as $data)
            <tr>
                <td>{{$data->id}}</td>
                <td>{{$data->name}}</td>
                <td>{{$data->role}}</td>
                <td>{{$data->department_name}}</td>
                <td>{{$data->date_from}}</td>
                <td>{{$data->date_to}}</td>
                <td><a class="action" href="/user_area/view_request/{{$data->request_id}}">View</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $requestData->links() }}
</div>


@endsection
