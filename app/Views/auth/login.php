<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PetMais</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>

<body class="login-page">
    <div class="container">
        <div class="login-card">
            <div class="header">
                <img src="img/logo.png" alt="Logo PetMais" class="logo">
            </div>
            <div class="login-form">
                <h2>Login</h2>

                <?php if (isset($_SESSION['mensagem'])): ?>
                    <div class="alert alert-<?= $_SESSION['tipo_mensagem'] ?> alert-dismissible fade show" role="alert">
                        <?= $_SESSION['mensagem'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['mensagem'], $_SESSION['tipo_mensagem']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['erros'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            <?php foreach ($_SESSION['erros'] as $erro): ?>
                                <li><?= htmlspecialchars($erro) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['erros']); ?>
                <?php endif; ?>

                <form action="/login/processar" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail:</label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="<?= isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : '' ?>"
                            placeholder="Digite seu e-mail" required>
                        <?php unset($_SESSION['email']); ?>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha:</label>
                        <input type="password" class="form-control" id="password" name="senha"
                            placeholder="Digite sua senha" required>
                    </div>
                    <button type="submit" class="btn btn-entrar w-100">Entrar</button>
                    <a href="#" class="link-recuperar">Recuperar Senha</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>