-- Davi de Assis Fabricio e Vinicius Queiroz
-- FinançAI Database Schema
-- Execute este script no PHPMyAdmin ou MySQL Workbench

CREATE DATABASE IF NOT EXISTS financai_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE financai_db;

-- Tabela de Despesas
CREATE TABLE IF NOT EXISTS expenses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category ENUM('Moradia', 'Alimentação', 'Transporte', 'Lazer', 'Saúde', 'Educação', 'Vestuário', 'Outros') NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    expense_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela de Simulações de Financiamento (opcional, para histórico)
CREATE TABLE IF NOT EXISTS financing_simulations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    financing_type ENUM('imobiliario', 'veicular', 'pessoal') NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    term_months INT NOT NULL,
    interest_rate DECIMAL(5,2) NOT NULL,
    system_type ENUM('SAC', 'PRICE') NOT NULL,
    monthly_payment DECIMAL(10,2) NOT NULL,
    total_paid DECIMAL(12,2) NOT NULL,
    total_interest DECIMAL(12,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Simulações de Investimento (opcional, para histórico)
CREATE TABLE IF NOT EXISTS investment_simulations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    initial_amount DECIMAL(12,2) DEFAULT 0,
    monthly_contribution DECIMAL(10,2) DEFAULT 0,
    annual_return_rate DECIMAL(5,2) NOT NULL,
    term_months INT NOT NULL,
    final_amount DECIMAL(12,2) NOT NULL,
    total_invested DECIMAL(12,2) NOT NULL,
    total_earnings DECIMAL(12,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Inserir algumas despesas de exemplo (opcional)
INSERT INTO expenses (name, category, amount, expense_date) VALUES
('Supermercado', 'Alimentação', 150.50, '2024-09-01'),
('Gasolina', 'Transporte', 80.00, '2024-09-02'),
('Aluguel', 'Moradia', 1200.00, '2024-09-01'),
('Academia', 'Saúde', 89.90, '2024-09-03'),
('Cinema', 'Lazer', 45.00, '2024-09-05');