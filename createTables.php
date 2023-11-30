<?php
    require_once ('connection.php');

    class Crear extends Connection {
        
        //Constructor
        function __construct(){
            parent :: __construct();
        }

        /*----Crear tablas, usuario y administrador----*/
        function create(){
            $query='create table if not exists USUARIO( id_usuario int PRIMARY KEY auto_increment, nombre varchar(30), pass varchar(30), tipo   int CHECK(tipo=0 OR tipo=1) );
            create table if not exists PISTA( id_pista int PRIMARY KEY auto_increment, nombre_pista varchar(30) );
            create table if not exists RESERVA( id_reserva int PRIMARY KEY auto_increment, usuario int, pista int, turno int, FOREIGN KEY (usuario) references USUARIO (id_usuario), FOREIGN KEY (pista) references PISTA (id_pista));

            Insert into USUARIO (id, nombre, pass, tipo) values (1, "Daniel", "0000", 0) 
            ON DUPLICATE KEY UPDATE id_usuario = id_usuario;
            Insert into USUARIO (id, nombre, pass, tipo) values (2, "Silvia", "0000", 1) 
            ON DUPLICATE KEY UPDATE id_usuario = id_usuario';
            
            mysqli_multi_query($this->connection, $query);
        }

    }
?>