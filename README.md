# Projeto API Laravel

Este é um projeto de API Laravel 12, containerizado com Docker e utilizando PostgreSQL, Redis e Mailpit para desenvolvimento local.

## Stack
- **Framework:** Laravel 12
- **Linguagem:** PHP ^8.2
- **Banco de Dados:** PostgreSQL (Docker)
- **Cache/Fila:** Redis (Docker)
- **Teste de E-mails:** Mailpit (Docker)
- **Containerização:** Docker Compose (Laravel Sail)
- **Testes:** PHPUnit, Pest

## Requisitos
- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/)
- [Composer](https://getcomposer.org/)

## Instruções de Instalação

1. **Clone o repositório:**
   ```sh
   git clone <url-do-seu-repositorio>
   cd <diretorio-do-projeto>
   ```

2. **Copie o arquivo de ambiente:**
   ```sh
   cp .env.example .env
   ```
   Edite o `.env` conforme necessário para sua configuração local.

3. **Inicie os containers de desenvolvimento:**
   ```sh
   ./vendor/bin/sail up -d
   ```
   Se você ainda não instalou o Sail, execute:
   ```sh
   composer install
   ```
   Depois inicie o Sail como acima.

4. **Instale as dependências PHP:**
   ```sh
   ./vendor/bin/sail composer install
   ```

5. **Gere a chave da aplicação:**
   ```sh
   ./vendor/bin/sail artisan key:generate
   ```

6. **Execute as migrações do banco de dados:**
   ```sh
   ./vendor/bin/sail artisan migrate
   ```

## Executando os Testes

Para rodar a suíte de testes:
```sh
./vendor/bin/sail test
```

---