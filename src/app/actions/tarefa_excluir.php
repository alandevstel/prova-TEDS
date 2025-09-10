<?php
require_once dirname(__DIR__, 2) . '/config/config.php';
require_once dirname(__DIR__, 2) . '/config/functions.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id) {
    $pdo = pdo_connect_pgsql();
    if (excluirTarefa($pdo, $id)) {
        $_SESSION['mensagem'] = "Tarefa excluída com sucesso!";
        $_SESSION['tipo_mensagem'] = "sucesso";
    } else {
        $_SESSION['mensagem'] = "Erro ao excluir a tarefa. Tente novamente.";
        $_SESSION['tipo_mensagem'] = "erro";
    }
} else {
    $_SESSION['mensagem'] = "ID da tarefa inválido.";
    $_SESSION['tipo_mensagem'] = "erro";
}

header('Location: ' . BASE_URL . 'app/ui/tarefa_listar.php');
exit;
