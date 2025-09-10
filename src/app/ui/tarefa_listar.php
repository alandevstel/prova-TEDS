<?php
require_once __DIR__ . '/cabecalho.php';
require_once dirname(__DIR__, 2) . '/config/functions.php';

$pdo = pdo_connect_pgsql();
$tarefas = listarTarefas($pdo);
?>

<div class="content-header">
    <h2>Lista de Tarefas</h2>
</div>

<div class="tarefas-list">
    <?php if (!empty($tarefas)): ?>
        <table>
           
            <div class="tarefas-grid">
        <?php if (!empty($tarefas)): foreach ($tarefas as $tarefa): ?>
            <a href="tarefa_visualizar.php?id=<?= $tarefa['id'] ?>" class="tarefa-card" style="background-image: url('<?= UPLOADS_URL . '/' . htmlspecialchars($tarefa['imagem'] ?: 'placeholder.png') ?>');">
                <div class="tarefa-titulo">
                    <h3><?= htmlspecialchars($tarefa['titulo']) ?></h3>
                </div>
            </a>
        <?php endforeach; else: ?>
            <p>Nenhuma tarefa encontrada. <a href="tarefa_form.php">Crie a primeira!</a></p>
        <?php endif; ?>
    </div>
        </table>
    <?php else: ?>
        <p>Nenhuma tarefa encontrada. <a href="tarefa_form.php">Crie a primeira!</a></p>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/rodape.php'; ?>
