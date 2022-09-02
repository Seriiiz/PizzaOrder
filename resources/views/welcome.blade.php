<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
    </head>
    <style>
        .container{
            padding: 10px;
        }
        .card{
            border-style:solid;
            padding: 20px;
        }
        .col {
            float: left;
            width: 33.33%;
            padding: 10px;
            height: auto;
        }
    </style>
    <body>
        <div id="app">
            <main-component></main-component>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
