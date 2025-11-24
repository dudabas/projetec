create database if not exists uaiMenu;
use uaiMenu;



CREATE TABLE IF NOT EXISTS cliente_rest (
    id_cliente_rest INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20) NOT NULL
);
CREATE TABLE IF NOT EXISTS controle_envio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ultima_atualizacao DATETIME NOT NULL
);


create table if not exists adm(
email varchar (50),
senha_adm char (10) NOT NULL DEFAULT '1234',
senha_propria varchar (255),
id_adm int NOT NULL AUTO_INCREMENT primary key
);

CREATE TABLE IF NOT EXISTS controle_envio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ultima_atualizacao DATETIME NOT NULL
);
create table if not exists cardapio_dia(
dia ENUM('segunda-feira', 'terça-feira', 'quarta-feira', 'quinta-feira', 'sexta-feira', 'sábado') primary key
);

create table if not exists carne(
carne varchar (500),
dia ENUM('segunda-feira', 'terça-feira', 'quarta-feira', 'quinta-feira', 'sexta-feira', 'sábado'),
primary key (carne, dia),
foreign key (dia) references cardapio_dia(dia)
);

create table if not exists acompanhamento(
acompanhamento varchar (500),
dia ENUM('segunda-feira', 'terça-feira', 'quarta-feira', 'quinta-feira', 'sexta-feira', 'sábado'),
primary key (acompanhamento, dia),
foreign key (dia) references cardapio_dia(dia)
);

create table if not exists salada(
salada varchar (500),
dia ENUM('segunda-feira', 'terça-feira', 'quarta-feira', 'quinta-feira', 'sexta-feira', 'sábado'),
primary key (salada, dia),
foreign key (dia) references cardapio_dia(dia)
);

create table if not exists solicita(
dias_envio SET('segunda-feira', 'terça-feira', 'quarta-feira', 'quinta-feira', 'sexta-feira', 'sábado'),
dia ENUM('segunda-feira', 'terça-feira', 'quarta-feira', 'quinta-feira', 'sexta-feira', 'sábado'),
id_cliente_rest int,
primary key (dia, id_cliente_rest),
foreign key (dia) references cardapio_dia(dia),
foreign key (id_cliente_rest) references cliente_rest (id_cliente_rest)
);

create table if not exists edita(
dia ENUM('segunda-feira', 'terça-feira', 'quarta-feira', 'quinta-feira', 'sexta-feira', 'sábado'),
id_adm int,
primary key (dia, id_adm),
foreign key (dia) references cardapio_dia(dia),
foreign key (id_adm) references adm (id_adm)
);
SHOW tables;

select * from adm;


