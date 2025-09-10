<?php
require_once dirname(__DIR__, 2) . '/config/config.php';
require_once dirname(__DIR__, 2) . '/config/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . '/app/ui/pagina_inicial.php');
    exit;
}

$pdo = pdo_connect_pgsql();
$dados_categoria = [
    'id' => $_POST['id'] ?? null,
    'nome' => $_POST['nome'] ?? '',
    'descricao' => $_POST['descricao'] ?? '',
];

$sucesso = salvarCategoria($pdo, $dados_categoria);

if ($sucesso) {
    $_SESSION['mensagem'] = "Categoria salva com sucesso!";
    $_SESSION['tipo_mensagem'] = "sucesso";
} else {
    $_SESSION['mensagem'] = "Erro ao salvar a categoria.";
    $_SESSION['tipo_mensagem'] = "erro";
}

header('Location: ' . BASE_URL . 'app/ui/categoria_listar.php');
exit;
