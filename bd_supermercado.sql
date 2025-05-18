create database bd_supermercado; 
use bd_supermercado;

CREATE TABLE usuarios (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_nome VARCHAR(150) NOT NULL,
    user_email VARCHAR(200) NOT NULL UNIQUE,
    user_senha VARCHAR(255) NOT NULL
);

CREATE TABLE produtos (
    produtos_id INT AUTO_INCREMENT PRIMARY KEY,
    produtos_nome VARCHAR(150) NOT NULL,
    produtos_descricao TEXT NOT NULL,
    produtos_preco DECIMAL(10,2),
    produtos_imagem VARCHAR(255),
    produtos_estoque INT NOT NULL DEFAULT 0,
    produtos_desconto DECIMAL(5,2) NOT NULL DEFAULT 0,
    categoria VARCHAR(100) NOT NULL DEFAULT 'OUTROS'
);

CREATE TABLE pedidos (
    pedidos_id INT AUTO_INCREMENT PRIMARY KEY,
    pedidos_usuario_id INT NOT NULL,
    pedidos_datas DATETIME DEFAULT CURRENT_TIMESTAMP,
    pedidos_total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (pedidos_usuario_id) REFERENCES usuarios(user_id)
);

CREATE TABLE itens_pedido (
    ip_id INT AUTO_INCREMENT PRIMARY KEY,
    ip_pedido_id INT NOT NULL,
    ip_produto_id INT NOT NULL,
    ip_quantidade INT NOT NULL,
    ip_preco DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (ip_pedido_id) REFERENCES pedidos(pedidos_id),
    FOREIGN KEY (ip_produto_id) REFERENCES produtos(produtos_id)
);

CREATE TABLE administrador (
    adminis_id INT AUTO_INCREMENT PRIMARY KEY,
    adminis_email VARCHAR(200) NOT NULL UNIQUE,
    adminis_senha VARCHAR(255) NOT NULL
);

INSERT INTO administrador (adminis_email, adminis_senha)
VALUES ('administrador1@gmail.com', SHA2('admin2530', 256));

Select * from produtos;