<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DEV Console</title>
</head>
<body>
<a href="{{ route('dev-console') }}"> Dev Console</a>
<hr>
<a href="{{ route('artisan.db-seed') }}"> DB Seed </a>
<hr>
<a href="{{ route('artisan.migrate') }}"> MIgrate </a>
<hr>
<a href="{{ route('artisan.migrate-fresh') }}"> MIgrate Fresh </a>
<hr>
<a href="{{ route('artisan.clear') }}"> Clear Cache </a>
<hr>

<script>
    @if(session()->has('msg'))
    alert("{{ session('msg') }}")
    @endif

</script>

</body>
</html>
