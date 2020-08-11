@include('inc.header')
<body>
    <div id="app">
        @include('inc.navbar')
        <div class="container-fluid">
        	@include('inc.messages')
           @yield('content')

       </div>

   </div>
</body>
@include('inc.footer')
</html>
