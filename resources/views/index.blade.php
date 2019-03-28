<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>{{config('app.name')}}</title>
  <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons">-->
  <!-- <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700%7CMaterial+Icons' rel="stylesheet"> -->
  <link href='./font/css/material-icons.css' rel="stylesheet">
    <script src="./js/echarts-en.min.js?v=4.0.4"></script>
    <!-- <script src="https://cdn.bootcss.com/echarts/4.0.4/echarts-en.min.js"></script> -->
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
  <div id="app"></div>

  @include('scripts')
</body>
</html>
