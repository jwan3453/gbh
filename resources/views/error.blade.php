<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;” />
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=false;” />
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;” />
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('Gbh/css/website.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/container.css') }}>

    @yield('resources')
</head>

<body>




<div class="  ui container" >
    @yield('content')
</div >


</body>

@yield('script')


</html>