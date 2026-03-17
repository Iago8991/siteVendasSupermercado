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

CREATE TABLE carrinho_itens (

    carrinho_id INT AUTO_INCREMENT PRIMARY KEY,

    usuario_id INT NOT NULL,

    produto_id INT NOT NULL,

    quantidade INT NOT NULL DEFAULT 1,

    FOREIGN KEY (usuario_id) REFERENCES usuarios(user_id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(produtos_id) ON DELETE CASCADE,
    
    UNIQUE KEY uk_usuario_produto (usuario_id, produto_id)
);

CREATE TABLE administrador (
    adminis_id INT AUTO_INCREMENT PRIMARY KEY,
    adminis_email VARCHAR(200) NOT NULL UNIQUE,
    adminis_senha VARCHAR(255) NOT NULL
);

INSERT INTO administrador (adminis_email, adminis_senha)
VALUES ('administrador1@gmail.com', SHA2('admin2530', 256));

Select * from produtos;

Select * from carrinho_itens;

