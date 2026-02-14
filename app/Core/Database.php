<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    public static function conectar()
    {
        // Carrega as variáveis de ambiente do arquivo .env
        self::carregarEnv();

        // Busca as configurações do .env ou usa valores padrão
        $host = getenv('DB_HOST');
        $porta = getenv('DB_PORT');
        $banco = getenv('DB_DATABASE');
        $usuario = getenv('DB_USERNAME');
        $senha = getenv('DB_PASSWORD');

        $dsn = "mysql:host=$host;port=$porta;dbname=$banco;charset=utf8mb4";

        try {
            return new PDO($dsn, $usuario, $senha, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]);
        } catch (PDOException $e) {
            // Em produção, não exiba detalhes do erro
            if (getenv('APP_ENV') === 'production') {
                die("Erro na conexão com o banco de dados.");
            }
            die("Erro na conexão: " . $e->getMessage());
        }
    }

    /**
     * Carrega variáveis de ambiente do arquivo .env
     */
    private static function carregarEnv()
    {
        $envFile = __DIR__ . '/../../.env';

        if (!file_exists($envFile)) {
            return;
        }

        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            // Ignora comentários
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Processa linha no formato KEY=VALUE
            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value);

                // Remove aspas se existirem
                $value = trim($value, '"\'');

                // Define a variável de ambiente
                if (!getenv($name)) {
                    putenv("$name=$value");
                }
            }
        }
    }
}
