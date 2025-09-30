# Sistema de Gestão de Finanças Pessoais

## 📌 Sobre o Projeto
Este projeto foi desenvolvido como parte da disciplina de **Programação Web 2 com Laravel**, com o objetivo de aplicar de forma prática os conceitos estudados.  
O sistema tem como finalidade auxiliar no **controle de gastos, receitas e metas financeiras**, permitindo ao usuário organizar melhor sua vida financeira.

## 🚀 Tecnologias Utilizadas
- **PHP** 8+
- **Laravel Framework** 10+
- **MySQL**
- **Composer**
- **Bootstrap** e **Tailwind CSS** 
- **Eloquent ORM** para manipulação do banco de dados

## ⚙️ Funcionalidades Principais
- Cadastro e gerenciamento de **Receitas**
- Cadastro e gerenciamento de **Despesas**
- Definição e acompanhamento de **Metas financeiras**
- Relacionamentos entre entidades usando **chaves estrangeiras**
- **CRUD completo** com validações de formulários
- Seeders para inserção de dados iniciais

## 🛠️ Como Rodar o Projeto

### 1. Instalar as dependências do projeto
```bash
composer install 
```
```bash
npm install
```

### 2. Configurar o arquivo `.env`
Copie o arquivo `.env.example` e renomeie para `.env`:
```bash
cp .env.example .env
```

### 3. Criar as tabelas do banco de dados
```bash
php artisan migrate
```

Ou criar as tabelas **e** inserir os registros iniciais:
```bash
php artisan migrate --seed
```

### 4. Iniciar o servidor
```bash
php artisan serve
```
```bash
npm run dev
```

### 5. Acessar o sistema
Abra no navegador:
```
http://localhost:8000/
```

---

## 👨‍💻 Autor
Desenvolvido para fins acadêmicos na disciplina de **Programação Web 2 com Laravel (2025.2)**.

