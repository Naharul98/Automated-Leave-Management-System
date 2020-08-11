@extends('layouts.app')

@section('content')
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                <!-- If error in name, alert user -->
                                @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                <!-- If error in email, alert user -->
                                @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                <!-- If error in password, alert user -->
                                @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <!-- If user is super-admin -->
                        @auth
                        @if (Auth::user()->role == "manager")
                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right">Role</label>
                            <div class="col-md-6">
                                <select id="cmb_role" class="form-control pr-3 pl-3" name="role" onchange="removeMultipeSelectorIfSuperAdmin();">
                                    <option value="manager">Manager</option>
                                    <option value="customer_service_assistant">Customer Service Assistant</option>
                                    <option value="stocker">Stocker</option>
                                    <option value="shift_leader">Shift Leader</option>
                                    <option value="merchandise_displayer">Merchandise Displayer</option>
                                    <option value="cleaner">Cleaner</option>
                                </select>
                            </div>
                        </div>
                        <!-- todo- add javascript appear/disappear-->
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
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                </select>
                            </div>
                        </div>

                        @endif
                        @endauth
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
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
