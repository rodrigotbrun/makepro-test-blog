# Instalando

```
composer require rodrigobrun/makepro-test-blog
```

```
php artisan migrate
php artisan db:seed #dados de teste
```
# Rotas

## Categorias

|Método|Route|Description|Fields|
|------|------|-----|----|
|GET|/categories|Lista todas categorias||
|GET|/categories/{id}|Obtem uma categoria pelo ID||
|GET|/categories/{id}/posts|Lista todos os posts desta categoria||
|POST|/categories|Cria uma nova categoria|name: `string`<br>|
|PUT|/categories/{id}|Atualiza as informações de uma categoria|name: `string` <br><br> <b>*</b>*Pode enviar somente os que precisar*|
|DELETE|/categories/{id}|Deleta uma categoria (e todos os posts relacionados a ela)|

## Posts

|Método|Route|Description|Fields|
|------|------|-----|----|
|GET|/posts|Lista todos os posts||
|GET|/posts/{id}|Obtem um post pelo ID||
|POST|/posts|Cria um novo post|title: `string`<br>description: `string`<br>category: `integer`<br>|
|PUT|/posts/{id}|Atualiza as informações de um post|title: `string` <br>description: `string` <br>category: `integer` <br><br> <b>*</b>*Pode enviar somente os que precisar*|
|DELETE|/posts/{id}|Deleta um post pelo ID|

**OBS:** *Todas chamadas ao endpoint de `Posts` podem acompanhar a query `?withCategory` para incluir na resposta da API, o objeto `Category` ao invés de somente o código da categoria* 



