<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Usuario
{

    // Busca todos os usuários ativos
    public static function all()
    {
        $pdo = Database::conectar();
        $sql = "SELECT * FROM usuarios WHERE deleted_at IS NULL ORDER BY nome";
        return $pdo->query($sql)->fetchAll();
    }

    // Busca um usuário pelo ID
    public static function find($id)
    {
        $pdo = Database::conectar();
        $sql = "SELECT * FROM usuarios WHERE id_usuario = :id AND deleted_at IS NULL";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Busca um usuário pelo email
    public static function findByEmail($email)
    {
        $pdo = Database::conectar();
        $sql = "SELECT * FROM usuarios WHERE email = :email AND deleted_at IS NULL";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Insere um novo usuário
    public static function create($dados)
    {
        $pdo = Database::conectar();

        // Criptografa a senha
        $senha_hash = password_hash($dados['senha'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO usuarios (
            nome, email, cpf, celular, data_nascimento, genero,
            endereco, numero, complemento, bairro, cidade, cep, estado,
            senha, tipo
        ) VALUES (
            :nome, :email, :cpf, :celular, :data_nascimento, :genero,
            :endereco, :numero, :complemento, :bairro, :cidade, :cep, :estado,
            :senha, :tipo
        )";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $dados['email'], PDO::PARAM_STR);
        $stmt->bindParam(':cpf', $dados['cpf'], PDO::PARAM_STR);
        $stmt->bindParam(':celular', $dados['celular'], PDO::PARAM_STR);
        $stmt->bindParam(':data_nascimento', $dados['data_nascimento']);
        $stmt->bindParam(':genero', $dados['genero'], PDO::PARAM_STR);
        $stmt->bindParam(':endereco', $dados['endereco'], PDO::PARAM_STR);
        $stmt->bindParam(':numero', $dados['numero'], PDO::PARAM_STR);
        $stmt->bindParam(':complemento', $dados['complemento'], PDO::PARAM_STR);
        $stmt->bindParam(':bairro', $dados['bairro'], PDO::PARAM_STR);
        $stmt->bindParam(':cidade', $dados['cidade'], PDO::PARAM_STR);
        $stmt->bindParam(':cep', $dados['cep'], PDO::PARAM_STR);
        $stmt->bindParam(':estado', $dados['estado'], PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha_hash, PDO::PARAM_STR);
        $stmt->bindParam(':tipo', $dados['tipo'], PDO::PARAM_STR);

        return $stmt->execute();
    }

    // Atualiza um usuário existente
    public static function update($id, $dados)
    {
        $pdo = Database::conectar();

        // Verifica se a senha foi fornecida para atualização
        if (!empty($dados['senha'])) {
            $sql = "UPDATE usuarios SET
                nome = :nome, email = :email, cpf = :cpf, celular = :celular,
                data_nascimento = :data_nascimento, genero = :genero,
                endereco = :endereco, numero = :numero, complemento = :complemento,
                bairro = :bairro, cidade = :cidade, cep = :cep, estado = :estado,
                senha = :senha, tipo = :tipo,
                updated_at = CURRENT_TIMESTAMP
                WHERE id_usuario = :id";

            $senha_hash = password_hash($dados['senha'], PASSWORD_DEFAULT);
        } else {
            $sql = "UPDATE usuarios SET
                nome = :nome, email = :email, cpf = :cpf, celular = :celular,
                data_nascimento = :data_nascimento, genero = :genero,
                endereco = :endereco, numero = :numero, complemento = :complemento,
                bairro = :bairro, cidade = :cidade, cep = :cep, estado = :estado,
                tipo = :tipo,
                updated_at = CURRENT_TIMESTAMP
                WHERE id_usuario = :id";
        }

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $dados['email'], PDO::PARAM_STR);
        $stmt->bindParam(':cpf', $dados['cpf'], PDO::PARAM_STR);
        $stmt->bindParam(':celular', $dados['celular'], PDO::PARAM_STR);
        $stmt->bindParam(':data_nascimento', $dados['data_nascimento']);
        $stmt->bindParam(':genero', $dados['genero'], PDO::PARAM_STR);
        $stmt->bindParam(':endereco', $dados['endereco'], PDO::PARAM_STR);
        $stmt->bindParam(':numero', $dados['numero'], PDO::PARAM_STR);
        $stmt->bindParam(':complemento', $dados['complemento'], PDO::PARAM_STR);
        $stmt->bindParam(':bairro', $dados['bairro'], PDO::PARAM_STR);
        $stmt->bindParam(':cidade', $dados['cidade'], PDO::PARAM_STR);
        $stmt->bindParam(':cep', $dados['cep'], PDO::PARAM_STR);
        $stmt->bindParam(':estado', $dados['estado'], PDO::PARAM_STR);
        $stmt->bindParam(':tipo', $dados['tipo'], PDO::PARAM_STR);

        if (!empty($dados['senha'])) {
            $stmt->bindParam(':senha', $senha_hash, PDO::PARAM_STR);
        }

        return $stmt->execute();
    }

    // Exclusão lógica (soft delete)
    public static function delete($id)
    {
        $pdo = Database::conectar();
        $sql = "UPDATE usuarios SET deleted_at = CURRENT_TIMESTAMP WHERE id_usuario = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
