<?php
include 'cabecalho.php';
include 'menu_lateral.php';

// Verifica se está editando ou criando
$tarefa = null;
$titulo_pagina = "Cadastrar Nova Tarefa";
if (isset($_GET['id'])) {
    $tarefa = getTarefaPorId($_GET['id']);
    $titulo_pagina = "Editar Tarefa";
}

$categorias = listarCategorias();
?>
<main class="main-content">
    <div class="content-header">
        <h2><?php echo $titulo_pagina; ?></h2>
    </div>

    <form action="tarefa_salvar.php" method="post" enctype="multipart/form-data" class="form-container">
        <!-- Campo oculto para o ID em caso de edição -->
        <input type="hidden" name="id" value="<?php echo $tarefa['id'] ?? ''; ?>">

        <div class="form-group">
            <label for="titulo">Título</label>
            <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($tarefa['titulo'] ?? ''); ?>" required>
        </div>

        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea id="descricao" name="descricao" required><?php echo htmlspecialchars($tarefa['descricao'] ?? ''); ?></textarea>
        </div>

        <div class="form-group">
            <label for="data_limite">Data Limite</label>
            <input type="date" id="data_limite" name="data_limite" value="<?php echo $tarefa['data_limite'] ?? ''; ?>" required>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status" required>
                <option value="Pendente" <?php echo (isset($tarefa['status']) && $tarefa['status'] == 'Pendente') ? 'selected' : ''; ?>>Pendente</option>
                <option value="Em Andamento" <?php echo (isset($tarefa['status']) && $tarefa['status'] == 'Em Andamento') ? 'selected' : ''; ?>>Em Andamento</option>
                <option value="Concluída" <?php echo (isset($tarefa['status']) && $tarefa['status'] == 'Concluída') ? 'selected' : ''; ?>>Concluída</option>
            </select>
        </div>

        <div class="form-group">
            <label for="id_categoria">Categoria</label>
            <select id="id_categoria" name="id_categoria" required>
                <option value="">Selecione uma categoria</option>
                <?php foreach ($categorias as $categoria) : ?>
                    <option value="<?php echo $categoria['id']; ?>" <?php echo (isset($tarefa['id_categoria']) && $tarefa['id_categoria'] == $categoria['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($categoria['nome']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="imagem">Imagem da Tarefa</label>
            <input type="file" id="imagem" name="imagem" accept="image/*">
            <?php if (isset($tarefa['imagem']) && !empty($tarefa['imagem'])) : ?>
                <p>Imagem atual: <a href="uploads/<?php echo $tarefa['imagem']; ?>" target="_blank"><?php echo $tarefa['imagem']; ?></a></p>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Tarefa</button>
    </form>

</main>
<?php include 'rodape.php'; ?>
