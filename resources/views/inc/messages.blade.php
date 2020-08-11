<!-- If errors occur -->
@if(count($errors) > 0)
    <!-- Alert user of each error -->
    @foreach($errors->all() as $error)
        <div class="alert alert-danger" id="alert">
            {{$error}}
        </div>
    @endforeach
@endif

<!-- If sucsess alert user -->
@if(session('success'))
    <div class="alert alert-success" id="alert">
        {{session('success')}}
    </div>
@endif

<!-- If error occurs, alert user -->
@if(session('error'))
    <div class="alert alert-danger" id="alert">
        {{session('error')}}
    </div>
@endif