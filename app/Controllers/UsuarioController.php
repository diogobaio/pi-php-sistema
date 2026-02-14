<?php

namespace App\Controllers;

use App\Models\Usuario;
use App\Models\Auth;

class UsuarioController
{

    // Lista todos os usuários
    public function index()
    {
        Auth::requerPermissao(['admin', 'funcionario']);

        $usuarios = Usuario::all();

        // Paginação
        $itensPorPagina = 10;
        $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $totalItens = count($usuarios);
        $totalPaginas = ceil($totalItens / $itensPorPagina);

        // Garante que a página está no intervalo válido
        if ($paginaAtual < 1) $paginaAtual = 1;
        if ($paginaAtual > $totalPaginas && $totalPaginas > 0) $paginaAtual = $totalPaginas;

        $inicio = ($paginaAtual - 1) * $itensPorPagina;
        $usuariosPagina = array_slice($usuarios, $inicio, $itensPorPagina);

        render('usuarios/listagem.php', [
            'title' => 'Listagem de Usuários - PetMais',
            'usuarios' => $usuariosPagina,
            'paginaAtual' => $paginaAtual,
            'totalPaginas' => $totalPaginas,
            'totalItens' => $totalItens
        ]);
    }

    // Exibe formulário de novo usuário
    public function create()
    {
        Auth::requerPermissao('admin');
        render('usuarios/cadastro.php', ['title' => 'Novo Usuário - PetMais']);
    }

    // Salva novo usuário
    public function store()
    {
        Auth::requerPermissao('admin');

        // Validações básicas
        $erros = [];

        if (empty($_POST['nome'])) {
            $erros[] = 'Nome é obrigatório';
        }

        if (empty($_POST['email'])) {
            $erros[] = 'Email é obrigatório';
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $erros[] = 'Email inválido';
        } elseif (Usuario::findByEmail($_POST['email'])) {
            $erros[] = 'Email já cadastrado';
        }

        if (empty($_POST['senha'])) {
            $erros[] = 'Senha é obrigatória';
        } elseif (strlen($_POST['senha']) < 6) {
            $erros[] = 'Senha deve ter no mínimo 6 caracteres';
        }

        if (!empty($_POST['confirmarSenha']) && $_POST['senha'] !== $_POST['confirmarSenha']) {
            $erros[] = 'As senhas não conferem';
        }

        if (!empty($erros)) {
            $_SESSION['erros'] = $erros;
            $_SESSION['dados_form'] = $_POST;
            header('Location: /usuarios/novo');
            exit;
        }

        if (Usuario::create($_POST)) {
            $_SESSION['mensagem'] = 'Usuário cadastrado com sucesso!';
            $_SESSION['tipo_mensagem'] = 'success';
            header('Location: /usuarios');
        } else {
            $_SESSION['erros'] = ['Erro ao cadastrar usuário'];
            $_SESSION['dados_form'] = $_POST;
            header('Location: /usuarios/novo');
        }
        exit;
    }

    // Exibe formulário de edição
    public function edit($id)
    {
        Auth::requerPermissao('admin');

        $usuario = Usuario::find($id);

        if (!$usuario) {
            $_SESSION['mensagem'] = 'Usuário não encontrado';
            $_SESSION['tipo_mensagem'] = 'danger';
            header('Location: /usuarios');
            exit;
        }

        render('usuarios/cadastro.php', [
            'title' => 'Editar Usuário - PetMais',
            'usuario' => $usuario
        ]);
    }

    // Atualiza usuário existente
    public function update($id)
    {
        Auth::requerPermissao('admin');

        $usuario = Usuario::find($id);

        if (!$usuario) {
            $_SESSION['mensagem'] = 'Usuário não encontrado';
            $_SESSION['tipo_mensagem'] = 'danger';
            header('Location: /usuarios');
            exit;
        }

        // Validações
        $erros = [];

        if (empty($_POST['nome'])) {
            $erros[] = 'Nome é obrigatório';
        }

        if (empty($_POST['email'])) {
            $erros[] = 'Email é obrigatório';
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $erros[] = 'Email inválido';
        } else {
            $usuarioEmail = Usuario::findByEmail($_POST['email']);
            if ($usuarioEmail && $usuarioEmail['id_usuario'] != $id) {
                $erros[] = 'Email já cadastrado para outro usuário';
            }
        }

        if (!empty($_POST['senha'])) {
            if (strlen($_POST['senha']) < 6) {
                $erros[] = 'Senha deve ter no mínimo 6 caracteres';
            }
            if (!empty($_POST['confirmarSenha']) && $_POST['senha'] !== $_POST['confirmarSenha']) {
                $erros[] = 'As senhas não conferem';
            }
        }

        if (!empty($erros)) {
            $_SESSION['erros'] = $erros;
            $_SESSION['dados_form'] = $_POST;
            header("Location: /usuarios/{$id}/editar");
            exit;
        }

        if (Usuario::update($id, $_POST)) {
            $_SESSION['mensagem'] = 'Usuário atualizado com sucesso!';
            $_SESSION['tipo_mensagem'] = 'success';
            header('Location: /usuarios');
        } else {
            $_SESSION['erros'] = ['Erro ao atualizar usuário'];
            $_SESSION['dados_form'] = $_POST;
            header("Location: /usuarios/{$id}/editar");
        }
        exit;
    }

    // Exclui usuário (soft delete)
    public function delete($id)
    {
        Auth::requerPermissao('admin');

        $usuario = Usuario::find($id);

        if (!$usuario) {
            $_SESSION['mensagem'] = 'Usuário não encontrado';
            $_SESSION['tipo_mensagem'] = 'danger';
            header('Location: /usuarios');
            exit;
        }

        if (Usuario::delete($id)) {
            $_SESSION['mensagem'] = 'Usuário excluído com sucesso!';
            $_SESSION['tipo_mensagem'] = 'success';
        } else {
            $_SESSION['mensagem'] = 'Erro ao excluir usuário';
            $_SESSION['tipo_mensagem'] = 'danger';
        }

        header('Location: /usuarios');
        exit;
    }
}
