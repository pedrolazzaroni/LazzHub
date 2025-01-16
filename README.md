## Sistema de Funções

- **Registro e Autenticação de Usuários:** Permite que os usuários se registrem, façam login e gerenciem seus perfis.
- **Dashboard:** Dashboard personalizado onde os usuários podem acessar várias funcionalidades.
- **Gerar Resumos:** Crie resumos inteligentes de materiais de estudo.
- **Criar Questões:** Professores podem criar questões personalizadas para exames, ou alunos podem criar para estudar para provas.
- **Fazer Perguntas:** Faça perguntas sobre qualquer assunto e estilize o formato de resposta.
- **Registros Históricos:** Veja o histórico de atividades e conteúdo gerado.
- **Gerenciamento de Perfil:** Atualize seu perfil, incluindo foto de perfil, e-mail e senha.

## Como utilizar localmente

### Pré-requisitos

- **PHP** >= 8.0
- **Composer**
- **Node.js** e **NPM**
- Um servidor web como **Apache** ou **Nginx**
- **MySQL** ou outro banco de dados suportado

### Instalação

1. **Clonar o Repositório:**

    ```bash
    git clone https://github.com/pedrolazzaroni/LazzHub.git
    cd LazzHub
    ```

2. **Instalar Dependências:**

    ```bash
    composer install
    npm install
    npm run dev
    ```

3. **Configurar o Ambiente:**

    - Copie `.env.example` para `.env`:

        ```bash
        cp .env.example .env
        ```

    - Atualize o arquivo `.env` com suas credenciais de banco de dados e outras configurações necessárias.
    - Configure a variável `GOOGLE_API_KEY=` utilizando sua própria chave de API do Google

4. **Gerar Chave da Aplicação:**

    ```bash
    php artisan key:generate
    ```

5. **Executar Migrations:**

    ```bash
    php artisan migrate
    ```

6. **Iniciar o Servidor de Desenvolvimento:**

    ```bash
    php artisan serve
    ```

7. **Acessar a Aplicação:**

    Abra seu navegador e navegue até `http://localhost:8000`.

## Uso

- **Registrar uma Conta:** Visite a página de registro para criar uma nova conta.
- **Login:** Acesse seu dashboard fazendo login com suas credenciais.
- **Criar Resumos:** Navegue até a seção "Resumos" para gerar resumos inteligentes.
- **Criar Questões:** Professores podem criar questões personalizadas na seção "Questões".
- **Ver Histórico:** Confira o histórico de atividades na seção "Histórico".
- **Gerenciar Perfil:** Atualize suas informações de perfil e faça upload de uma foto de perfil na seção "Perfil".

## Agradecimentos

Obrigado por utilizar o LazzHub! Se você gostou do projeto, por favor, dê um [fork](https://github.com/pedrolazzaroni/LazzHub/fork) no repositório e contribua com melhorias.


