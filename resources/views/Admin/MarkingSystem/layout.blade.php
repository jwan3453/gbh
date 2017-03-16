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
    <link  rel="stylesheet" type="text/css"  href ={{ asset('Admin/css/system.css') }}>
    {{--<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/transition.css') }}>--}}
    {{--<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/icon.css') }}>--}}
    {{--<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/table.css') }}>--}}
    {{--<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/modal.min.css') }}>--}}
    {{--<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/loader.css') }}>--}}
    {{--<script src={{ asset('semantic/transition.js') }}></script>--}}
    {{--<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.11.6/semantic.min.css"/>--}}

    {{--<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/dropdown.css') }}>--}}
    {{--<script src={{ asset('semantic/dropdown.js') }}></script>--}}

    {{--<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/divider.css') }}>--}}

    @yield('resources')

</head>

<body>

    <div class="container">
        @yield('content')
    </div>

    <div class="alert-box" id="alertBox"></div>

</body>



@yield('script')

<script type="text/javascript">
    $(document).ready(function() {

    });


    function toastAlert(Msg,status)
    {

        if(status === 1)
        {
            $('#alertBox').removeClass('success-toast').addClass('success-toast');
        }
        $('#alertBox').text(Msg).fadeIn();

        setTimeout(function () {
            $('#alertBox').fadeOut();
        }, 2000);
    }

</script>

</html>