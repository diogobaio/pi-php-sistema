-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS petmais CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE petmais;

-- Tabela de Usuários
CREATE TABLE IF NOT EXISTS usuarios (
    id_usuario BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    cpf VARCHAR(14),
    celular VARCHAR(20),
    data_nascimento DATE,
    genero ENUM('masculino', 'feminino', 'outro'),
    endereco VARCHAR(255),
    numero VARCHAR(10),
    complemento VARCHAR(100),
    bairro VARCHAR(100),
    cidade VARCHAR(100),
    cep VARCHAR(10),
    estado CHAR(2),
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('Administrador', 'Funcionário', 'Cliente') NOT NULL DEFAULT 'Cliente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL
);

-- Tabela de Produtos
CREATE TABLE IF NOT EXISTS produtos (
    id_produto BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    quantidade INT UNSIGNED NOT NULL DEFAULT 0,
    valor_unitario DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    categoria VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL DEFAULT NULL
);