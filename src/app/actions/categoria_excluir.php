<?php
require_once dirname(__DIR__, 2) . '/config/config.php';
require_once dirname(__DIR__, 2) . '/config/functions.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id) {
    $pdo = pdo_connect_pgsql();
    $sucesso = excluirCategoria($pdo, $id);

    if ($sucesso) {
        $_SESSION['mensagem'] = "Categoria excluída com sucesso!";
        $_SESSION['tipo_mensagem'] = "sucesso";
    } else {
        $_SESSION['mensagem'] = "Erro ao excluir a categoria.";
        $_SESSION['tipo_mensagem'] = "erro";
    }
} else {
    $_SESSION['mensagem'] = "ID da categoria não fornecido.";
    $_SESSION['tipo_mensagem'] = "erro";
}

header('Location: ' . BASE_URL . 'app/ui/categoria_listar.php');
exit;
