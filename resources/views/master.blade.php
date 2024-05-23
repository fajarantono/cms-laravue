<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- PAGE TITLE -->
    <title>{{ Settings::group('company')->get('company_name') }}</title>
        <!-- FONTS -->
    <link rel="stylesheet" href="{{ asset('themes/default/fonts/fontawesome/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/default/fonts/lab/lab.css') }}">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body>
        <div id="app">
            <default-component/>
        </div>
    </body>
</html>

<script>
    const APP_URL = "{{ env('MIX_HOST') }}";
    const APP_KEY = "{{ env('MIX_API_KEY') }}";
    const GOOGLE_TOKEN = "{{ env('MIX_GOOGLE_MAP_KEY') }}";
    const APP_DEMO = "{{ env('MIX_DEMO') }}";
</script>
<script src="{{ mix('js/app.js') }}"></script>
