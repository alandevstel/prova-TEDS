<?php
// Arquivo de configuração para o ambiente Docker existente

// Constantes para a conexão com o banco de dados PostgreSQL
define('DB_HOST', 'db');          // Nome do serviço do PostgreSQL no docker-compose.yml
define('DB_PORT', '5432');        // Porta padrão do PostgreSQL
define('DB_USER', 'postgres');    // Usuário do seu container 'db'
define('DB_PASS', 'admin');       // Senha do seu container 'db'
define('DB_NAME', 'db_testin');   // Nome do banco de dados do seu container 'db'

// URL base do site (acessado pela nova porta 8081)
define('BASE_URL', 'http://localhost:8081/');
