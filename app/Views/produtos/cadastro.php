<?php
$isEdit = isset($produto) && $produto;
$pageTitle = $isEdit ? 'Editar Produto' : 'Cadastro de Produtos';
$dadosForm = $_SESSION['dados_form'] ?? [];
unset($_SESSION['dados_form']);

// Se for edição, usa os dados do produto, senão usa os dados do formulário anterior (em caso de erro)
$dados = $isEdit ? $produto : $dadosForm;
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

        <form action="<?= $isEdit ? "/produtos/{$produto['id_produto']}/atualizar" : '/produtos/salvar' ?>" method="post">
            <!-- Nome -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="nome" class="form-label">Nome:</label>
                    <input type="text" class="form-control" id="nome" name="nome"
                        value="<?= htmlspecialchars($dados['nome'] ?? '') ?>" required>
                </div>
            </div>

            <!-- Descrição -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="descricao" class="form-label">Descrição:</label>
                    <textarea class="form-control" id="descricao" name="descricao" rows="4"><?= htmlspecialchars($dados['descricao'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- Quantidade, Valor Unitário e Categoria -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="quantidade" class="form-label">Quantidade:</label>
                    <input type="number" class="form-control" id="quantidade" name="quantidade"
                        min="0" value="<?= $dados['quantidade'] ?? '0' ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="valorUnitario" class="form-label">Valor Unitário (R$):</label>
                    <input type="number" class="form-control" id="valorUnitario" name="valorUnitario"
                        step="0.01" min="0" placeholder="0.00"
                        value="<?= $dados['valor_unitario'] ?? '' ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="categoria" class="form-label">Categoria:</label>
                    <select class="form-select" id="categoria" name="categoria" required>
                        <option value="">-- ESCOLHA --</option>
                        <option value="Ração" <?= ($dados['categoria'] ?? '') === 'Ração' ? 'selected' : '' ?>>Ração</option>
                        <option value="Petiscos" <?= ($dados['categoria'] ?? '') === 'Petiscos' ? 'selected' : '' ?>>Petiscos</option>
                        <option value="Brinquedos" <?= ($dados['categoria'] ?? '') === 'Brinquedos' ? 'selected' : '' ?>>Brinquedos</option>
                        <option value="Higiene" <?= ($dados['categoria'] ?? '') === 'Higiene' ? 'selected' : '' ?>>Higiene</option>
                        <option value="Acessórios" <?= ($dados['categoria'] ?? '') === 'Acessórios' ? 'selected' : '' ?>>Acessórios</option>
                        <option value="Medicamentos" <?= ($dados['categoria'] ?? '') === 'Medicamentos' ? 'selected' : '' ?>>Medicamentos</option>
                        <option value="Cama e Transporte" <?= ($dados['categoria'] ?? '') === 'Cama e Transporte' ? 'selected' : '' ?>>Cama e Transporte</option>
                        <option value="Coleiras e Guias" <?= ($dados['categoria'] ?? '') === 'Coleiras e Guias' ? 'selected' : '' ?>>Coleiras e Guias</option>
                        <option value="Comedouros e Bebedouros" <?= ($dados['categoria'] ?? '') === 'Comedouros e Bebedouros' ? 'selected' : '' ?>>Comedouros e Bebedouros</option>
                        <option value="Outros" <?= ($dados['categoria'] ?? '') === 'Outros' ? 'selected' : '' ?>>Outros</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <a href="/produtos" class="btn btn-voltar">Voltar</a>
                <button type="reset" class="btn btn-limpar">Limpar</button>
                <button type="submit" class="btn btn-salvar">Salvar</button>
            </div>
        </form>
    </div>
</div>