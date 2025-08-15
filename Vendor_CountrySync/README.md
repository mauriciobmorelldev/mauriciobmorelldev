# Vendor_CountrySync

Ejemplo de integración REST en Magento 2: sincroniza países desde una API pública hacia una tabla custom.
Incluye **cron** y **comando CLI**.

## Instalación
1. Copiar en `app/code/Vendor/CountrySync`.
2. Ejecutar:
   ```bash
   bin/magento module:enable Vendor_CountrySync
   bin/magento setup:upgrade
   bin/magento cache:flush
   ```

## Uso
- Ejecutar sincronización manual:
  ```bash
  bin/magento vendor:countries:sync
  ```
- Cron corre diariamente a las 03:00 (ver `etc/crontab.xml`).

## Notas de buenas prácticas
- Uso de **interfaces** y **preference** en `etc/di.xml`.
- Manejo de errores y logs.
- Persistencia con `insertOnDuplicate` y `db_schema.xml` declarativo.
