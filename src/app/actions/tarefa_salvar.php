<?php
require_once dirname(__DIR__, 2) . '/config/config.php';
require_once dirname(__DIR__, 2) . '/config/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'app/ui/pagina_inicial.php');
    exit;
}

$pdo = pdo_connect_pgsql();
$dados = [
    'id' => $_POST['id'] ?? null,
    'titulo' => $_POST['titulo'] ?? '',
    'descricao' => $_POST['descricao'] ?? '',
    'status' => $_POST['status'] ?? '',
    'data_limite' => $_POST['data_limite'] ?? null, // Alterado para data_limite
    'categoria_id' => $_POST['categoria_id'] ?? null,
    'imagem_atual' => $_POST['imagem_atual'] ?? ''
];

if (salvarTarefa($pdo, $dados, $_FILES['imagem'] ?? null)) {
    $_SESSION['mensagem'] = "Tarefa salva com sucesso!";
    $_SESSION['tipo_mensagem'] = "sucesso";
} else {
    $_SESSION['mensagem'] = "Erro ao salvar a tarefa. Tente novamente.";
    $_SESSION['tipo_mensagem'] = "erro";
}

header('Location: ' . BASE_URL . 'app/ui/tarefa_listar.php');
exit;
