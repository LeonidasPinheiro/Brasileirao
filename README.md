# Gerador de resultados e exibição de tabela do campeonato Brasileiro.

1) Criar banco de dados.
2) Clonar repositório `https://github.com/LeonidasPinheiro/Brasileirao.git`
3) Copie `.env.example` para `.env`
4) Defina credenciais de banco de dados válidas das variáveis ambiente `DB_DATABASE`, `DB_USERNAME` e `DB_PASSWORD`
5) Execute `composer install`
6) Crie um link simbólico para AdminLTE (Execute os comandos como administrador)

7) Execute
```php
php artisan migrate
```
```php
php artisan db:seed
```
```php
php artisan key:generate
```
```php
php artisan serve
```
8) Access the application. Example: `http://127.0.0.1:8000`
9) Login: `dev@dev.com` Password: `root`
#### Brasileirao
##### Feito com Laravel 8 e utilizando o tema AdminLTE.
