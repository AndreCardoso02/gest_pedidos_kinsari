<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Sobre o projecto

Este projeto é um sistema de gestão de pedidos de materiais desenvolvido com Laravel. O sistema permite a administração de pedidos através de dois perfis de usuários: Solicitante e Aprovador, oferecendo um fluxo completo de criação, aprovação e gerenciamento de pedidos.

## Funcionalidades

### Cadastro de Pedidos:
- Usuários solicitantes podem criar pedidos e incluir diversos materiais.
- Os pedidos são criados dentro do grupo do solicitante.

### Fluxo de Aprovação:
- Os pedidos são enviados para um aprovador.
- O aprovador pode realizar as seguintes ações:
- Aprovar o pedido (verificando saldo do grupo).
- Solicitar alterações no pedido.
- Rejeitar o pedido.

### Gestão de Saldo:
- Verificação do saldo permitido antes da aprovação.

### Estados do Pedido:
- Novo, Em Revisão, Alterações Solicitadas, Aprovado, Rejeitado.

## Diferenciais

- Uso de Testes Unitários e de Feature.
- Implementação com Livewire para interações dinâmicas.
- Uso correto de Models, Controllers, Middlewares e Rotas.
- Segurança para garantir que somente solicitantes possam criar pedidos e somente aprovadores possam aprovar, rejeitar ou solicitar alterações.
- Gestão de roles e permissions.
- Clean Architecture.
- Princípios SOLID.
- Design Pattern.
- SQL Server.

## Estrutura de directorios
- Back-end: PHP com Laravel.
- Front-end: Blade com Tailwind CSS.
- Banco de Dados: SQL Server.
- Autenticação: Laravel Breeze.
- Versionamento: Git.

## Estrutura de directorios

O projecto obedece a arquitectura limpa conforme proposto por Robert C. Martin

```bash
├── app
│   ├── Http
│   ├── Domain
│       ├── Interfaces
│       └── Models
│   ├── Repositories
│   ├── Usecases
│   ├── Services
├── database
│   └── migrations
├── resources
│   └── views
├── routes
└── tests
    ├── Unit
    └── Feature
```

## Como Executar

1. Clone o repositorio
```bash
https://github.com/AndreCardoso02/gest_pedidos_kinsari.git
cd gest_pedidos_kinsari
```

2. Instale as dependencias
```bash
composer install
npm install && npm run dev
```
- Crie uma copia do ficheiro .env

```bash

cp .env.example .env

```

- Gera a chave de encriptacao da aplicacao

```bash

php artisan key:generate

```


3. Configure o banco de dados

Crie um banco de dados SQL Server.
Configure o arquivo .env:

```bash
DB_CONNECTION=sqlsrv
DB_HOST=127.0.0.1
DB_PORT=1433
DB_DATABASE=DBMAROLIALTA
DB_USERNAME=sa
DB_PASSWORD=AAaa123#
```

4. Execute as migracoes
```bash
php artisan migrate --seed
```

5. Inicie o servidor
```bash
php artisan serve
```

6. Acesse o sistema: Abra [http://localhost:8000] no navegador.

## Testes

Para executar os testes
```bash
php artisan test
```

Os testes abrangem:

- Testes Unitários: Validação de regras de negócio e serviços.
- Testes de Feature: Verificação de integração de múltiplos componentes.


## Utilizadores do sistema

Ao executar executar a aplicacao alguns utilizadores ja serão inseridos por padrão 
```bash
Username: admin@kinsari.com
Password: AAaa123#


Username: aprovador@kinsari.com
Password: AAaa123#


Username: solicitantes@kinsari.com
Password: AAaa123#
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
