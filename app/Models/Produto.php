<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Produto
{

    // Busca todos os produtos ativos
    public static function all()
    {
        $pdo = Database::conectar();
        $sql = "SELECT * FROM produtos WHERE deleted_at IS NULL ORDER BY nome";
        return $pdo->query($sql)->fetchAll();
    }

    // Busca um produto pelo ID
    public static function find($id)
    {
        $pdo = Database::conectar();
        $sql = "SELECT * FROM produtos WHERE id_produto = :id AND deleted_at IS NULL";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Insere um novo produto
    public static function create($dados)
    {
        $pdo = Database::conectar();

        $sql = "INSERT INTO produtos (
            nome, descricao, quantidade, valor_unitario, categoria
        ) VALUES (
            :nome, :descricao, :quantidade, :valor_unitario, :categoria
        )";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $dados['descricao'], PDO::PARAM_STR);
        $stmt->bindParam(':quantidade', $dados['quantidade'], PDO::PARAM_INT);
        $stmt->bindParam(':valor_unitario', $dados['valorUnitario']);
        $stmt->bindParam(':categoria', $dados['categoria'], PDO::PARAM_STR);

        return $stmt->execute();
    }

    // Atualiza um produto existente
    public static function update($id, $dados)
    {
        $pdo = Database::conectar();

        $sql = "UPDATE produtos SET
            nome = :nome,
            descricao = :descricao,
            quantidade = :quantidade,
            valor_unitario = :valor_unitario,
            categoria = :categoria,
            updated_at = CURRENT_TIMESTAMP
            WHERE id_produto = :id";

        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
        $stmt->bindParam(':descricao', $dados['descricao'], PDO::PARAM_STR);
        $stmt->bindParam(':quantidade', $dados['quantidade'], PDO::PARAM_INT);
        $stmt->bindParam(':valor_unitario', $dados['valorUnitario']);
        $stmt->bindParam(':categoria', $dados['categoria'], PDO::PARAM_STR);

        return $stmt->execute();
    }

    // Exclusão lógica (soft delete)
    public static function delete($id)
    {
        $pdo = Database::conectar();
        $sql = "UPDATE produtos SET deleted_at = CURRENT_TIMESTAMP WHERE id_produto = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
