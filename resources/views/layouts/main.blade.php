<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- include head -->
    <title>@yield('title','Dashboard') | Diary</title>
    @include('includes.head')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- include header -->
        @include('includes.header')

        <!-- include sidebar -->
        @include('includes.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>
    <!-- include modals -->
    @include('includes.modals')

    <!-- include scripts -->
    @include('includes.script')

</body>
</html>