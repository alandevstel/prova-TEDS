<?php
// src/config/config.php

// Garante que os erros sejam exibidos durante o desenvolvimento
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inicia a sessão aqui para garantir que seja chamada apenas uma vez
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Constantes de conexão com o banco
define('DB_HOST', getenv('DB_HOST') ?: 'db');
define('DB_PORT', '5432');
define('DB_NAME', 'db_testin');
define('DB_USER', 'postgres');
define('DB_PASS', 'admin');
define('DB_DRIVER', 'pgsql');

// Constantes de caminhos
define('APP_ROOT', dirname(__DIR__, 2));
define('BASE_URL', 'http://localhost:8081/');
define('UPLOADS_DIR', $_SERVER['DOCUMENT_ROOT'] . '/uploads');
define('UPLOADS_URL', BASE_URL . 'uploads');

