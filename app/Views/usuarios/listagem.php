<div class="container">
    <div class="list-container">
        <div class="list-header">
            <h1>Listagem de Usuários</h1>
            <?php if (App\Models\Auth::temPermissao('Administrador')): ?>
                <a href="/usuarios/novo" class="btn btn-adicionar">ADICIONAR</a>
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

        <!-- Tabela de usuários - 4 CAMPOS IMPORTANTES -->
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NOME</th>
                    <th>EMAIL</th>
                    <th>TIPO</th>
                    <th>AÇÕES</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($usuarios)): ?>
                    <tr>
                        <td colspan="5" class="text-center">Nenhum usuário encontrado</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= $usuario['id_usuario'] ?></td>
                            <td><?= htmlspecialchars($usuario['nome']) ?></td>
                            <td><?= htmlspecialchars($usuario['email']) ?></td>
                            <td><?= htmlspecialchars($usuario['tipo']) ?></td>
                            <td>
                                <?php if (App\Models\Auth::temPermissao('Administrador')): ?>
                                    <a href="/usuarios/<?= $usuario['id_usuario'] ?>/editar" class="btn btn-sm btn-editar">Editar</a>
                                    <a href="/usuarios/<?= $usuario['id_usuario'] ?>/excluir"
                                        class="btn btn-sm btn-excluir"
                                        onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Excluir</a>
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
                        <a class="page-link" href="/usuarios?pagina=<?= $paginaAtual - 1 ?>">Anterior</a>
                    </li>

                    <!-- Números das páginas -->
                    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                        <li class="page-item <?= $i == $paginaAtual ? 'active' : '' ?>">
                            <a class="page-link" href="/usuarios?pagina=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <!-- Botão Próximo -->
                    <li class="page-item <?= $paginaAtual == $totalPaginas ? 'disabled' : '' ?>">
                        <a class="page-link" href="/usuarios?pagina=<?= $paginaAtual + 1 ?>">Próximo</a>
                    </li>
                </ul>
            </nav>

            <div class="text-center text-muted">
                Página <?= $paginaAtual ?> de <?= $totalPaginas ?> (<?= $totalItens ?> <?= $totalItens == 1 ? 'usuário' : 'usuários' ?>)
            </div>
        <?php endif; ?>
    </div>
</div>