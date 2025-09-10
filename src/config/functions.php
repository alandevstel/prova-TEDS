<?php

require_once dirname(__DIR__) . '/logs/sistema_de_log.php'; // Inclui o arquivo de logs
/**
 * Cria uma conexão com o banco de dados PostgreSQL usando PDO.
 * As credenciais são lidas do arquivo config.php, que já deve ter sido incluído.
 * @return PDO Objeto de conexão PDO.
 */
function pdo_connect_pgsql()
{
    try {
        // Usa as constantes definidas em config.php
        $pdo = new PDO(DB_DRIVER . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        adicionarLog("Conexão com o banco de dados estabelecida com sucesso.");
        return $pdo;
    } catch (PDOException $e) {
        // Em um ambiente de produção, seria melhor logar o erro do que exibi-lo.
        adicionarLog("Erro ao conectar ao banco de dados: " . $e->getMessage(), 'ERRO');
        exit('Falha ao conectar ao banco de dados: ' . $e->getMessage());
    }
}

// --- Funções CRUD para TAREFAS ---

/**
 * Lista todas as tarefas do banco de dados.
 * @param PDO $pdo O objeto de conexão com o banco.
 * @return array Um array de tarefas.
 */
function listarTarefas(PDO $pdo): array
{
    // Define o schema no SQL para garantir que a tabela correta seja acessada
    $stmt = $pdo->query('SELECT * FROM tarefas_app.tarefas ORDER BY id DESC');
    adicionarLog("listarTarefas chamada");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Busca uma única tarefa pelo seu ID.
 * @param PDO $pdo O objeto de conexão com o banco.
 * @param int $id O ID da tarefa a ser buscada.
 * @return array|null Os dados da tarefa ou null se não encontrada.
 */
function buscarTarefaPorId(PDO $pdo, int $id): ?array
{
    $stmt = $pdo->prepare('SELECT * FROM tarefas_app.tarefas WHERE id = ?');
    $stmt->execute([$id]);
    $tarefa = $stmt->fetch(PDO::FETCH_ASSOC);
    adicionarLog("buscarTarefaPorId chamada para ID: $id");
    return $tarefa ?: null;
}

/**
 * Salva uma tarefa (insere uma nova ou atualiza uma existente).
 * @param PDO $pdo O objeto de conexão com o banco.
 * @param array $dados Os dados da tarefa vindos do formulário ($_POST).
 * @param array|null $arquivo Os dados do arquivo de imagem vindo de ($_FILES).
 * @return bool True em caso de sucesso, false em caso de falha.
 */
function salvarTarefa(PDO $pdo, array $dados, ?array $arquivo): bool
{
    $id = $dados['id'] ?? null;
    $titulo = $dados['titulo'] ?? '';
    $descricao = $dados['descricao'] ?? '';
    $status = $dados['status'] ?? '';
    $data_limite = $dados['data_limite'] ?? null;
    $categoria_id = $dados['categoria_id'] ?? null;
    $imagem_atual = $dados['imagem_atual'] ?? '';
    $nome_imagem = $imagem_atual;

   
    if ($arquivo && $arquivo['error'] == UPLOAD_ERR_OK) {
        
        $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true); // Cria o diretório se não existir
        }
        
        $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
        $nome_imagem = uniqid() . '.' . $extensao;
        $caminho_imagem = $upload_dir . $nome_imagem;
        adicionarLog("Upload de imagem iniciado: " . $arquivo['name']);

        if (!move_uploaded_file($arquivo['tmp_name'], $caminho_imagem)) {
            adicionarLog("Falha no upload da imagem da tarefa: " . $arquivo['name'], 'ERRO');
            return false;
        }
    }

    try {
        if ($id) {
            // Atualiza uma tarefa existente
            $sql = "UPDATE tarefas_app.tarefas SET titulo = ?, descricao = ?, status = ?, data_limite = ?, id_categoria = ?, imagem = ? WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            adicionarLog("Tarefa com ID $id atualizada com sucesso.");
            $stmt->execute([$titulo, $descricao, $status, $data_conclusao, $categoria_id, $nome_imagem, $id]);
        } else {
            // Insere uma nova tarefa
            $sql = "INSERT INTO tarefas_app.tarefas (titulo, descricao, status, data_limite, id_categoria, imagem) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            adicionarLog("Nova tarefa '$titulo' inserida com sucesso.");
            $stmt->execute([$titulo, $descricao, $status, $data_conclusao, $categoria_id, $nome_imagem]);
        }
        return true;
    } catch (PDOException $e) {
        // Log do erro
        adicionarLog("Erro ao salvar tarefa: " . $e->getMessage(), 'ERRO');
        return false;
    }
}

