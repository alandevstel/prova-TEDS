<?php
// Inclui o cabeçalho e as funções
require_once __DIR__ . '/cabecalho.php';
require_once dirname(__DIR__, 2) . '/config/functions.php';

// Conecta ao banco de dados e busca a tarefa
$pdo = pdo_connect_pgsql();
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$tarefa = null;

if ($id) {
    $tarefa = buscarTarefaPorId($pdo, $id);
}

// Verifica se a tarefa foi encontrada
if (!$tarefa) {
    $_SESSION['mensagem'] = "Tarefa não encontrada.";
    $_SESSION['tipo_mensagem'] = "erro";
    header('Location: ' . BASE_URL . 'app/ui/pagina_inicial.php');
    exit;
}

?>

<div class="content-header">
    <h2>Detalhes da Tarefa</h2>
</div>

<div class="tarefa-visualizar-container">
    <div class="tarefa-info">
        <div class="tarefa-image-container">
            <img src="<?= UPLOADS_URL . '/' . htmlspecialchars($tarefa['imagem'] ?? 'placeholder.png') ?>" alt="Imagem da Tarefa">
        </div>
        <div class="tarefa-details">
            <h3><?= htmlspecialchars($tarefa['titulo']) ?></h3>
            <p><strong>Descrição:</strong> <?= htmlspecialchars($tarefa['descricao']) ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($tarefa['status']) ?></p>
            <p><strong>Data Limite:</strong> <?= htmlspecialchars($tarefa['data_limite'] ?? 'Não definida') ?></p>
            <p><strong>Categoria:</strong> <?= htmlspecialchars($tarefa['id_categoria'] ?? 'Não definida') ?></p>
            <div class="tarefa-actions">
                <a href="<?= BASE_URL ?>app/ui/tarefa_form.php?id=<?= $tarefa['id'] ?>" class="btn btn-sm btn-edit">Editar</a>
                <a href="<?= BASE_URL ?>app/actions/tarefa_excluir.php?id=<?= $tarefa['id'] ?>" class="btn btn-sm btn-delete" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?');">Excluir</a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/rodape.php'; ?>
