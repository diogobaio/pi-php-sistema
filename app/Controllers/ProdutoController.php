<?php

namespace App\Controllers;

use App\Models\Produto;
use App\Models\Auth;

class ProdutoController
{

    // Lista todos os produtos
    public function index()
    {
        Auth::requerLogin();

        $produtos = Produto::all();

        // Paginação
        $itensPorPagina = 10;
        $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $totalItens = count($produtos);
        $totalPaginas = ceil($totalItens / $itensPorPagina);

        // Garante que a página está no intervalo válido
        if ($paginaAtual < 1) $paginaAtual = 1;
        if ($paginaAtual > $totalPaginas && $totalPaginas > 0) $paginaAtual = $totalPaginas;

        $inicio = ($paginaAtual - 1) * $itensPorPagina;
        $produtosPagina = array_slice($produtos, $inicio, $itensPorPagina);

        render('produtos/listagem.php', [
            'title' => 'Listagem de Produtos - PetMais',
            'produtos' => $produtosPagina,
            'paginaAtual' => $paginaAtual,
            'totalPaginas' => $totalPaginas,
            'totalItens' => $totalItens
        ]);
    }

    // Exibe formulário de novo produto
    public function create()
    {
        Auth::requerPermissao(['admin', 'funcionario']);
        render('produtos/cadastro.php', ['title' => 'Novo Produto - PetMais']);
    }

    // Salva novo produto
    public function store()
    {
        Auth::requerPermissao(['admin', 'funcionario']);

        // Validações básicas
        $erros = [];

        if (empty($_POST['nome'])) {
            $erros[] = 'Nome é obrigatório';
        }

        if (!isset($_POST['quantidade']) || $_POST['quantidade'] < 0) {
            $erros[] = 'Quantidade deve ser maior ou igual a zero';
        }

        if (!isset($_POST['valorUnitario']) || $_POST['valorUnitario'] < 0) {
            $erros[] = 'Valor unitário deve ser maior ou igual a zero';
        }

        if (empty($_POST['categoria'])) {
            $erros[] = 'Categoria é obrigatória';
        }

        if (!empty($erros)) {
            $_SESSION['erros'] = $erros;
            $_SESSION['dados_form'] = $_POST;
            header('Location: /produtos/novo');
            exit;
        }

        if (Produto::create($_POST)) {
            $_SESSION['mensagem'] = 'Produto cadastrado com sucesso!';
            $_SESSION['tipo_mensagem'] = 'success';
            header('Location: /produtos');
        } else {
            $_SESSION['erros'] = ['Erro ao cadastrar produto'];
            $_SESSION['dados_form'] = $_POST;
            header('Location: /produtos/novo');
        }
        exit;
    }

    // Exibe formulário de edição
    public function edit($id)
    {
        Auth::requerPermissao(['admin', 'funcionario']);

        $produto = Produto::find($id);

        if (!$produto) {
            $_SESSION['mensagem'] = 'Produto não encontrado';
            $_SESSION['tipo_mensagem'] = 'danger';
            header('Location: /produtos');
            exit;
        }

        render('produtos/cadastro.php', [
            'title' => 'Editar Produto - PetMais',
            'produto' => $produto
        ]);
    }

    // Atualiza produto existente
    public function update($id)
    {
        Auth::requerPermissao(['admin', 'funcionario']);

        $produto = Produto::find($id);

        if (!$produto) {
            $_SESSION['mensagem'] = 'Produto não encontrado';
            $_SESSION['tipo_mensagem'] = 'danger';
            header('Location: /produtos');
            exit;
        }

        // Validações
        $erros = [];

        if (empty($_POST['nome'])) {
            $erros[] = 'Nome é obrigatório';
        }

        if (!isset($_POST['quantidade']) || $_POST['quantidade'] < 0) {
            $erros[] = 'Quantidade deve ser maior ou igual a zero';
        }

        if (!isset($_POST['valorUnitario']) || $_POST['valorUnitario'] < 0) {
            $erros[] = 'Valor unitário deve ser maior ou igual a zero';
        }

        if (empty($_POST['categoria'])) {
            $erros[] = 'Categoria é obrigatória';
        }

        if (!empty($erros)) {
            $_SESSION['erros'] = $erros;
            $_SESSION['dados_form'] = $_POST;
            header("Location: /produtos/{$id}/editar");
            exit;
        }

        if (Produto::update($id, $_POST)) {
            $_SESSION['mensagem'] = 'Produto atualizado com sucesso!';
            $_SESSION['tipo_mensagem'] = 'success';
            header('Location: /produtos');
        } else {
            $_SESSION['erros'] = ['Erro ao atualizar produto'];
            $_SESSION['dados_form'] = $_POST;
            header("Location: /produtos/{$id}/editar");
        }
        exit;
    }

    // Exclui produto (soft delete)
    public function delete($id)
    {
        Auth::requerPermissao(['admin', 'funcionario']);

        $produto = Produto::find($id);

        if (!$produto) {
            $_SESSION['mensagem'] = 'Produto não encontrado';
            $_SESSION['tipo_mensagem'] = 'danger';
            header('Location: /produtos');
            exit;
        }

        if (Produto::delete($id)) {
            $_SESSION['mensagem'] = 'Produto excluído com sucesso!';
            $_SESSION['tipo_mensagem'] = 'success';
        } else {
            $_SESSION['mensagem'] = 'Erro ao excluir produto';
            $_SESSION['tipo_mensagem'] = 'danger';
        }

        header('Location: /produtos');
        exit;
    }
}
