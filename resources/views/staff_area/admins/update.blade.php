@extends('layouts.app')

@section('content')
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit</div>

                <div class="card-body">
                    <!-- Populate form with admin data -->
                    <form action="/staff_area/admin/update/{{$entry->id}}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name',$entry->name) }}" required autofocus>

                                <!-- If error in name, alert user -->
                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email',$entry->email) }}" required>

                                <!-- If error in emial, alert user -->
                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right">Role</label>
                            <div class="col-md-6">
                                <select id="cmb_role" class="form-control pr-3 pl-3" name="role" onchange="removeMultipeSelectorIfSuperAdmin();">
                                    <option value="manager" {{($entry->role === 'manager') ? ' selected': ' ' }}>Manager</option>
                                    <option value="customer_service_assistant" {{($entry->role === 'customer_service_assistant') ? ' selected': ' ' }}>Customer Service Assistant</option>

                                    <option value="stocker" {{($entry->role === 'stocker') ? ' selected': ' ' }}>Stocker</option>
                                    <option value="shift_leader" {{($entry->role === 'shift_leader') ? ' selected': ' ' }}>Shift Leader</option>
                                    <option value="merchandise_displayer" {{($entry->role === 'merchandise_displayer') ? ' selected': ' ' }}>Merchandise Displayer</option>
                                    <option value="cleaner" {{($entry->role === 'cleaner') ? ' selected': ' ' }}>Cleaner</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group row" id="multiple_selector">
                            <label for="role" class="col-md-4 col-form-label text-md-right">Department</label>
                            <div class="col-md-8">
                            <select class="selectpicker" data-live-search="true" data-selected-text-format="count > 2" data-width="60%" name="department_choice" data-style="btn-info">
                                <!-- Populate sessions list -->
                                @foreach ($departments as $department)
                                <option value="{{$department->department_id}}">
                                    {{$department->department_name}}
                                </option>
                                @endforeach
                            </select>
                          </div>
                        </div>


                        <div class="form-group row" id="cmb_entitlement">
                            <label for="role" class="col-md-4 col-form-label text-md-right">Days per Week</label>
                            <div class="col-md-6">
                                <select id="cmb_days_per_week" class="form-control pr-3 pl-3" name="days_per_week">
                                    <option value="1" {{($entry->days_working == '1') ? ' selected': ' ' }}>1</option>
                                    <option value="2" {{($entry->days_working == '2') ? ' selected': ' ' }}>2</option>
                                    <option value="3" {{($entry->days_working == '3') ? ' selected': ' ' }}>3</option>
                                    <option value="4" {{($entry->days_working == '4') ? ' selected': ' ' }}>4</option>
                                    <option value="5" {{($entry->days_working == '5') ? ' selected': ' ' }}>5</option>
                                    <option value="6" {{($entry->days_working == '6') ? ' selected': ' ' }}>6</option>
                                    <option value="7" {{($entry->days_working == '7') ? ' selected': ' ' }}>7</option>
                                </select>
                            </div>
                        </div>


                  <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
<script src="{{ asset('js/admin.js') }}" defer></script>
@endsection
