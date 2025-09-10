<?php
// Define o diretório onde os logs serão armazenados.
define('LOGS_DIR', __DIR__ . '/../logs');

// Cria o diretório de logs se ele não existir.
if (!is_dir(LOGS_DIR)) {
    mkdir(LOGS_DIR, 0777, true);
}

/**
 * Adiciona uma entrada a um arquivo de log.
 *
 * @param string $mensagem A mensagem a ser logada.
 * @param string $nivel O nível de log (e.g., 'INFO', 'ERRO').
 * @param string $arquivo O nome do arquivo de log.
 */
function adicionarLog(string $mensagem, string $nivel = 'INFO', string $arquivo = 'app.log')
{
    $data_hora = date('Y-m-d H:i:s');
    $log_path = LOGS_DIR . '/' . $arquivo;
    $log_entry = "[$data_hora][$nivel] $mensagem\n";
    file_put_contents($log_path, $log_entry, FILE_APPEND);
}
?>