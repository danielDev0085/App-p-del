<?php
    require_once ('connection.php');

    class User extends Connection{
        /*Constructor*/
        function __construct(){
            parent:: __construct();
        }

        /*Obtener todos los usuarios de la tabla USUARIO*/ 
        function getAllUsers(){
            $query="SELECT * from USUARIO";
            $allUsers=mysqli_query($this->connection, $query);
            return $allUsers;
            mysqli_stmt_close($query);
        }

        /*Obtener el usuario que coincida en nombre y password*/
        function getUser($name, $password){
            $query=mysqli_prepare($this->connection, "SELECT * from USUARIO WHERE nombre=? AND pass=?;");
            $ok=mysqli_stmt_bind_param($query, 'ss', $name, $password);
            $ok=mysqli_stmt_execute($query);

            if($ok==false){
                echo "No se pudo hacer la consulta<br>";
            }else{
                $result=mysqli_stmt_get_result($query); //Obtener resultado de consulta
                return $result;
            }
            mysqli_stmt_close($query);
        }

        /*Obtener usuario por su id*/
        function getUserById($id){
            $query=mysqli_prepare($this->connection, "SELECT * FROM USUARIO WHERE id_usuario=?");
            $ok=mysqli_stmt_bind_param($query, 'i', $id);
            $ok=mysqli_stmt_execute($query);

            if($ok===false){
                echo "No se pudo hacer la consulta";
            }else{
                $result=mysqli_stmt_get_result($query);
                return $result;
            }
            mysqli_stmt_close($query);
        }

        /*Obtener si el usuario es administrador o usuario*/
        function getTypeUser($user){
            $userData=mysqli_fetch_assoc($user);
            $typeUser=$userData['tipo'];
            return $typeUser;
        }

        /*Consultar los datos del usuario y redirigirlo*/
        function consultUser($name, $password){
            $user=$this->getUser($name, $password) or die("Error al obtener el resultado");
        
            if(mysqli_num_rows($user)==0){
                echo "El usuario o la contraseña son incorrectos <br>";
            }else{
                if($this->getTypeUser($user)==0){
                    header("location:administrador.php");
                }else{
                    header("location:usuario.php");
                }
            }
        }

        //Añadir usuarios
        function addUser($userName, $password){
            $tipo=1;
            $query=mysqli_prepare($this->connection, "INSERT into USUARIO (nombre, pass, tipo) values (? ,?, ?)");
            $ok=mysqli_stmt_bind_param($query, 'ssi', $userName, $password, $tipo);
            $ok=mysqli_stmt_execute($query);

            if($ok==false){
                echo "No se pudo añadir el usuario<br>";
            }
            mysqli_stmt_close($query);
        }

        //Eliminar usuarios
        function removeUser($id_user){
            $query=mysqli_prepare($this->connection, "DELETE from USUARIO WHERE id_usuario=?;");
            $ok=mysqli_stmt_bind_param($query, 'i', $id_user);
            $ok=mysqli_stmt_execute($query);

            if($ok==false){
                echo "No se pudo eliminar el usuario<br>";
            }
            mysqli_stmt_close($query);
        }

        //Modificar usuarios
        function updateUser($id_user, $userName, $password, $type){
            $query=mysqli_prepare($this->connection, "UPDATE USUARIO set nombre=?, pass=?, tipo=? WHERE id_usuario=?;");
            $ok=mysqli_stmt_bind_param($query, 'ssii', $userName, $password, $type, $id_user);
            $ok=mysqli_stmt_execute($query);

            if($ok==false){
                echo "No se pudo modificar el usuario<br>";
            }
            mysqli_stmt_close($query);
        }

        function closeUserSession(){
            if (isset($_SESSION['usuario'])) {
                //Eliminar todas las variables de sesión
                session_unset();
            
                //Destruir la sesión
                session_destroy();
            
                header("Location: login.php");
                exit();
            } else {
                header("Location: login.php");
                exit();
            }
        }

        /*Obtener una tabla con los datos de todos los usuarios*/
        function showUsers(){
            $allUsers=$this->getAllUsers();
            if(mysqli_num_rows($allUsers)==0){
                echo "No hay usuarios que mostrar<br>";
            }else{
                echo '<div class="tables">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID Usuario</th>
                                    <th>Nombre</th>
                                    <th>Password</th>
                                    <th>Tipo</th>
                                </tr>
                            </thead>
                            <tbody>'; 
                    while ($row=mysqli_fetch_array($allUsers)) { 
                        extract($row);
                        echo    '<tr>
                                    <td>'.$id_usuario.'</td>
                                    <td>'.$nombre.'</td>
                                    <td>'.$pass.'</td>
                                    <td>'.$tipo.'</td>
                                </tr>
                            </tbody>';
                    }
                echo    '</table>
                    </div>';
            }
        }
    }
?>