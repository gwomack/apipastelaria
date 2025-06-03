# Guia de Workflow GitFlow

O GitFlow é um modelo de ramificação que fornece uma estrutura robusta para gerenciar projetos maiores. Siga estes passos para configurar e usar o GitFlow em seu projeto Laravel:

## 1. Instale o GitFlow

No macOS, instale o GitFlow usando o Homebrew:
```bash
brew install git-flow
```

## 2. Inicialize o GitFlow no Seu Projeto

Navegue até o diretório do seu projeto e execute:
```bash
git flow init
```
Quando solicitado, você pode usar os nomes de branches padrão:
- Branch de produção: `main`
- Branch de desenvolvimento: `develop`
- Branches de funcionalidades: `feature/`
- Branches de release: `release/`
- Branches de hotfix: `hotfix/`
- Branches de suporte: `support/`

## 3. Workflow Básico do GitFlow

### a. Iniciando uma nova feature
```bash
git flow feature start nome-da-feature
```
Isso cria uma nova branch a partir de `develop` chamada `feature/nome-da-feature`.

### b. Finalizando uma feature
```bash
git flow feature finish nome-da-feature
```
Isso faz o merge da sua branch de feature de volta para `develop`.

### c. Iniciando uma release
```bash
git flow release start 1.0.0
```
Isso cria uma nova branch a partir de `develop` chamada `release/1.0.0`.

### d. Finalizando uma release
```bash
git flow release finish 1.0.0
```
Isso faz o merge da branch de release tanto em `main` quanto em `develop`.

### e. Criando um hotfix
```bash
git flow hotfix start nome-do-hotfix
```
Isso cria uma nova branch a partir de `main` chamada `hotfix/nome-do-hotfix`.

### f. Finalizando um hotfix
```bash
git flow hotfix finish nome-do-hotfix
```
Isso faz o merge do hotfix tanto em `main` quanto em `develop`.

## 4. Boas Práticas para Seu Projeto Laravel

- Sempre crie branches de feature para novas funcionalidades
- Use nomes de branch significativos (ex: `feature/autenticacao-usuario`, `feature/integracao-pagamento`)
- Mantenha sua branch `develop` estável
- Crie branches de release ao preparar uma nova versão
- Use hotfixes para correções urgentes em produção

## 5. Exemplo de Workflow

```bash
# Iniciar uma nova feature
git flow feature start autenticacao-usuario

# Faça suas alterações e faça commit delas
git add .
git commit -m "Adicionar funcionalidade de autenticação de usuário"

# Finalizar a feature
git flow feature finish autenticacao-usuario

# Quando estiver pronto para o release
git flow release start 1.0.0
# Faça quaisquer alterações específicas do release
git flow release finish 1.0.0
```

## 6. Dicas Adicionais

- Sempre puxe as últimas alterações antes de iniciar uma nova feature:
  ```bash
  git checkout develop
  git pull origin develop
  git flow feature start nova-feature
  ```
- Use mensagens de commit significativas que sigam o padrão convencional:
  ```
  feat: adicionar autenticação de usuário
  fix: corrigir problema de validação no login
  docs: atualizar documentação da API
  ```
- Considere usar o GitFlow com um pipeline de CI/CD para automatizar testes e deploy 
