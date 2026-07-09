# MillyR Imóveis

Site WordPress de imobiliária.

## Branches

### `master` (deploy automático)
A branch `master` é o **`public_html` do Hostinger**. Todo push nesta branch é automaticamente implantado no servidor de produção via deploy automático do Hostinger.

Contém apenas os arquivos necessários para o WordPress funcionar em produção: core, plugins, temas, uploads, `wp-config-sample.php`.

> `wp-config.php` está no `.gitignore`. Para funcionar no Hostinger, copie `wp-config-sample.php` para `wp-config.php` e preencha as credenciais do banco. O arquivo só deve ser adicionado ao repositório se ele for privado.

### `source`
Clone da `master` no momento da criação. Serve como referência para agentes de IA entenderem o escopo completo do projeto. Contém os mesmos arquivos que a `master`.
