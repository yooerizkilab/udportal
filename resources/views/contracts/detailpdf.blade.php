<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Kontrak</title>
</head>
<body>
    <label for="code">Code : </label>
    {{ $contract->code }}
    <br>
    <br>
    <label for="name">Name : </label>
    {{ $contract->name }}
</body>
</html>