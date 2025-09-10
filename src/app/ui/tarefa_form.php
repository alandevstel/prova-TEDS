<?php
// Inclui o cabeçalho, que já carrega a configuração principal
require_once __DIR__ . '/cabecalho.php';

// Inclui as funções do banco de dados e outras utilidades
require_once dirname(__DIR__, 2) . '/config/functions.php';

$pdo = pdo_connect_pgsql();

// Lógica para buscar dados para edição
$tarefa = null;
$titulo_pagina = "Cadastrar Nova Tarefa";
if (isset($_GET['id'])) {
    $tarefa = buscarTarefaPorId($pdo, $_GET['id']);
    $titulo_pagina = "Editar Tarefa";
}

$categorias = listarCategorias($pdo);
?>
<div class="content-header">
    <h2><?= $titulo_pagina ?></h2>
</div>

<form action="<?= BASE_URL ?>/app/actions/tarefa_salvar.php" method="post" enctype="multipart/form-data" class="form-container">
    <input type="hidden" name="id" value="<?= $tarefa['id'] ?? '' ?>">
    <input type="hidden" name="imagem_atual" value="<?= $tarefa['imagem'] ?? '' ?>">

    <div class="form-group">
        <label for="titulo">Título</label>
        <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($tarefa['titulo'] ?? '') ?>" required>
    </div>

    <div class="form-group">
        <label for="descricao">Descrição</label>
        <textarea id="descricao" name="descricao" required><?= htmlspecialchars($tarefa['descricao'] ?? '') ?></textarea>
    </div>

    <div class="form-group">
        <label for="data_conclusao">Data de Conclusão (Opcional)</label>
        <input type="date" id="data_conclusao" name="data_conclusao" value="<?= htmlspecialchars($tarefa['data_conclusao'] ?? '') ?>">
    </div>
    
    <div class="form-group">
        <label for="status">Status</label>
        <select id="status" name="status" required>
            <option value="A fazer" <?= (($tarefa['status'] ?? '') === 'A fazer') ? 'selected' : '' ?>>A fazer</option>
            <option value="Em andamento" <?= (($tarefa['status'] ?? '') === 'Em andamento') ? 'selected' : '' ?>>Em andamento</option>
            <option value="Concluída" <?= (($tarefa['status'] ?? '') === 'Concluída') ? 'selected' : '' ?>>Concluída</option>
        </select>
    </div>

    <div class="form-group">
        <label for="categoria_id">Categoria</label>
        <select id="categoria_id" name="categoria_id" required>
            <?php if (!empty($categorias)): foreach ($categorias as $categoria): ?>
                <option value="<?= htmlspecialchars($categoria['id']) ?>" <?= (($tarefa['id_categoria'] ?? '') == $categoria['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($categoria['nome']) ?>
                </option>
            <?php endforeach; else: ?>
                <option value="">Nenhuma categoria encontrada</option>
            <?php endif; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="imagem">Imagem da Tarefa (Opcional)</label>
        <input type="file" id="imagem" name="imagem" accept="image/*">
    </div>

    <?php if (isset($tarefa['imagem']) && $tarefa['imagem']): ?>
        <div class="form-group">
            <label>Imagem Atual</label>
            <img src="<?= UPLOADS_URL . '/' . htmlspecialchars($tarefa['imagem']) ?>" alt="Imagem da Tarefa" style="max-width: 200px; display: block;">
        </div>
    <?php endif; ?>

    <button type="submit" class="btn btn-primary">Salvar Tarefa</button>
</form>

<?php include __DIR__ . '/rodape.php'; ?>
