# Usa a imagem oficial do PHP 8.1 com Apache como base
FROM php:8.1-apache

#
# --- CORREÇÃO ADICIONADA AQUI ---
#
# Atualiza a lista de pacotes e instala as dependências de desenvolvimento do cliente PostgreSQL.
# - libpq-dev: Contém os arquivos de cabeçalho (como libpq-fe.h) necessários para compilar a extensão.
# - && rm -rf /var/lib/apt/lists/*: Limpa o cache para manter a imagem menor.
#
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

# Agora, instala as extensões PHP para o PostgreSQL. Este comando vai funcionar, pois as dependências foram instaladas.
RUN docker-php-ext-install pdo pdo_pgsql

# Habilita o módulo de reescrita de URL do Apache
RUN a2enmod rewrite

