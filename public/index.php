<?php
session_start(); // Inicia a sessão
// Importa o autoload do Composer para carregar as rotas
require __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AuthController;
use App\Controllers\UsuarioController;
use App\Controllers\ProdutoController;
use App\Models\Auth;

// Função para renderizar as telas com layout
function render($view, $data = [])
{
    // Extrai os dados recebidos e converte em variáveis
    extract($data);
    ob_start();
    // Inclui a tela que enviamos específica
    require __DIR__ . '/../app/Views/' . $view;
    $content = ob_get_clean();
    require __DIR__ . '/../app/Views/layouts/base.php';
}

// Função para renderizar as telas sem template (página completa)
function render_sem_template($view, $data = [])
{
    // Extrai os dados recebidos e converte em variáveis
    extract($data);
    ob_start();
    // Inclui a tela que enviamos específica
    require __DIR__ . '/../app/Views/' . $view;
    ob_end_flush(); // Envia o conteúdo do buffer para o navegador
}

// Função para renderizar telas de login (sem layout)
function render_sem_login($view, $data = [])
{
    extract($data);
    require __DIR__ . '/../app/Views/' . $view;
}

// Obtem a URL do navegador
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$metodo = $_SERVER['REQUEST_METHOD'];

// Correção para rodar em subdiretórios (ex: localhost/sistema/public)
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
if ($scriptDir !== '/' && strpos($url, $scriptDir) === 0) {
    $url = substr($url, strlen($scriptDir));
}
if (empty($url)) {
    $url = '/';
}

// Instancia os controladores
$authController = new AuthController();
$usuarioController = new UsuarioController();
$produtoController = new ProdutoController();

// Rotas públicas (sem login)

// Página Inicial (Welcome)
if ($url == "/" || $url == "/index.php") {
    render_sem_template('welcome.php', [
        'title' => 'Bem-Vindo!',
        'lenda' => 'Agora eu sou uma lenda do PHP!',
        'links' => [
            'Sistema PetMais' => '/login',
            'Home PetMais' => '/home',
            'Sobre o Projeto' => '/about'
        ]
    ]);
    exit;
}

// Página Home
else if ($url == "/home" || $url == "/home.php") {
    render_sem_template('home.php', [
        'title' => 'PetMais - Tudo para seu Pet'
    ]);
    exit;
}

// Página Sobre
else if ($url == "/about" || $url == "/about.php") {
    render_sem_template('about.php', ['title' => 'Sobre o Projeto - Sistema PetMais']);
    exit;
}

// Página de login
else if ($url == "/login" || $url == "/login.php") {
    $authController->showLogin();
    exit;
}

// Processa login
else if ($url == "/login/processar" && $metodo == 'POST') {
    $authController->login();
    exit;
}

// Rotas protegidas (com login)

Auth::requerLogin();

// Logout
if ($url == "/logout") {
    $authController->logout();
    exit;
}

// Dashboard
else if ($url == "/dashboard" || $url == "/dashboard.php") {
    render('dashboard.php', ['title' => 'Dashboard - PetMais']);
    exit;
}

// Rotas de usuários

// Listagem de usuários
else if ($url == "/usuarios" || preg_match('#^/usuarios\?pagina=\d+$#', $_SERVER['REQUEST_URI'])) {
    $usuarioController->index();
    exit;
}

// Formulário de novo usuário
else if ($url == "/usuarios/novo") {
    $usuarioController->create();
    exit;
}

// Formulário antigo de inserir (mantido para compatibilidade)
else if ($url == "/usuarios/inserir") {
    render('usuarios/cadastro.php', ['title' => 'Cadastrar usuários']);
    exit;
}

// Salvar novo usuário (rota antiga)
else if ($url == "/usuarios/salvar" && $metodo == 'POST') {
    $usuarioController->store();
    exit;
}

// Formulário de edição de usuário
else if (preg_match('#^/usuarios/(\d+)/editar$#', $url, $matches)) {
    $id = (int)$matches[1];
    $usuarioController->edit($id);
    exit;
}

// Atualizar usuário
else if (preg_match('#^/usuarios/(\d+)/atualizar$#', $url, $matches) && $metodo == 'POST') {
    $id = (int)$matches[1];
    $usuarioController->update($id);
    exit;
}

// Excluir usuário
else if (preg_match('#^/usuarios/(\d+)/excluir$#', $url, $matches)) {
    $id = (int)$matches[1];
    $usuarioController->delete($id);
    exit;
}

// Rotas de produtos

// Listagem de produtos (nova rota com paginação)
else if ($url == "/produtos" || preg_match('#^/produtos\?pagina=\d+$#', $_SERVER['REQUEST_URI'])) {
    $produtoController->index();
    exit;
}

// Formulário de novo produto (nova rota)
else if ($url == "/produtos/novo") {
    $produtoController->create();
    exit;
}

// Salvar novo produto (nova rota)
else if ($url == "/produtos/salvar" && $metodo == 'POST') {
    $produtoController->store();
    exit;
}

// Formulário de edição de produto
else if (preg_match('#^/produtos/(\d+)/editar$#', $url, $matches)) {
    $id = (int)$matches[1];
    $produtoController->edit($id);
    exit;
}

// Atualizar produto
else if (preg_match('#^/produtos/(\d+)/atualizar$#', $url, $matches) && $metodo == 'POST') {
    $id = (int)$matches[1];
    $produtoController->update($id);
    exit;
}

// Excluir produto
else if (preg_match('#^/produtos/(\d+)/excluir$#', $url, $matches)) {
    $id = (int)$matches[1];
    $produtoController->delete($id);
    exit;
}

// Rota 404
else {
    http_response_code(404);
    render_sem_template('404.php');
    exit;
}
