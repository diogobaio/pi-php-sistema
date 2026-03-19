# 🐾 Sistema Petshop

Este é um sistema parcial de gerenciamento para Petshop desenvolvido em PHP utilizando a arquitetura MVC (Model-View-Controller) que simula o controle de usuários, produtos e autenticação.

## 🚀 Funcionalidades

- **Autenticação Segura**: Sistema de login com hash de senhas e controle de permissões (admin, funcionário).
- **Gestão de Usuários**: Cadastro, edição, listagem e exclusão lógica (soft delete) de usuários.
- **Gestão de Produtos**: Cadastro, edição, visualização e paginação de produtos disponíveis no petshop.
- **Controle de Acesso**: Restrição de rotas baseada no nível de permissão do usuário para proteção das páginas.

## 🏗️ Arquitetura do Sistema

### Classes Principais

#### 1. **Controllers (Ex: ProdutoController, UsuarioController, AuthController)**

Gerenciam a lógica de requisição e resposta do usuário:

- Processam dados recebidos dos formulários.
- Interagem com a camada Model.
- Renderizam as Views apropriadas com os dados processados.
- Realizam paginação e validações de estado de Sessão.

#### 2. **Models (Ex: Produto, Usuario, Auth)**

Lidam com a persistência de dados e as regras de negócio centralizadas:

- Operações de CRUD (Create, Read, Update, Delete).
- Conexão segura com o banco de dados via PDO.
- Consultas com parâmetros vinculados (`bindParam`) para evitar SQL Injection.
- Implementação de exclusão lógica por meio de datas de deleção (`deleted_at`).

#### 3. **Core / Router (Public)**

Responsáveis pela infraestrutura do sistema:

- Ponto de entrada centralizado (`index.php`).
- Autoloading de classes com padrão PSR-4 registrado via Composer.
- Roteamento robusto mapeando URLs diretamente para seus Controllers e métodos específicos.

## 💡 Lógica de Programação PHP Utilizada

### 1. **Programação Orientada a Objetos e Padrão MVC**

Separação clara das responsabilidades, garantindo organização lógica superior, facilitando a manutenção e a escalabilidade.

### 2. **Namespaces e Autoloading (PSR-4)**

```php
# Organização hierárquica usando diretórios virtuais
namespace App\Controllers;
use App\Models\Produto;
```

### 3. **PDO (PHP Data Objects) e Prepared Statements**

```php
# Prevenção à Injeção de SQL nas consultas de Model
$sql = "SELECT * FROM usuarios WHERE id_usuario = :id AND deleted_at IS NULL";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
```

### 4. **Segurança e Hashes de Senhas**

```php
# Criptografia nativa em hash irrecuperável
$senha_hash = password_hash($dados['senha'], PASSWORD_DEFAULT);
```

### 5. **Gerenciamento de Sessão e Controle de Acesso Baseado em Níveis**

```php
# Requerimento rigoroso de funções antes de acessar as rotas
Auth::requerPermissao(['admin', 'funcionario']);
$_SESSION['mensagem'] = 'Produto cadastrado com sucesso!';
```

## 🛠️ Tecnologias Utilizadas

- **PHP**
- **PDO** para comunicação abstraída com o Banco de Dados.
- **Composer** para gerenciamento de informações do projeto e Autoloading.
- **Padrão Arquitetural MVC**.

## 📋 Pré-requisitos

- PHP instalado localmente na máquina.
- Composer instalado no sistema.
- Um banco de dados relacional configurado e acessível.

## 🚀 Como Executar

1. Clone ou copie o código para o seu ambiente local de desenvolvimento.
2. Na pasta raiz do projeto, caso acabe de clonar o sistema em um PC novo, instale suas dependências:

```bash
composer install
```

*(Nota: se ao acessar gerar `Erro de Rota (404)`, experimente forçar a atualização da árvore de arquivos executando `composer dump-autoload`)*

3. Inicie o servidor embutido do PHP apontando para o diretório de entrada estático (`public`):

```bash
php -S localhost:8000 -t public
```

4. Acesse o sistema pelo navegador na URL base informada no terminal (`http://localhost:8000`).

## 🎯 Pontos de Destaque

1. **Segurança Prática**: Proteção nativa de senhas e uso extenso de Prepared Statements.
2. **Soft Delete**: Usuários não são removidos permanentemente para segurança dos logs do ERP, mas escondidos através das propriedades `deleted_at`.
3. **Paginação de UI Integrada**: A lógica desenvolvida sob medida em Controllers de Listagem (ex `ProdutoController`) impede exaustão da RAM e tela nos dispositivos finais.
4. **Organização PSR-4 Refinada**: Evita poluir o projeto com múltiplos comandos `require` ou `include`, auto-carregando os componentes de forma muito eficiente.
5. **Arquitetura Escalável MVC**: Separa de modo limpo a apresentação (View) do processamento (Controller) e dados (Model).
