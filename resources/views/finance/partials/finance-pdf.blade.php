<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Alpha Consultoria | Sua Fatura</title>
</head>

<body>

    @foreach ($invoices as $invoice => $value)
        <p>{{ $invoice }}: {{ $value }}</p>
    @endforeach

</body>

</html>
