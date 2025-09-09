-- =================================================================
-- INSTRUÇÕES DE EXECUÇÃO
-- =================================================================
-- 1. O banco de dados `db_testin` é criado automaticamente pelo Docker Compose na primeira vez.
--    O comando abaixo é para referência ou caso precise criar manualmente.
--    -- CREATE DATABASE db_testin;
--
-- 2. Conecte-se ao banco de dados `db_testin` usando o pgAdmin ou psql.
--
-- 3. Execute o restante deste script para criar o schema e as tabelas.
-- =================================================================


-- Remove o schema e todos os seus objetos (tabelas, etc.) se já existirem, para uma recriação limpa
DROP SCHEMA IF EXISTS tarefas_app CASCADE;

-- Cria um novo schema para organizar as tabelas da aplicação
CREATE SCHEMA tarefas_app;


-- Estrutura da tabela `categorias` (Entidade Secundária) dentro do schema `tarefas_app`
-- Usa SERIAL para auto-incremento de ID no PostgreSQL
CREATE TABLE tarefas_app.categorias (
  id SERIAL PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  descricao TEXT
);

-- Estrutura da tabela `tarefas` (Entidade Principal) dentro do schema `tarefas_app`
CREATE TABLE tarefas_app.tarefas (
  id SERIAL PRIMARY KEY,
  titulo VARCHAR(255) NOT NULL,
  descricao TEXT NOT NULL,
  data_limite DATE,
  status VARCHAR(50) NOT NULL,
  imagem VARCHAR(255),
  id_categoria INT NOT NULL,
  -- Define a chave estrangeira e a ação ON DELETE CASCADE
  -- A referência agora aponta para a tabela dentro do schema `tarefas_app`
  CONSTRAINT fk_tarefa_categoria
      FOREIGN KEY(id_categoria)
      REFERENCES tarefas_app.categorias(id)
      ON DELETE CASCADE
);

-- Adicionando alguns comentários para explicar a estrutura
COMMENT ON SCHEMA tarefas_app IS 'Schema para agrupar todas as tabelas do aplicativo de tarefas.';
COMMENT ON TABLE tarefas_app.categorias IS 'Armazena as categorias para organizar as tarefas.';
COMMENT ON TABLE tarefas_app.tarefas IS 'Armazena os detalhes de cada tarefa, incluindo uma referência à sua categoria.';

