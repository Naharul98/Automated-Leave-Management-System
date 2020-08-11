@extends('layouts.app')
@section('content')
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>@yield('title')</h4>
                </div>
                <div class="container">
                	@yield('containerContent')
                </div>
            </div>
        </div>
    </div>
</div>
<br>
@endsection