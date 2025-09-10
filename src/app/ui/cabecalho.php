<?php
// A única responsabilidade deste arquivo é incluir a configuração principal
// e iniciar o HTML. Isso evita loops de inclusão.
require_once dirname(__DIR__, 2) . '/config/config.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>app/style/style.css">
</head>
<body>
    <div class="grid-container">
        <?php
        // Inclui o menu lateral a partir daqui
        require_once __DIR__ . '/menu_lateral.php';
        ?>
        <main class="main-content">
            <?php
            // Exibe a mensagem da sessão, se houver
            if (isset($_SESSION['mensagem'])) {
                $tipo = $_SESSION['tipo_mensagem'] ?? 'info';
                echo "<p class='mensagem {$tipo}'>{$_SESSION['mensagem']}</p>";
                unset($_SESSION['mensagem'], $_SESSION['tipo_mensagem']);
            }
            ?>

