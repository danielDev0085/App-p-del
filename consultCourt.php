<?php
    class Court extends Connection{

        //Constructor
        function __construct(){
            parent::__construct();
        }
 
        //Añadir pistas
        function addCourt($courtName){
            $query=mysqli_prepare($this->connection, "INSERT INTO PISTA (nombre_pista) values (?);");
            $ok=mysqli_stmt_bind_param($query, 's', $courtName);
            $ok=mysqli_stmt_execute($query);

            if($ok==false){
                echo "No se pudo añadir la pista<br>";
            }

            mysqli_stmt_close($query);
        }

        //Eliminar pista
        function removeCourt($idCourt){
            $query=mysqli_prepare($this->connection, "DELETE from PISTA WHERE id_pista=?;");
            $ok=mysqli_stmt_bind_param($query, 'i', $idCourt);
            $ok=mysqli_stmt_execute($query);

            if($ok==false){
                echo "No se pudo eliminar la pista<br>";
            }

            mysqli_stmt_close($query);
        }

        //Actualizar pista
        function updateCourt($courtId, $courtName){
            $query=mysqli_prepare($this->connection, "UPDATE PISTA SET nombre_pista=? WHERE id_pista=?;");
            $ok=mysqli_stmt_bind_param($query, 'si',$courtName, $courtId);
            $ok=mysqli_stmt_execute($query);

            if($ok==false){
                echo "No se pudo actualizar la pista<br>";
            }
            mysqli_stmt_close($query);
        }
        
        //Obtener pistas
        function getCourts(){
            $query="SELECT * FROM PISTA;";
            $courts=mysqli_query($this->connection, $query) or die ('No se pudo hacer la consulta de pistas');
            return $courts;

            mysqli_stmt_close($query);
        }

        function getCourtsbyId($id){
            $query=mysqli_prepare($this->connection, "SELECT * FROM PISTA WHERE id_pista=?;");
            $ok=mysqli_stmt_bind_param($query, 'i', $id);
            $ok=mysqli_stmt_execute($query);

            if($ok==false){
                echo "No se pudo realizar la consulta<br>";
            }else{
                $resultado=mysqli_stmt_get_result($query);
                return $resultado;
            }
            mysqli_stmt_close($query);
        }


        //Mostrar pistas
        function showCourts(){
            $courts=$this->getCourts();
            if(mysqli_num_rows($courts)==0){
                echo 'No hay pistas que mostrar<br>';
            }else{
                echo '<div class="tables">
                        <table>
                            <thead>
                                <tr>
                                    <th>Id pista</th>
                                    <th>Nombre de la pista</th>
                                </tr>
                            </thead>
                            <tbody>';
                    while ($row=mysqli_fetch_array($courts)) { 
                        extract($row);
                        echo    '<tr>
                                    <td>'.$id_pista.'</td>
                                    <td>'.$nombre_pista.'</td>
                                </tr>';
                }
                    echo    '</tbody>
                        </table>
                    </div>';
            }
        }
}
?>



