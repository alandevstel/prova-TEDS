<?php

include __DIR__ . '/cabecalho.php';

$tarefas = listarTarefas();
?>

<div class="dashboard">
    <h1>Minhas Tarefas</h1>
    <div class="tarefas-container">
        <?php if (!empty($tarefas)) : ?>
            <?php foreach ($tarefas as $tarefa) : ?>
                <a href="tarefa_visualizar.php?id=<?= $tarefa['id'] ?>" class="tarefa-card" style="background-image: url('../uploads/<?= htmlspecialchars($tarefa['imagem'] ?? 'placeholder.png') ?>');">
                    <div class="tarefa-titulo">
                        <?= htmlspecialchars($tarefa['titulo']) ?>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else : ?>
            <p>Nenhuma tarefa encontrada. Que tal <a href="form_task.php">adicionar uma nova</a>?</p>
        <?php endif; ?>
    </div>
</div>

<?php
include __DIR__ . '/ui/rodape.php';
?>
