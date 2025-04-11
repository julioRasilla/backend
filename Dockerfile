# Usa una imagen oficial de PHP con CLI
FROM php:8.1-cli

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    unzip \
    zip \
    git \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar phpDocumentor con todas las dependencias
RUN composer global require phpdocumentor/phpdocumentor:^3.2 --with-all-dependencies

# Agregar Composer bin al PATH
ENV PATH="/root/.composer/vendor/bin:${PATH}"

# Establecer el directorio de trabajo
WORKDIR /app

# Comando por defecto para generar la documentación
CMD ["phpdoc", "-d", "app", "-t", "docs"]

