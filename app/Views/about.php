<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sobre o Projeto' ?></title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/home.css">

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            padding-top: 20px;
        }

        .sobre-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 40px 20px;
            background-color: #fff;
        }

        .sobre-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .sobre-header h1 {
            color: #5b2e91;
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .sobre-header p {
            font-size: 1.1rem;
            color: #666;
            max-width: 700px;
            margin: 0 auto;
        }

        .tech-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
        }

        .tech-card {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 12px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .tech-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .tech-card i {
            font-size: 3rem;
            color: #2c70ff;
            margin-bottom: 20px;
        }

        .tech-card h3 {
            color: #333;
            margin-bottom: 10px;
            font-size: 1.25rem;
        }

        .tech-card p {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .features-section {
            margin-bottom: 50px;
        }

        .features-section h2 {
            text-align: center;
            color: #333;
            margin-bottom: 40px;
            font-size: 2rem;
        }

        .feature-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 768px) {
            .feature-list {
                grid-template-columns: 1fr;
            }
        }

        .feature-item {
            display: flex;
            align-items: flex-start;
            padding: 20px;
            background: #fff;
            border-left: 4px solid #5b2e91;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .feature-item i {
            font-size: 1.5rem;
            color: #5b2e91;
            margin-right: 15px;
            margin-top: 3px;
        }

        .feature-content h4 {
            margin-bottom: 5px;
            color: #333;
            font-size: 1.1rem;
        }

        .feature-content p {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .developer-corner {
            text-align: center;
            margin-top: 60px;
            padding-top: 40px;
            border-top: 1px solid #eee;
        }

        /* Ajuste do footer fixo se necessário, mas usando flex body resolve */
        .footer {
            position: relative;
            margin-top: auto;
        }
    </style>
</head>

<body>

    <header class="menu-bg">
        <div class="menu">
            <div class="menu-logo">
                <a href="/home"><img src="img/logo.png" alt="PetMais"></a>
            </div>
            <nav class="menu-nav">
                <ul>
                    <li><a href="/home">Voltar para Home</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="main-content">
        <div class="sobre-container">
            <div class="sobre-header">
                <h1>Sobre o Projeto</h1>
                <p>O <strong>Sistema PetMais</strong> é uma solução web moderna desenvolvida para facilitar o gerenciamento de petshops e proporcionar a melhor experiência para seus clientes.</p>
            </div>

            <div class="tech-grid">
                <div class="tech-card">
                    <i class="fa-brands fa-php"></i>
                    <h3>Back-end PHP</h3>
                    <p>Desenvolvido com PHP estruturado seguindo o padrão MVC (Model-View-Controller) para organização e escalabilidade.</p>
                </div>
                <div class="tech-card">
                    <i class="fa-solid fa-server"></i>
                    <h3>Banco de Dados</h3>
                    <p>Integração com MySQL para persistência segura de informações de usuários e produtos.</p>
                </div>
                <div class="tech-card">
                    <i class="fa-brands fa-css3-alt"></i>
                    <h3>Front-end Moderno</h3>
                    <p>Interface responsiva e amigável construída com HTML5 e CSS3, garantindo acessibilidade em qualquer dispositivo.</p>
                </div>
            </div>

            <div class="features-section">
                <h2>O que o sistema faz?</h2>
                <div class="feature-list">
                    <div class="feature-item">
                        <i class="fa-solid fa-store"></i>
                        <div class="feature-content">
                            <h4>Gestão de Produtos</h4>
                            <p>Apresentação de produtos organizados por categorias.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fa-solid fa-users"></i>
                        <div class="feature-content">
                            <h4>Gestão de Usuários</h4>
                            <p>Controle de cadastro de clientes e administradores com autenticação segura.</p>
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="fa-solid fa-gauge-high"></i>
                        <div class="feature-content">
                            <h4>Painel Administrativo</h4>
                            <p>Dashboard para gerenciamento centralizado das operações do sistema.</p>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="footer">
                <p><b>PetMais &copy; Elaborado por Diogo Baio.</b></p>
            </footer>

</body>

</html>