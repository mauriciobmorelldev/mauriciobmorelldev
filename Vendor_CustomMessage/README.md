# Vendor_CustomMessage

Módulo de ejemplo para Magento 2 que muestra un bloque frontend con un mensaje configurable desde el admin y una ruta propia.

## Características
- Configuración en **Stores > Configuration > General > Custom Message**.
- Ruta frontend en `/custommessage`.
- Código con PSR-12, DI y separación clara de responsabilidades.

## Instalación
1. Copiar el módulo en `app/code/Vendor/CustomMessage`.
2. Ejecutar:
   ```bash
   bin/magento module:enable Vendor_CustomMessage
   bin/magento setup:upgrade
   bin/magento cache:flush
   ```

## Uso
- Ir a **Stores > Configuration > General > Custom Message** y configurar **Enable** y **Message Text**.
- Visitar `/custommessage` en el frontend.
