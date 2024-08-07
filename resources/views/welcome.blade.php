    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Alpha Consultoria | Investigação Corporativa e Segurança Empresarial</title>
        <meta name="description" content="Alpha Consultoria é especializada em investigações corporativas e segurança empresarial, garantindo a integridade e proteção da sua empresa.">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
        <!-- Bootstrap CSS -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
        <style>
            .bg-image {
                background-image: url('/images/Background.png');
                background-size: cover;
                background-position: center;
                height: 100vh;
            }



            .navbar-brand img {
                height: 40px;
                margin-left: 120%;
            }

            .btn-custom,
            .btn-outline-custom {
                color: #fff;
                border: 2px solid transparent;
                border-radius: 5px;
                padding: 3px 7px;
                margin: 20px;
                font-weight: bold;
                text-transform: uppercase;
                transition: all 0.3s ease-in-out;
            }

            .btn-custom {
                background-color: #ffc107;
                /* Amarelo */
                color: #212222;
                /* Preto */
            }

            .btn-outline-custom {
                color: #ffc107;
                /* Amarelo */
                background-color: transparent;
                border-color: #ffc107;
                /* Amarelo */
            }

            .btn-custom:hover,
            .btn-outline-custom:hover {
                background-color: #212222;
                /* Preto */
                color: #ffc107;
                /* Amarelo */
                border-color: #ffc107;
                /* Amarelo */
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            }

            .section {
                padding: 60px 0;
                background-color: #696969;
            }

            .section h2 {
                color: #fff;
                /* Branco */
            }

            .section p {
                color: #fff;
                /* Branco */
            }

            .bg-dark {
                background-color: #212222;
                /* Preto */
                color: #ffc107;
                /* Amarelo */
            }

            .bg-grey {
                background-color: #212222;
            }

            .bg-dark h2,
            .bg-dark p {
                color: #ffc107;
                /* Amarelo */
            }

            .home {
                margin: 200px;
                margin-bottom: 0;
                font-family: 'bold';
            }

            .home span {
                color: #fff;
            }

            .home {
                overflow: hidden;
                /* Garantir que os itens não apareçam fora do contêiner durante a animação */
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
                animation-delay: 1s;
                /* Atraso para o texto do span */
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
                </a>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#sobre-nos">Sobre Nós</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#servicos">Serviços</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://wa.me/5511993233989?text=Olá,%20gostaria%20de%20mais%20informações%20sobre%20os%20serviços%20da%20Alpha%20Consultoria.">Contato</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-auto">
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
                </div>

            </nav>

            <div class="home">
                <h1 class="text-warning display-1">Bem-vindo</h1>
                <span>Seu sucesso empresarial está aqui.</span>
            </div>
        </header>

        <main>
            <section id="sobre-nos" class="section">
                <div class="container">
                    <h2 class="text-center"><em>Sobre Nós</em></h2>
                    <p class="text-center">
                        <em>Alpha Consultoria é uma empresa especializada em investigações corporativas.
                            Realizamos um levantamento completo de dados dos funcionários, candidatos às vagas e prestadores de serviço. Nossa análise minuciosa abrange passagens criminais, histórico jurídico, processos trabalhistas, criminais e cíveis.
                            Evite exposições de risco como fraudes, golpes, roubos e improdutividade, confiando na Alpha Consultoria para garantir a segurança e a integridade da sua empresa.
                        </em>
                    </p>
                </div>
            </section>

            <section id="servicos" class="m-5">
                <div class="container p-5 ">

                    <!-- Conteúdo dos serviços -->
                    <h2 class="text-center"><em>Nossos serviços</em></h2>
                    <p>
                        <em>Alpha Consultoria é uma empresa especializada em investigações corporativas.
                            Realizamos um levantamento completo de dados dos funcionários, candidatos às vagas e prestadores de serviço. Nossa análise minuciosa abrange passagens criminais, histórico jurídico, processos trabalhistas, criminais e cíveis.
                            Evite exposições de risco como fraudes, golpes, roubos e improdutividade, confiando na Alpha Consultoria para garantir a segurança e a integridade da sua empresa.
                        </em>
                    </p>
                    <p><em>
                            </br><strong>Análise Minuciosa:</strong> A análise minuciosa dos dados deve incluir a verificação de antecedentes criminais, histórico jurídico, processos trabalhistas, criminais e cíveis. Esse exame aprofundado é crucial para assegurar que os indivíduos que estão se candidatando a uma vaga ou que já estão em exercício na empresa não possuam histórico que possa comprometer a segurança ou a reputação da organização.

                    </p>
                    <p>
                        </br> <strong>Evite Exposições de Risco:</strong> Adotar estas práticas de análise de dados ajuda a evitar exposições a riscos significativos como fraudes, golpes, roubos e improdutividade. Garantir que todos os funcionários e prestadores de serviço sejam submetidos a um rigoroso processo de verificação é fundamental para manter um ambiente de trabalho seguro, eficiente e confiável.
                        Implementar essas medidas de segurança não só protege a empresa contra possíveis ameaças, mas também reforça a confiança de clientes e parceiros, contribuindo para um ambiente corporativo mais seguro e produtivo.

                        </br> <strong></strong>
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
    </body>

    </html>