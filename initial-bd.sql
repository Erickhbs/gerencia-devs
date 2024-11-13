CREATE TABLE IF NOT EXISTS anuidade (
    id INT AUTO_INCREMENT PRIMARY KEY,
    a_year INT NOT NULL,
    a_value DECIMAL(10, 2) NOT NULL
);

CREATE TABLE IF NOT EXISTS associado (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    cpf VARCHAR(11) NOT NULL
);

CREATE TABLE IF NOT EXISTS pagamento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    associado_id INT NOT NULL,
    ano INT NOT NULL,
    pago BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (associado_id) REFERENCES associado(id),
    FOREIGN KEY (ano) REFERENCES anuidade(a_year)
);

INSERT INTO anuidade (a_year, a_value) VALUES (2024, 200.00);
INSERT INTO anuidade (a_year, a_value) VALUES (2025, 250.00);

INSERT INTO associado (name, email, cpf) VALUES ('João Silva', 'joao@example.com', '12345678900');
INSERT INTO associado (name, email, cpf) VALUES ('Maria Oliveira', 'maria@example.com', '98765432100');
INSERT INTO associado (name, email, cpf) VALUES ('João Augusto', 'augusto@example.com', '11144477785');
INSERT INTO associado (name, email, cpf) VALUES ('felipe Aucantara', 'felipe@example.com', '22211155544');
INSERT INTO associado (name, email, cpf) VALUES ('Marcos Silva', 'marcos@example.com', '77788855544');
INSERT INTO associado (name, email, cpf) VALUES ('Pedro Rocha', 'pedro@example.com', '36984257145');

INSERT INTO pagamento (associado_id, ano, pago)
SELECT associado.id, anuidade.a_year, FALSE
FROM associado
CROSS JOIN anuidade;
