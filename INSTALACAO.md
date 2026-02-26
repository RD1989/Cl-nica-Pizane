# 🚀 Guia de Instalação: Clínica Pizane (Versão MySQL)

Esta versão foi otimizada para quem prefere gerenciar o banco de dados via **phpMyAdmin** ou serviços de nuvem.

---

## 🛠 Passo 1: Preparar o Banco de Dados
1. Acesse o seu **phpMyAdmin** (ou similar).
2. Crie um novo banco de dados (ex: `clinica_pizane`).
3. Clique na aba **SQL** e importe o conteúdo do arquivo `database/schema.sql`.

---

## ⚙️ Passo 2: Configurar a Conexão
1. Abra o arquivo `api/config.php` no seu computador.
2. Altere as seguintes linhas com os dados do seu banco:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'nome_do_seu_banco');
   define('DB_USER', 'usuario_do_banco');
   define('DB_PASS', 'senha_do_banco');
   ```
3. Salve o arquivo.

---

## 📂 Passo 3: Subir os arquivos
1. Suba a pasta `clinica-pizane-mysql` para a raiz do seu site (`public_html`).
2. Se preferir, renomeie a pasta apenas para `clinica-pizane`.

---

## 🎨 Passo 4: Elementor
1. O processo é o mesmo: Copie o código de `site/index.html` e cole no widget HTML do Elementor.

---

## 🔐 Acesso ao Painel
*   **URL**: `https://seusite.com.br/clinica-pizane-mysql/admin/`
*   **Usuário**: `admin`
*   **Senha**: `pizane2026`

---
*Desenvolvido pela Skill Arquiteto Estratégico Digital.*
