<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Alpha Consultoria | Sua Fatura</title>

    <meta name="description"
        content="Alpha Consultoria é especializada em investigações corporativas e segurança empresarial, garantindo a integridade e proteção da sua empresa.">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="180x180" href="data:image/png;base64,{favicon-32x32.png}">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            text-align: center;
        }

        table {
            margin: 6%
        }

        h1,
        p {
            padding: 1%;
            justify-content: center;
        }

        th,
        td {
            padding: 3%;
            text-align: center
        }
    </style>
</head>

<body>

    <header>
        <h1>Fatura completa</h1>

        <p>Fatura N°: {{ $invoices['id'] }}</p>

        <p>Data: {{ $invoices['data'] }} | Vencimento: </p>

        <p>Siuação: Pedido recebido</p>
    </header>

    <main>
        <table>
            <tr>
                <th>Consultoria: Alpha Consultoria</th>
                <th>Empresa: {{ $invoices['company'] }}</th>
            </tr>
            <tr>
                <td>Endereço: João Veloso filho, 1402, São Paulo-SP</td>
                <td>E-Mail: {{ $invoices['email'] }}</td>
            </tr>
            <tr>
                <td>E-Mail: atendimento@alphaassessoriarh.com</td>
                <td>Telefone: {{ $invoices['phone'] }}</td>
            </tr>
            <tr>
                <td>Telefone: (11) 99323-3989</td>
                <td>Endereço: {{ $invoices['address'] }}</td>
            </tr>
        </table>

        <hr>

        <table>
            <tr>
                <th>N° de Funcionários</th>
                <th>N° de Prestadores de Serviços</th>
                <th>N° de Veículos</th>
                <th>Preço</th>
            </tr>
            @foreach ($companies as $company)
                <tr>
                    <td>{{ $company->Funcionarios }}</td>
                    <td>{{ $company->Prestadores }}</td>
                    <td>{{ $company->Veiculos }}</td>
                    <td>Ola</td>
                </tr>
            @endforeach
        </table>
    </main>

    <footer>
        <p>Todos os direitos reservados a Alpha Consultoria®</p>
    </footer>

</body>

</html>
