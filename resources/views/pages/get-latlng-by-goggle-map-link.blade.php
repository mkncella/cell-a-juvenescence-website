<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Link Test</title>
</head>
<body>
    
    <h1>Halo</h1>
    <p>{{ $resolved }}</p>
    <p>lat: {{ $lat }}</p>
    <p>lng: {{ $lng }}</p>
    <p>zoom: {{ $zoom }}</p>
    <p>matches: {{ json_encode($matches) }}</p>
    <p>link: {{ $link }}</p>

</body>
</html>