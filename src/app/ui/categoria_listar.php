<?php
require_once __DIR__ . '/cabecalho.php';
require_once dirname(__DIR__, 2) . '/config/functions.php';

$pdo = pdo_connect_pgsql();
$categorias = listarCategorias($pdo);
?>

<div class="content-header">
    <h2>Listar Categorias</h2>
</div>

<?php if (isset($_SESSION['mensagem'])): ?>
    <p class="mensagem <?= $_SESSION['tipo_mensagem'] ?>"><?= $_SESSION['mensagem'] ?></p>
    <?php unset($_SESSION['mensagem'], $_SESSION['tipo_mensagem']); ?>
<?php endif; ?>

<div class="table-container">
    <?php if (!empty($categorias)): ?>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias as $categoria): ?>
                    <tr>
                        <td><?= htmlspecialchars($categoria['nome']) ?></td>
                        <td><?= htmlspecialchars($categoria['descricao']) ?></td>
                        <td>
                            <a href="categoria_form.php?id=<?= $categoria['id'] ?>" class="btn btn-sm btn-edit">Editar</a>
                            <a href="<?= BASE_URL ?>app/actions/categoria_excluir.php?id=<?= $categoria['id'] ?>" class="btn btn-sm btn-delete" onclick="return confirm('Tem certeza que deseja excluir esta categoria?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhuma categoria encontrada. <a href="categoria_form.php">Cadastre a primeira!</a></p>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/rodape.php'; ?>