/**
 * Exclui uma tarefa do banco de dados pelo seu ID.
 * @param PDO $pdo O objeto de conexão com o banco.
 * @param int $id O ID da tarefa a ser excluída.
 * @return bool True em caso de sucesso, false em caso de falha.
 */
function excluirTarefa(PDO $pdo, int $id): bool
{
    try {
        $stmt = $pdo->prepare("DELETE FROM tarefas_app.tarefas WHERE id = ?");
        $stmt->execute([$id]);
        adicionarLog("Tarefa com ID '$id' excluída com sucesso.");
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        error_log("Erro ao excluir tarefa: " . $e->getMessage());
        adicionarLog("Erro ao excluir tarefa: " . $e->getMessage());
        return false;
    }
}


// --- Funções CRUD para CATEGORIAS ---

/**
 * Lista todas as categorias.
 * @param PDO $pdo O objeto de conexão com o banco.
 * @return array Um array de categorias.
 */
function listarCategorias(PDO $pdo): array
{
    $stmt = $pdo->query('SELECT * FROM tarefas_app.categorias ORDER BY nome ASC');
    adicionarLog("listarCategorias chamada");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Busca uma categoria pelo seu ID.
 * @param PDO $pdo O objeto de conexão com o banco.
 * @param int $id O ID da categoria.
 * @return array|null Dados da categoria ou null.
 */
function buscarCategoriaPorId(PDO $pdo, int $id): ?array
{
    $stmt = $pdo->prepare('SELECT * FROM tarefas_app.categorias WHERE id = ?');
    $stmt->execute([$id]);
    $categoria = $stmt->fetch(PDO::FETCH_ASSOC);
    adicionarLog("buscarCategoriaPorId chamada para ID: $id");
    return $categoria ?: null;
}

/**
 * Salva uma categoria (insere ou atualiza).
 * @param PDO $pdo O objeto de conexão com o banco.
 * @param array $dados Dados da categoria.
 * @return bool True em caso de sucesso, false em caso de falha.
 */
function salvarCategoria(PDO $pdo, array $dados): bool
{
    $id = $dados['id'] ?? null;
    $nome = $dados['nome'] ?? '';
    $descricao = $dados['descricao'] ?? '';

    try {
        if ($id) {
            $stmt = $pdo->prepare("UPDATE tarefas_app.categorias SET nome = ?, descricao = ? WHERE id = ?");
            $stmt->execute([$nome, $descricao, $id]);
            adicionarLog("Nova categoria '$nome' inserida com sucesso.");

        } else {
            $stmt = $pdo->prepare("INSERT INTO tarefas_app.categorias (nome, descricao) VALUES (?, ?)");
            $stmt->execute([$nome, $descricao]);
                        adicionarLog("Nova categoria '$nome' inserida com sucesso.");

        }
        return true;
    } catch (PDOException $e) {
        error_log("Erro ao salvar categoria: " . $e->getMessage());
        adicionarLog("Erro ao salvar categoria: " . $e->getMessage());

        return false;
    }
}


function excluirCategoria(PDO $pdo, int $id): bool
{
    try {


        $stmt = $pdo->prepare("DELETE FROM tarefas_app.categorias WHERE id = ?");
        $stmt->execute([$id]);
        adicionarLog("Categoria com ID '$id' excluída com sucesso.");
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        error_log("Erro ao excluir categoria: " . $e->getMessage());
        adicionarLog("Erro ao excluir categoria: " . $e->getMessage());
        return false;
    }
}
?>
