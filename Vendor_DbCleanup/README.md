# Vendor_DbCleanup

Comando CLI para limpiar tablas de logs y (opcionalmente) optimizar tablas.

## Instalación
1. Copiar en `app/code/Vendor/DbCleanup`.
2. Ejecutar:
   ```bash
   bin/magento module:enable Vendor_DbCleanup
   bin/magento setup:upgrade
   ```

## Uso
- Limpiar logs:
  ```bash
  bin/magento vendor:db:cleanup
  ```
- Limpiar y optimizar:
  ```bash
  bin/magento vendor:db:cleanup --optimize
  ```
