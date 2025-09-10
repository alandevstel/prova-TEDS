<?php
require_once __DIR__ . '/cabecalho.php';
require_once dirname(__DIR__, 2) . '/config/functions.php';

$pdo = pdo_connect_pgsql();

// Lógica para buscar dados de edição
$categoria = null;
$titulo_pagina = "Cadastrar Nova Categoria";
if (isset($_GET['id'])) {
    $categoria = buscarCategoriaPorId($pdo, $_GET['id']);
    $titulo_pagina = "Editar Categoria";
}
?>

<div class="content-header">
    <h2><?= $titulo_pagina ?></h2>
</div>

<form action="<?= BASE_URL ?>app/actions/categoria_salvar.php" method="post" class="form-container">
    <input type="hidden" name="id" value="<?= $categoria['id'] ?? '' ?>">

    <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($categoria['nome'] ?? '') ?>" required>
    </div>

    <div class="form-group">
        <label for="descricao">Descrição</label>
        <textarea id="descricao" name="descricao"><?= htmlspecialchars($categoria['descricao'] ?? '') ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Salvar Categoria</button>
</form>

<?php include __DIR__ . '/rodape.php'; ?>
