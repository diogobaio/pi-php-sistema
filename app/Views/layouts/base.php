<?php

use App\Models\Auth;

// Verifica se o usuário está logado
$usuarioLogado = Auth::getUsuarioLogado();
$isLogado = Auth::isLogado();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'PetMais - Pet Shop' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <?php if ($isLogado): ?>
        <!-- Navbar para usuários logados -->
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="/dashboard">Dashboard</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                Usuários
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/usuarios">Listagem de Usuários</a></li>
                                <?php if (Auth::temPermissao('Administrador')): ?>
                                    <li><a class="dropdown-item" href="/usuarios/novo">Cadastro de Usuários</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                Produtos
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/produtos">Listagem de Produtos</a></li>
                                <?php if (Auth::temPermissao(['Administrador', 'Funcionário'])): ?>
                                    <li><a class="dropdown-item" href="/produtos/novo">Cadastro de Produtos</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    </ul>
                    <div class="d-flex align-items-center">
                        <span class="text-white me-3">
                            Olá, <?= htmlspecialchars($usuarioLogado['nome']) ?>
                        </span>
                        <form class="d-flex me-3">
                            <input class="form-control search-input" type="search" placeholder="Procurar">
                        </form>
                        <a href="/logout" class="btn btn-sair">SAIR</a>
                    </div>
                </div>
            </div>
        </nav>
    <?php endif; ?>

    <!-- Conteúdo da página -->
    <main>
        <!-- Mensagens Flash -->
        <?php if (isset($_SESSION['mensagem'])): ?>
            <div class="container mt-3">
                <div class="alert alert-<?= $_SESSION['tipo_mensagem'] ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['mensagem'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
            <?php unset($_SESSION['mensagem'], $_SESSION['tipo_mensagem']); ?>
        <?php endif; ?>

        <?= $content ?>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <p>PetMais - Elaborado por Diogo Baio</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>