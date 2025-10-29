# Conecta Vale

## Descrição
O Conecta Vale é uma plataforma de e-commerce baseada em Laravel que conecta vendedores e clientes. Ele permite que os vendedores criem seus próprios perfis, gerenciem produtos e os categorizem, enquanto os clientes podem navegar e comprar produtos. A plataforma inclui um painel de administração para gerenciar todo o sistema.

## Funcionalidades
- Autenticação de usuários para administradores, vendedores e clientes.
- Perfis de vendedor com nome da loja, tipo de documento, número do documento e telefone.
- Gerenciamento de produtos, incluindo criação, edição e exclusão.
- Gerenciamento de categorias para organizar os produtos.
- Um seeder de banco de dados para popular a aplicação com dados de teste, incluindo um administrador, vendedores, clientes, produtos e categorias.

## Tecnologias Utilizadas
- **Backend:** Laravel, PHP
- **Frontend:** Blade, Alpine.js, Tailwind CSS, Vite
- **Banco de Dados:** MySQL (baseado na configuração típica do Laravel)
- **Ambiente de Desenvolvimento:** Laravel Sail (opcional, baseado no `composer.json`)

## Instalação
1. **Clone o repositório:**
   ```bash
   git clone https://github.com/your-username/conecta-vale.git
   cd conecta-vale
   ```
2. **Instale as dependências do PHP:**
   ```bash
   composer install
   ```
3. **Instale as dependências do frontend:**
   ```bash
   npm install
   ```
4. **Crie uma cópia do arquivo `.env.example` e nomeie-a como `.env`:**
   ```bash
   cp .env.example .env
   ```
5. **Gere uma chave de aplicação:**
   ```bash
   php artisan key:generate
   ```
6. **Configure seu banco de dados no arquivo `.env`.**
7. **Execute as migrações do banco de dados e popule o banco de dados (seed):**
   ```bash
   php artisan migrate --seed
   ```
8. **Inicie o servidor de desenvolvimento do Vite:**
   ```bash
   npm run dev
   ```
9. **Inicie o servidor de desenvolvimento do Laravel:**
   ```bash
   php artisan serve
   ```
## Uso
O seeder do banco de dados cria os seguintes usuários de teste:

- **Administrador:**
  - **Email:** `admin@conectavale.com`
  - **Senha:** `admin123`

- **Vendedor:**
  - **Email:** `vendedor@teste.com`
  - **Senha:** `password`

Você pode usar essas credenciais para fazer login e testar a aplicação.

## Contribuição
Contribuições são bem-vindas! Sinta-se à vontade para enviar um pull request.
<!-- 
## Licença
Este projeto está licenciado sob a Licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes. -->