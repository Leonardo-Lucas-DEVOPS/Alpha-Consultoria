<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alpha Consultoria | Investigação Corporativa e Segurança Empresarial</title>
    <meta name="description"
        content="Alpha Consultoria é especializada em investigações corporativas e segurança empresarial, garantindo a integridade e proteção da sua empresa.">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/favicons/site.webmanifest') }}">
    <style>
        :root {
            --branco: #fff;
            --amarelo: #ffc107;
            --preto: #212222;
            --cinza: #696969;
        }

        .bg-image {
            background-image: url('/images/Background.png');
            background-size: cover;
            background-position: center;
            height: 100vh;
        }

        .navbar-nav {
            display: flex;
            justify-content: space-around;
            flex-direction: row;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .navbar-brand img {
            height: 40px;
            margin-left: 25%;
        }

        .btn-custom,
        .btn-outline-custom {
            color: var(--branco);
            border: 2px solid transparent;
            border-radius: 5px;
            padding: 3px 7px;
            margin: 20px;
            font-weight: bold;
            text-transform: uppercase;
            transition: all 0.3s ease-in-out;
        }

        .btn-custom {
            background-color: var(--amarelo);
            color: var(--preto);
        }

        .btn-outline-custom {
            color: var(--amarelo);
            background-color: transparent;
            border-color: var(--amarelo);
        }

        .btn-custom:hover,
        .btn-outline-custom:hover {
            background-color: var(--preto);
            color: var(--amarelo);
            border-color: var(--amarelo);
            box-shadow: 0 0 10px var(--preto);
        }

        .section {
            padding: 60px 0;
            background-color: var(--cinza);
        }

        .section h2 {
            color: var(--branco);
        }

        .section p {
            color: var(--branco);
        }

        .bg-dark {
            background-color: var(--preto);
            color: var(--amarelo);
        }

        .bg-grey {
            background-color: var(--preto);
        }

        .bg-dark h2,
        .bg-dark p {
            color: var(--amarelo);
        }

        .home {
            position: absolute;
            margin-top: 15%;
            padding-left: 10%;
            margin-bottom: 0;
            font-family: 'bold';
            overflow: hidden;
            z-index: 1;
        }

        .home h1,
        .home span {
            opacity: 0;
            transform: translateX(-100%);
            animation: slideIn 3s forwards;
        }

        .home h1 {
            animation-delay: 0.5s;
            /* Atraso para o título */
        }

        .home span {
            color: var(--branco);
            animation-delay: 1s;
            /* Atraso para o texto do span */
        }

        @media screen and (max-width: 992px) {
            .navbar-collapse {
                display: flex;
                flex-direction: column;
            }

            .nav-item {
                padding: 5px;
            }

            .btn-custom,
            .btn-outline-custom {
                padding: 0px 0px;
                margin: 2px;
            }

            .home {
                top: 25%;
                padding-left: 4%;
            }

            .home h1 {
                font-size: 370%;
                /* Tamanho reduzido para telas menores */
            }

        }

        @media screen and (min-width: 992px) {
            .navbar {
                display: flex;
                flex-direction: row
            }

            .botoes {
                order: 2;
            }

            .links {
                order: 1;
            }
        }

        @keyframes slideIn {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>

<body>
    <header class="bg-image">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <a class="navbar-brand" href="#">
                <img src="/images/logo.png" alt="Logo Alpha Consultoria">

                <ul class="botoes navbar-nav ml-auto">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a class="btn btn-outline-custom" href="{{ url('/dashboard') }}">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="btn btn-outline-custom mr-2" href="{{ route('login') }}">Entrar</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="btn btn-custom" href="{{ route('register') }}">Criar conta</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </a>

            <div class="navbar-collapse">
                <ul class="links navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#sobre-nos">Sobre Nós</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#servicos">Serviços</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="https://wa.me/5511993233989?text=Olá,%20gostaria%20de%20mais%20informações%20sobre%20os%20serviços%20da%20Alpha%20Consultoria.">Contato</a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="home">
            <h1 class="text-warning display-1">Bem-vindo</h1>
            <span>Seu sucesso empresarial está aqui.</span>
        </div>
    </header>

    <main>
        <section id="sobre-nos" class="section">
            <div class="container p-5">
                <h2 class="text-center"><em>Sobre Nós</em></h2>
                <p class="text-center">
                    <em>Alpha Consultoria é uma empresa especializada em investigações corporativas.
                        Realizamos um levantamento completo de dados dos funcionários, candidatos às vagas e
                        prestadores de serviço. Nossa análise minuciosa abrange passagens criminais, histórico
                        jurídico, processos trabalhistas, criminais e cíveis.
                        Evite exposições de risco como fraudes, golpes, roubos e improdutividade, confiando na Alpha
                        Consultoria para garantir a segurança e a integridade da sua empresa.
                    </em>
                </p>
            </div>
        </section>

        <section id="servicos" class="m-5">
            <div class="container">
                <!-- Conteúdo dos serviços -->
                <h2 class="text-center"><em>Nossos serviços</em></h2>
                <p class="text-center">
                    <em>
                        </br><strong>Análise Minuciosa:</strong> A análise minuciosa dos dados deve incluir a
                        verificação de antecedentes criminais, histórico jurídico, processos trabalhistas, criminais
                        e cíveis. Esse exame aprofundado é crucial para assegurar que os indivíduos que estão se
                        candidatando a uma vaga ou que já estão em exercício na empresa não possuam histórico que
                        possa comprometer a segurança ou a reputação da organização.

                </p>
                <p class="text-center">
                    </br> <strong>Evite Exposições de Risco:</strong> Adotar estas práticas de análise de dados
                    ajuda a evitar exposições a riscos significativos como fraudes, golpes, roubos e
                    improdutividade. Garantir que todos os funcionários e prestadores de serviço sejam submetidos a
                    um rigoroso processo de verificação é fundamental para manter um ambiente de trabalho seguro,
                    eficiente e confiável.
                    Implementar essas medidas de segurança não só protege a empresa contra possíveis ameaças, mas
                    também reforça a confiança de clientes e parceiros, contribuindo para um ambiente corporativo
                    mais seguro e produtivo.

                    </br>
                    </em>
                </p>
            </div>
        </section>
    </main>

    <footer>
        <section id="direitos" class="bg-grey text-light">
            <div class="container p-4">
                <p class="text-center ">Todos os direitos reservados a Alpha Consultoria®</p>
            </div>
        </section>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
