<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Auth
{

    // Inicia a sessão se não estiver iniciada
    private static function iniciarSessao()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Verifica credenciais e realiza login
    public static function login($email, $senha)
    {
        self::iniciarSessao();

        $pdo = Database::conectar();
        $sql = "SELECT id_usuario, nome, email, senha, tipo FROM usuarios WHERE email = :email AND deleted_at IS NULL";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $usuario = $stmt->fetch();

        // Verifica se encontrou o usuário e se a senha está correta
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario_id'] = $usuario['id_usuario'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['usuario_email'] = $usuario['email'];
            $_SESSION['usuario_tipo'] = $usuario['tipo'];
            $_SESSION['logado'] = true;
            return true;
        }

        return false;
    }

    // Verifica se está logado
    public static function isLogado()
    {
        self::iniciarSessao();
        return isset($_SESSION['logado']) && $_SESSION['logado'] === true;
    }

    // Verifica se o usuário tem o tipo especificado
    public static function temPermissao($tipo)
    {
        self::iniciarSessao();
        if (!self::isLogado()) {
            return false;
        }

        // Administradores têm acesso total
        if ($_SESSION['usuario_tipo'] === 'Administrador' || $_SESSION['usuario_tipo'] === 'admin') {
            return true;
        }

        if (is_array($tipo)) {
            return in_array($_SESSION['usuario_tipo'], $tipo);
        }

        return $_SESSION['usuario_tipo'] === $tipo;
    }

    // Faz logout do usuário
    public static function logout()
    {
        self::iniciarSessao();
        $_SESSION = array();
        session_destroy();
    }

    // Recupera os dados do usuário logado
    public static function getUsuarioLogado()
    {
        self::iniciarSessao();
        if (!self::isLogado()) {
            return null;
        }

        return [
            'id' => $_SESSION['usuario_id'],
            'nome' => $_SESSION['usuario_nome'],
            'email' => $_SESSION['usuario_email'],
            'tipo' => $_SESSION['usuario_tipo']
        ];
    }

    // Redireciona para login se não estiver logado
    public static function requerLogin()
    {
        if (!self::isLogado()) {
            header('Location: /login');
            exit;
        }
    }

    // Redireciona se não tiver permissão
    public static function requerPermissao($tipo)
    {
        self::requerLogin();

        if (!self::temPermissao($tipo)) {
            $_SESSION['mensagem'] = 'Você não tem permissão para acessar esta página';
            $_SESSION['tipo_mensagem'] = 'danger';
            header('Location: /dashboard');
            exit;
        }
    }
}
