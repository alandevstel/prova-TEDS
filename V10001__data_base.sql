
DROP SCHEMA IF EXISTS tarefas_app CASCADE;

CREATE SCHEMA tarefas_app;



CREATE TABLE tarefas_app.categorias (
  id SERIAL PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  descricao TEXT
);

CREATE TABLE tarefas_app.tarefas (
  id SERIAL PRIMARY KEY,
  titulo VARCHAR(255) NOT NULL,
  descricao TEXT NOT NULL,
  data_limite DATE,
  status VARCHAR(50) NOT NULL,
  imagem VARCHAR(255),
  id_categoria INT NOT NULL,
  CONSTRAINT fk_tarefa_categoria
      FOREIGN KEY(id_categoria)
      REFERENCES tarefas_app.categorias(id)
      ON DELETE CASCADE
);

COMMENT ON SCHEMA tarefas_app IS 'Schema para agrupar todas as tabelas do aplicativo de tarefas.';
COMMENT ON TABLE tarefas_app.categorias IS 'Armazena as categorias para organizar as tarefas.';
COMMENT ON TABLE tarefas_app.tarefas IS 'Armazena os detalhes de cada tarefa, incluindo uma referência à sua categoria.';

