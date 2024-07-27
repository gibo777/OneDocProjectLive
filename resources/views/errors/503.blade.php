<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'One Document Corporation') }} Under Maintenance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            text-align: center;
            padding: 50px;
        }
        .maintenance-message {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            display: inline-block;
        }
    </style>
    <link rel="shortcut icon" href="{{ asset('img/all/onedoc-favicon.png') }}">
</head>
<body>
    <div class="maintenance-message">

        <div class="">
            <img src="{{ asset('/img/company/onedoc-logo.png') }}" class="rounded mx-auto d-block pb-3"/>
        </div>
        <h3>{{ config('app.name', 'One Document Corporation') }}</h3>
        <h1>Under Maintenance</h1>
        <p>We apologize for the inconvenience, but the server is currently under maintenance.</p>
    </div>
</body>
</html>
