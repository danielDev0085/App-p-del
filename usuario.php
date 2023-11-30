<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Usuario</title>
</head>
<body>
    <?php
        session_start();

        require_once('consultUser.php');
        require_once('consultCourt.php');
        require_once ('consultReserves.php');
        require_once ('forms.php');

        $connection=new Connection();
        $consultReserve=new Reserve();
        $consultUser=new User();
        $forms=new Form();

        /*----Obtener reservas de usuario----*/
        //Obtener id del usuario
        $user=$consultUser->getUser($_SESSION['$user'], $_SESSION['$password']);
                if(mysqli_num_rows($user)==0){
                    echo "No se encontraron reservas";
                }else{
                    //Obtener reservas a partir del id del usuario
                    $row=mysqli_fetch_array($user);
                    extract($row);
                    $_SESSION['idUser']=$id_usuario;
                    $consultReserve->showUserReserves($_SESSION['idUser']);
                }
        
        /*----Añadir reserva----*/
        if(isset($_POST['reserve'])){
            if(($_POST['court']!="") && ($_POST['turn']!="")){

                $reserves=$consultReserve->getReserve();
                $open=true;
                //Convertir a integer los valores obtenidos de los select
                $court=(int)$_POST['court'];
                $turn=(int)($_POST['turn']);

                while ($row=mysqli_fetch_array($reserves)){
                    extract($row);
                    //Comprobar disponibilidad
                    if($court==$pista && $turn==$turno){
                        $open=false;
                    }
                }

                if($open==false){
                    echo "Turno no disponible";
                    header('refresh:2, url=usuario.php');
                }else{
                    $consultReserve->addReserve($_SESSION['idUser'], $court, $turn);
                    header('refresh:2, url=usuario.php');
                }
            }else{
                echo 'Rellene todos los campos para reservar la pista';
                header('refresh:2, url=usuario.php');
            }
        }

        /*----Eliminar reserva por id----*/
        if(isset($_POST['removeReserveId'])){
            if(!empty($_POST['idReserve'])){
                $idReserve=$_POST['idReserve'];
                $consultReserve->removeReserveSelected($idReserve);
                header("refresh:2; url=usuario.php");
            }else{
                echo 'Introduzca el id de la reserva para poder eliminarla';
                header('refresh:2, url=usuario.php');
            }
        }

        /*----Eliminar reservas seleccionadas----*/
        if(isset($_POST['removeSelection'])){;
            if(isset($_POST['idReserve'])){
                $idReserve=$_POST['idReserve'];
                foreach ($idReserve as $id){
                    $consultReserve->removeReserveSelected($id);
                    header('refresh:2; url=usuario.php');
                }
            }else{
                echo 'No se ha seleccionado ninguna reserva que eliminar';
                header('refresh:2; url=usuario.php');
            }
        }

        /*----Cerrar sesión----*/
        if(isset($_POST['closeSession'])){
            $consultUser->closeUserSession();
        }
        

        /*----MOSTRAR EN LA INTERFAZ----*/
        echo "<div>
                <form action='administrador.php' method='post'>
                    <button class='btn-close' type='submit' name='closeSession'>Cerrar sesión</button>
                </form>
            </div>";
                
        /*----FORMULARIOS----*/
        $forms->formAddReserve();
        $forms->formRemoveReserve();

    ?>

</body>
</html>