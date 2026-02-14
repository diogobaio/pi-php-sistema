<div class="container">
    <div class="list-container">
        <div class="list-header">
            <h1>Listagem de Produtos</h1>
            <?php if (App\Models\Auth::temPermissao(['admin', 'funcionario'])): ?>
                <a href="/produtos/novo" class="btn btn-adicionar">ADICIONAR</a>
            <?php endif; ?>
        </div>

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

        <!-- Tabela de produtos - 4 CAMPOS IMPORTANTES -->
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NOME</th>
                    <th>CATEGORIA</th>
                    <th>QUANTIDADE</th>
                    <th>VALOR UNITÁRIO</th>
                    <th>AÇÕES</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($produtos)): ?>
                    <tr>
                        <td colspan="6" class="text-center">Nenhum produto encontrado</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($produtos as $produto): ?>
                        <tr>
                            <td><?= $produto['id_produto'] ?></td>
                            <td><?= htmlspecialchars($produto['nome']) ?></td>
                            <td><?= htmlspecialchars($produto['categoria']) ?></td>
                            <td><?= $produto['quantidade'] ?></td>
                            <td>R$ <?= number_format($produto['valor_unitario'], 2, ',', '.') ?></td>
                            <td>
                                <?php if (App\Models\Auth::temPermissao(['admin', 'funcionario'])): ?>
                                    <a href="/produtos/<?= $produto['id_produto'] ?>/editar" class="btn btn-sm btn-editar">Editar</a>
                                    <a href="/produtos/<?= $produto['id_produto'] ?>/excluir"
                                        class="btn btn-sm btn-excluir"
                                        onclick="return confirm('Tem certeza que deseja excluir este produto?')">Excluir</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Paginação -->
        <?php if ($totalPaginas > 1): ?>
            <nav aria-label="Navegação de páginas">
                <ul class="pagination justify-content-center">
                    <!-- Botão Anterior -->
                    <li class="page-item <?= $paginaAtual == 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="/produtos?pagina=<?= $paginaAtual - 1 ?>">Anterior</a>
                    </li>

                    <!-- Números das páginas -->
                    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                        <li class="page-item <?= $i == $paginaAtual ? 'active' : '' ?>">
                            <a class="page-link" href="/produtos?pagina=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <!-- Botão Próximo -->
                    <li class="page-item <?= $paginaAtual == $totalPaginas ? 'disabled' : '' ?>">
                        <a class="page-link" href="/produtos?pagina=<?= $paginaAtual + 1 ?>">Próximo</a>
                    </li>
                </ul>
            </nav>

            <div class="text-center text-muted">
                Página <?= $paginaAtual ?> de <?= $totalPaginas ?> (<?= $totalItens ?> <?= $totalItens == 1 ? 'produto' : 'produtos' ?>)
            </div>
        <?php endif; ?>
    </div>
</div>