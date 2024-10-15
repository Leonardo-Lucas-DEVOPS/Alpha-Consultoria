<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Alpha Consultoria | Sua Fatura</title>

    <meta name="description"
        content="Alpha Consultoria é especializada em investigações corporativas e segurança empresarial, garantindo a integridade e proteção da sua empresa.">

    <style>
        :root {
            --branco: #fff;
            --amarelo: #ffc107;
            --preto: #212222;
            --cinza: #cecece
        }

        body {
            font-family: sans-serif;
            text-align: center;
            border-style: groove;
            align-items: center
        }

        header {
            background-color: var(--preto);
            padding: 5%;
            text-align: left;
        }

        h1,
        p {
            justify-content: center;
            padding: 1%;
        }

        .info {
            background-color: #e6e6e6;
            border-radius: 30%;
            width: 80%;
            margin-left: 10%;
        }

        table {
            margin: 5%
        }

        th,
        td {
            text-align: center;
            border-style: groove;
        }

        .geral {
            margin-left: 7%;
        }

        .consultas {
            margin-left: 5%;
        }

        .geral th {
            background-color: var(--amarelo);
        }

        .consultas th {
            background-color: var(--cinza);
        }

        .whatsapp {
            width: 10%;
            height: 35%;
            margin-left: 80%;
        }
    </style>
</head>

<body>

    <header>
        <img src="{{ $invoices['logo'] }}" alt="Logo da Alpha-Consultoria" style="width:10%; height:5%;">
    </header>

    <main>
        <h1>Fatura completa</h1>

        <hr>

        <h2>Dados Empresariais</h2>

        <div class="info">
            <p>Fatura N°: {{ $invoices['id'] }}</p>

            <p>Data de Emissão: {{ $invoices['generation_date'] }} | Data de Vencimento: {{ $invoices['due_date'] }}</p>

            <p>Situação: Pedido <b>{{ $invoices['status']}}</b></p>
        </div>

        <table class="geral">
            <tr>
                <th>Consultoria: Alpha Consultoria</th>
                <th>Empresa: {{ $invoices['company'] }}</th>
            </tr>
            <tr>
                <td>CPF/CNPJ: 12345670001889</td>
                <td>CPF/CNPJ {{ $invoices['cpf_cnpj'] }}</td>
            </tr>
            <tr>
                <td>Endereço: João Veloso filho, 1402, São Paulo-SP</td>
                <td>Endereço: {{ $invoices['address'] }}</td>
            </tr>
            <tr>
                <td>E-Mail: atendimento@alphaassessoriarh.com</td>
                <td>E-Mail: {{ $invoices['email'] }}</td>
            </tr>
            <tr>
                <td>Telefone: (11) 99323-3989</td>
                <td>Telefone: {{ $invoices['phone'] }}</td>
            </tr>
        </table>

        <hr>

        <h2>Registros de consultas</h2>

        <table class="consultas">
            <tr>
                <th>N° de Funcionários</th>
                <th>N° de Prestadores de Serviços</th>
                <th>N° de Veículos</th>
                <th>Valor da Fatura</th>
            </tr>
            <tr>
                <td>{{ $company->Employees }}</td>
                <td>{{ $company->Freelancers }}</td>
                <td>{{ $company->Vehicles }}</td>
                <td>R${{ $company->Price }}.00</td>
            </tr>
        </table>
    </main>

    <footer>
        <a href="https://wa.me/5511993233989?text=Ol%C3%A1%2C%20gostaria%20de%20mais%20informa%C3%A7%C3%B5es%20sobre%20os%20servi%C3%A7os%20da%20Alpha%20Consultoria."
            target="_blank" rel="noopener noreferrer" style="width: 25%; height: 25%; margin-left: 70%;">
            <img src="{{ $invoices['whatsapp'] }}" alt="Contato da Alpha-Consultoria" class="whatsapp">
        </a>

        <p>Todos os direitos reservados a Alpha Consultoria®</p>
    </footer>

</body>

</html>
