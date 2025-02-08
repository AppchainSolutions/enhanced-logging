#!/bin/bash

# Script de despliegue para paquete Enhanced Logging

set -e

# Colores para output
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

# Función de log
log() {
    echo -e "${GREEN}[DEPLOY]${NC} $1"
}

# Función de advertencia
warn() {
    echo -e "${YELLOW}[ADVERTENCIA]${NC} $1"
}

# Validar versión de PHP
validate_php_version() {
    PHP_VERSION=$(php -r 'echo PHP_VERSION;')
    REQUIRED_VERSION="8.1"
    
    if [ "$(printf '%s\n' "$REQUIRED_VERSION" "$PHP_VERSION" | sort -V | head -n1)" != "$REQUIRED_VERSION" ]; then
        warn "Versión de PHP no compatible. Se requiere PHP 8.1+"
        exit 1
    fi
    
    log "Versión de PHP compatible: $PHP_VERSION"
}

# Instalar dependencias
install_dependencies() {
    log "Instalando dependencias..."
    composer install --prefer-dist --no-interaction
}

# Ejecutar pruebas
run_tests() {
    log "Ejecutando pruebas unitarias..."
    composer test
}

# Generar documentación
generate_docs() {
    log "Generando documentación..."
    # Placeholder para generación de documentación
}

# Publicar paquete en Packagist
publish_package() {
    log "Publicando paquete en Packagist..."
    composer validate
    # Requiere autenticación en Packagist
    # composer publish
}

# Menú principal
main() {
    echo "🚀 Script de Despliegue - Enhanced Logging 🚀"
    
    validate_php_version
    install_dependencies
    run_tests
    generate_docs
    
    read -p "¿Desea publicar el paquete en Packagist? (s/n): " publish
    
    if [[ $publish =~ ^[Ss]$ ]]; then
        publish_package
    fi
    
    log "Despliegue completado exitosamente 🎉"
}

# Ejecutar script
main
