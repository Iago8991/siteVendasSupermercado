show databases;

create database bd_supermercado;

use bd_supermercado;

create table usuarios(
	user_id int auto_increment primary key,
    user_nome varchar(150) not null,
    user_email varchar(200) not null unique,
    user_senha varchar(255) not null
);

create table produtos(
	produtos_id int auto_increment primary key , 
    produtos_nome varchar(150) not null, 
    produtos_descricao text not null, 
    produtos_preco decimal(10, 2), 
    produtos_imagem varchar(255), 
    produtos_estoque int not null default 0
);

create table categorias( 
categorias_id int auto_increment primary key, 
categorias_nome varchar(150) not null
);

create table pedidos( 
pedidos_id int auto_increment primary key, 
pedidos_usuario_id int not null, 
pedidos_datas datetime default current_timestamp, 
pedidos_total decimal(10, 2) not null,
foreign key (pedidos_usuario_id) references usuarios(user_id)
);

create table itens_pedido( 
ip_id int auto_increment primary key, 
ip_pedido_id int not null, 
ip_produto_id int not null,
ip_quantidade int not null, 
ip_preco decimal(10, 2) not null,
foreign key (ip_pedido_id) references pedidos(pedidos_id),
foreign key (ip_produto_id) references produtos(produdos_id)
);

create table administrador(
	adminis_id int auto_increment primary key,
    adminis_email varchar(200) not null unique,
    adminis_senha varchar(255) not null
);

insert into administrador (adminis_email, adminis_senha)
values ('administrador1@gmail.com', SHA2('admin2530', 256));

select * from usuarios  ;

delete from usuarios where 23564326;
;