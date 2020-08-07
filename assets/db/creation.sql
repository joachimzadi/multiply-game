create database if not exists multiply_game_db;
use multiply_game_db;

create table if not exists Users
(
    id          int unsigned auto_increment not null,
    pseudo       nvarchar(255) unique        not null,
    mdp         nvarchar(255),
    constraint pk_users primary key (id)
);

create table if not exists Tentatives
(
    id        int unsigned auto_increment not null,
    operation nvarchar(255)               not null,
    reponse   int                         not null,
    statut    bool,
    pseudo    nvarchar(255),
    constraint pk_tentatives primary key (id)
);

drop table if exists Tentatives;
drop table if exists Users;
drop database if exists multiply_game_db;