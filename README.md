# MillyR Imóveis

Site WordPress de imobiliária.

## Branches

### `master`
**public_html** do Hostinger — conteúdo que renderiza o site. Contém apenas os arquivos necessários para o WordPress funcionar em produção (core, plugins, temas, uploads, `wp-config-sample.php`).

> `wp-config.php` está no `.gitignore`. Para deploy, copie `wp-config-sample.php` para `wp-config.php` e preencha as credenciais do banco.

### `source`
Clone da `master` no momento da criação. Serve como referência para agentes de IA entenderem o escopo completo do projeto. Contém os mesmos arquivos que a `master`.
