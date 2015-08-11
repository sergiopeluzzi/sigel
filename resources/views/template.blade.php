<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $page_title or "SIGEL" }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ asset('/bower_components/admin-lte/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="{{ asset('/bower_components/admin-lte/dist/css/font-awesome-4.4.0/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="{{ asset('/bower_components/admin-lte/dist/css/ionicons-2.0.1/css/ionicons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Datatables -->
    <link href="{{ asset('/bower_components/admin-lte/plugins/DataTables-1.10.7/media/css/jquery.dataTables.css') }}" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset('/bower_components/admin-lte/dist/css/AdminLTE.css') }}" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link href="{{ asset('/bower_components/admin-lte/dist/css/skins/skin-green.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<body class="skin-green">
<div class="wrapper">

    <!-- Header -->
    @include('header')

    <!-- Sidebar -->
    @include('sidebar')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                {{ $titPagina or 'Titulo'}}
                <small>{{ $descPagina or null }}</small>
            </h1>
        </section>

        <section class="content">
            @yield('content')
        </section>
    </div>

    @include('footer')

</div>

<!-- jQuery 2.1.3 -->
<script src="{{ asset('/bower_components/admin-lte/plugins/jQuery/jQuery-2.1.4.min.js') }}" type="text/javascript"></script>
<!-- jQuery UI -->
<script src="{{ asset('/bower_components/admin-lte/plugins/jQueryUI/jquery-ui.min.js') }}" type="text/javascript"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset('/bower_components/admin-lte/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/bower_components/admin-lte/dist/js/app.min.js') }}" type="text/javascript"></script>
<!-- Slimscroll -->
<script src="{{ asset('/bower_components/admin-lte/plugins/slimScroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<!-- FastClick -->
<script src="{{ asset('/bower_components/admin-lte/plugins/fastclick/fastclick.min.js') }}" type="text/javascript"></script>
<!-- Datatables -->
<script src="{{ asset('/bower_components/admin-lte/plugins/DataTables-1.10.7/media/js/jquery.dataTables.js') }}" type="text/javascript" ></script>
<!-- InputMask -->
<script src="{{ asset('/bower_components/admin-lte/plugins/jQuery/jquery.mask-1.11.4.min.js') }}" type="text/javascript" ></script>
<!-- JS SCRIPTS -->
@yield('scripts')

</body>
</html>