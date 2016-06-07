
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;” />
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=false;” />
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;” />
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <script src={{ asset('js/jquery-2.1.4.min.js') }}></script>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('Gbh/css/website.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/transition.css') }}>

    <script src={{ asset('semantic/transition.js') }}></script>
    @yield('resources')

</head>

<body>

    <div>
        @yield('content')
    </div>
<!--  <div class="foot-box">

     </div> -->
</body>







@yield('script')

<script type="text/javascript">

    $(document).ready(function(){
    })


</script>

</html>
