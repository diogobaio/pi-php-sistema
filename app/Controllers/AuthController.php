<?php

namespace App\Controllers;

use App\Models\Auth;

class AuthController
{

    // Exibe a página de login
    public function showLogin()
    {
        // Se já estiver logado, redireciona para o dashboard
        if (Auth::isLogado()) {
            header('Location: /dashboard');
            exit;
        }

        render_sem_login('auth/login.php', ['title' => 'Login - PetMais']);
    }

    // Processa o formulário de login
    public function login()
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $senha = $_POST['senha'] ?? '';

        // Valida os campos
        $erros = [];
        if (empty($email)) {
            $erros[] = 'O e-mail é obrigatório';
        }
        if (empty($senha)) {
            $erros[] = 'A senha é obrigatória';
        }

        if (empty($erros)) {
            // Tenta fazer login
            if (Auth::login($email, $senha)) {
                // Login bem-sucedido, redireciona para o dashboard
                $_SESSION['mensagem'] = 'Login realizado com sucesso!';
                $_SESSION['tipo_mensagem'] = 'success';
                header('Location: /dashboard');
                exit;
            } else {
                $erros[] = 'E-mail ou senha incorretos';
            }
        }

        // Se chegou aqui, houve erros
        $_SESSION['erros'] = $erros;
        $_SESSION['email'] = $email; // Para preencher o campo de e-mail

        header('Location: /login');
        exit;
    }

    // Faz logout do sistema
    public function logout()
    {
        Auth::logout();
        $_SESSION['mensagem'] = 'Logout realizado com sucesso!';
        $_SESSION['tipo_mensagem'] = 'success';
        header('Location: /login');
        exit;
    }
}
