<?php
    require_once ('config.php');

    class Connection{
        protected $connection; 
        
        
        /*--Constructor--*/
        function __construct(){
            $this->connection= mysqli_connect(HOST, USER, PASSWORD) or die('Error al conectar a la base de datos');
            $this->setCharSet();
            $this->selectDB();
        }

        /*--Crear una base de datos--*/
        function createDB(){
            mysqli_query($this->connection, 'create database if not exists ' .DB_NAME. ';');
        }

        /*--Seleccionar base de datos--*/
        function selectDB(){
            $dataBase=mysqli_select_db($this->connection, DB_NAME);
        }

        /*--Establecer tipo de caracteres--*/
        function setCharSet(){
            $this->connection->set_charset(CHARSET); 
        }

        /*--Cerrar conexión--*/
        function closeConnection(){
            mysqli_close($this->connection);
        }

        function veryfyConnection(){
            if($this->connection->connect_error){
                die("Conexión fallida: " .$this->connection->connec_error);
            }
        }

        
    }
?>