<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Instalação do projeto

O projeto usa Laravel 10+, logo, você precisa do PHP 8.1+ para conseguir executá-lo.

- Clone o repositório para seu local de preferência.
- Entre na pasta do projeto e abra o Terminal ou CLI de sua preferência.
- Execute o composer install.
- Faça a cópia do .env.example e renomeie para .env
- Certifique-se de que configurou o .env.
- php artisan key:generate
- php artisan serve (provavelmente vai subir em http://127.0.0.1:8000)
- Em um novo CLI, php artisan migrate --seed.

Seguindo esses passos, o projeto será executado tranquilamente.
Abaixo, seguem as instruções de uso da API documentadas com Swagger.

## Testes
- php artisan test
- Se preferir uma resposta mais incrementada, use php artisan test --testdox

## Documentação da API - Swagger
- Acesse /api/docs depois de executar o php artisan serve.
- Para gerar um token e poder testar as demais funções protegidas, durante o Seed é criado um usuário padrão de teste. A documentação já está com esses dados.
- Por se tratar de uma construção simplificada, não foi aplicado o ACL.