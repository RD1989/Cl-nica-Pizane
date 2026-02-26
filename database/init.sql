-- Script de Inicialização da Clínica Pizane (MySQL)
-- Use este script para criar as tabelas no seu banco de dados remoto (PlanetScale, Aiven, etc.)

CREATE TABLE IF NOT EXISTS agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    whatsapp VARCHAR(50) NOT NULL,
    servico VARCHAR(255) DEFAULT 'Não informado',
    status ENUM('Pendente', 'Atendido', 'Cancelado') DEFAULT 'Pendente',
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Usuário administrativo padrão é definido nas variáveis de ambiente ou config.php
-- ADMIN_USER: admin
-- ADMIN_PASS: pizane2026
