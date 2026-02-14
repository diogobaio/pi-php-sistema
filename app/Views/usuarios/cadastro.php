<?php
$isEdit = isset($usuario) && $usuario;
$pageTitle = $isEdit ? 'Editar Usuário' : 'Cadastro de Usuários';
$dadosForm = $_SESSION['dados_form'] ?? [];
unset($_SESSION['dados_form']);

// Se for edição, usa os dados do usuário, senão usa os dados do formulário anterior (em caso de erro)
$dados = $isEdit ? $usuario : $dadosForm;
?>

<div class="container">
    <div class="form-container">
        <h1><?= $pageTitle ?></h1>

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

        <form action="<?= $isEdit ? "/usuarios/{$usuario['id_usuario']}/atualizar" : '/usuarios/salvar' ?>" method="post">
            <!-- Nome e E-mail -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nome" class="form-label">Nome:</label>
                    <input type="text" class="form-control" id="nome" name="nome"
                        value="<?= htmlspecialchars($dados['nome'] ?? '') ?>" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">E-mail:</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="<?= htmlspecialchars($dados['email'] ?? '') ?>" required>
                </div>
            </div>

            <!-- CPF e Celular -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="cpf" class="form-label">CPF:</label>
                    <input type="text" class="form-control" id="cpf" name="cpf"
                        placeholder="000.000.000-00"
                        value="<?= htmlspecialchars($dados['cpf'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label for="celular" class="form-label">Celular:</label>
                    <input type="text" class="form-control" id="celular" name="celular"
                        placeholder="(00) 00000-0000"
                        value="<?= htmlspecialchars($dados['celular'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label for="dataNascimento" class="form-label">Data de Nascimento:</label>
                    <input type="date" class="form-control" id="dataNascimento" name="dataNascimento"
                        value="<?= $dados['data_nascimento'] ?? '' ?>">
                </div>
                <div class="col-md-3">
                    <label for="genero" class="form-label">Gênero:</label>
                    <select class="form-select" id="genero" name="genero">
                        <option value="">-- ESCOLHA --</option>
                        <option value="masculino" <?= ($dados['genero'] ?? '') === 'masculino' ? 'selected' : '' ?>>Masculino</option>
                        <option value="feminino" <?= ($dados['genero'] ?? '') === 'feminino' ? 'selected' : '' ?>>Feminino</option>
                        <option value="outro" <?= ($dados['genero'] ?? '') === 'outro' ? 'selected' : '' ?>>Outro</option>
                    </select>
                </div>
            </div>

            <!-- Endereço Completo -->
            <div class="row mb-3">
                <div class="col-md-2">
                    <label for="cep" class="form-label">CEP:</label>
                    <input type="text" class="form-control" id="cep" name="cep"
                        placeholder="00000-000"
                        value="<?= htmlspecialchars($dados['cep'] ?? '') ?>">
                </div>
                <div class="col-md-5">
                    <label for="endereco" class="form-label">Endereço:</label>
                    <input type="text" class="form-control" id="endereco" name="endereco"
                        value="<?= htmlspecialchars($dados['endereco'] ?? '') ?>">
                </div>
                <div class="col-md-2">
                    <label for="numero" class="form-label">Número:</label>
                    <input type="text" class="form-control" id="numero" name="numero"
                        value="<?= htmlspecialchars($dados['numero'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <label for="complemento" class="form-label">Complemento:</label>
                    <input type="text" class="form-control" id="complemento" name="complemento"
                        value="<?= htmlspecialchars($dados['complemento'] ?? '') ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="bairro" class="form-label">Bairro:</label>
                    <input type="text" class="form-control" id="bairro" name="bairro"
                        value="<?= htmlspecialchars($dados['bairro'] ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <label for="cidade" class="form-label">Cidade:</label>
                    <input type="text" class="form-control" id="cidade" name="cidade"
                        value="<?= htmlspecialchars($dados['cidade'] ?? '') ?>">
                </div>
                <div class="col-md-2">
                    <label for="estado" class="form-label">Estado:</label>
                    <select class="form-select" id="estado" name="estado">
                        <option value="">-- UF --</option>
                        <?php
                        $estados = ['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'];
                        foreach ($estados as $uf) {
                            $selected = ($dados['estado'] ?? '') === $uf ? 'selected' : '';
                            echo "<option value=\"$uf\" $selected>$uf</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="tipo" class="form-label">Tipo de Usuário:</label>
                    <select class="form-select" id="tipo" name="tipo" required>
                        <option value="">-- ESCOLHA --</option>
                        <option value="Administrador" <?= ($dados['tipo'] ?? '') === 'Administrador' ? 'selected' : '' ?>>Administrador</option>
                        <option value="Funcionário" <?= ($dados['tipo'] ?? '') === 'Funcionário' ? 'selected' : '' ?>>Funcionário</option>
                        <option value="Cliente" <?= ($dados['tipo'] ?? '') === 'Cliente' ? 'selected' : '' ?>>Cliente</option>
                    </select>
                </div>
            </div>

            <!-- Senha e Confirmar Senha -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="senha" class="form-label">Senha:</label>
                    <input type="password" class="form-control" id="senha" name="senha" <?= !$isEdit ? 'required' : '' ?>>
                    <?php if ($isEdit): ?>
                        <small class="text-muted">Deixe em branco para não alterar</small>
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <label for="confirmarSenha" class="form-label">Confirmar Senha:</label>
                    <input type="password" class="form-control" id="confirmarSenha" name="confirmarSenha">
                </div>
            </div>

            <div class="form-actions">
                <a href="/usuarios" class="btn btn-voltar">Voltar</a>
                <button type="reset" class="btn btn-limpar">Limpar</button>
                <button type="submit" class="btn btn-salvar">Salvar</button>
            </div>
        </form>
    </div>
</div>