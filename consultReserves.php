<?php
    require_once "consultCourt.php";
    require_once "consultUser.php";
    $consultCourt=new Court();
    $consultUser=new User();

    class Reserve extends Connection{

        //Constructor
        function __construct(){
            parent::__construct();
        }

        //Obtener reservas
        function getReserve(){
            $query="SELECT * FROM RESERVA;";
            $reserves=mysqli_query($this->connection, $query) or die ('No se pudieron consultar las reservas');
            return $reserves;

            mysqli_stmt_close($query);
        }

        //Obtener reservas del usuario
        function getReserveUser($idUser){
            $query=mysqli_prepare($this->connection, "SELECT * FROM RESERVA WHERE usuario=?;"); 
            $ok=mysqli_stmt_bind_param($query, 'i', $idUser);
            $ok=mysqli_execute($query);

            if($ok===false){
                echo "No se pudo realizar la consulta<br>";
            }else{
                $result=mysqli_stmt_get_result($query);
                return $result;
            }
            mysqli_stmt_close($query);
        }

        //Añadir reserva
        function addReserve($user, $court, $turn){
            $query=mysqli_prepare($this->connection, "INSERT INTO RESERVA (usuario, pista, turno) values (?, ?, ?)");
            $ok=mysqli_stmt_bind_param($query, 'iii', $user, $court, $turn);
            $ok=mysqli_stmt_execute($query);
            
            if($ok==false){
                echo "No se pudo añadir la reserva<br>";
            }

            mysqli_stmt_close($query);
        }

        //Eliminar todas las reservas
        function removeAllReserves(){
            $query=mysqli_prepare($this->connection, "DELETE from RESERVA");
            $ok=mysqli_stmt_execute($query);

            if ($ok==false){
                echo "No se pudo eliminar la reserva<br>";
            }
            mysqli_stmt_close($query);
        }

        //Eliminar reservas seleccionadas
        function removeReserveSelected($idReserve){
            $query=mysqli_prepare($this->connection, "DELETE from RESERVA WHERE id_reserva=?;");
            $ok=mysqli_stmt_bind_param($query, 'i', $idReserve);
            $ok=mysqli_stmt_execute($query);

            if ($ok==false){
                echo "No se pudo eliminar la reserva<br>";
            }
            mysqli_stmt_close($query);
        }

        //Mostrar todas las reservas
        function showReserves(){
            $reserves=$this->getReserve();
            if(mysqli_num_rows($reserves)==0){
                echo "No hay reservas que mostrar<br>";
            }else{
                echo '<div class="tables">
                        <form action="administrador.php" method="post">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Pista</th>
                                        <th>Turno</th>
                                    </tr>
                                </thead>
                                <tbody>';
                    while($row=mysqli_fetch_array($reserves)){
                        extract($row);
                        $users=$GLOBALS['consultUser']->getUserById($usuario);
                        $courts=$GLOBALS['consultCourt']->getCourtsById($pista);
        
                        while ($rowUser=mysqli_fetch_array($users)){
                            extract($rowUser);
                        }

                        while ($rowCourt=mysqli_fetch_array($courts)){
                            extract($rowCourt);
                        }
                        echo    "<tr>
                                    <td>$nombre</td>
                                    <td>$nombre_pista</td>
                                    <td>$turno</td>
                                    <td>
                                    <input type='checkbox' name='idReserve[]' value='$id_reserva'>
                                    </td>
                                </tr>";
                    }   
                            echo "<tr>
                                    <td colspan='4'>
                                        <button class='btn-remove-reserve' type='submit' name='removeSelection'>Eliminar reservas seleccionadas</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>";
            }
        }

        //Mostrar reservas del usuario
        function showUserReserves($id){
            $reserves=$this->getReserveUser($id);
            $courts=$GLOBALS['consultCourt']->getCourts();
            
            if(mysqli_num_rows($reserves)==0){
                echo 'No hay reservas que mostrar<br>';
            }else{
                echo '
                <div class="container-table-user">
                    <div class="tables">
                        <form method="post">
                            <table border solid 2px>
                                <thead>
                                    <tr>
                                        <th>id_reserva</th>
                                        <th>Pista</th>
                                        <th>Turno</th>
                                    </tr>
                                </thead>
                                <tbody>';
                    while($row=mysqli_fetch_array($reserves)){
                        extract($row);
                        $users=$GLOBALS['consultUser']->getUserById($usuario);
                        $courts=$GLOBALS['consultCourt']->getCourtsById($pista);

                        while ($rowUser=mysqli_fetch_array($users)){
                            extract($rowUser);
                        }

                        while ($rowCourt=mysqli_fetch_array($courts)){
                            extract($rowCourt);
                        }
                                echo "<tr>
                                        <td>$id_reserva</td>
                                        <td>$nombre_pista</td>
                                        <td>$turno</td>
                                        <td>
                                            <input type='checkbox' name='idReserve[]' value='$id_reserva'>
                                        </td>
                                    </tr>";
                    }   
                            echo " <tr>
                                        <td colspan='4'>
                                            <button class='btn-remove-reserve' type='submit' name='removeSelection'>Eliminar reservas seleccionadas</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>";
            }
        }
    }
?>