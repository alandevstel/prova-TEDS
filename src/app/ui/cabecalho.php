<?php
// src/app/ui/cabecalho.php

// Inicia a sessão para podermos usar $_SESSION para mensagens
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//
// --- CORREÇÃO PRINCIPAL AQUI ---
//
// Usamos caminhos absolutos a partir da raiz do documento para garantir que
// os arquivos de configuração e funções sejam sempre encontrados.
// No contêiner Docker, $_SERVER['DOCUMENT_ROOT'] equivale a /var/www/html
//
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/functions.php';

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Tarefas</title>
    <!-- O caminho para o CSS também deve ser absoluto a partir da raiz do site -->
    <link rel="stylesheet" href="/app/style/style.css">
</head>
<body>
    <div class="grid-container">
        <?php
        // Inclui o menu lateral, também com caminho absoluto
        require_once $_SERVER['DOCUMENT_ROOT'] . '/app/ui/menu_lateral.php';
        ?>
        <main class="main-content">
            <?php
            // Exibe mensagens de sucesso ou erro, se houver alguma na sessão
            if (isset($_SESSION['mensagem'])) {
                // A classe CSS (sucesso/erro) também vem da sessão
                $tipo_mensagem = $_SESSION['tipo_mensagem'] ?? 'info';
                echo "<p class='mensagem {$tipo_mensagem}'>{$_SESSION['mensagem']}</p>";
                
                // Limpa a mensagem da sessão para não exibir novamente
                unset($_SESSION['mensagem']);
                unset($_SESSION['tipo_mensagem']);
            }
            ?>

