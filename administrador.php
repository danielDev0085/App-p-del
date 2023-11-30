<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Admin</title>
</head>
<body>
    <?php
        session_start();

        /*----Archivos requeridos----*/
        require_once('consultUser.php');
        require_once('consultCourt.php');
        require_once ('consultReserves.php');
        require_once('forms.php');

        

        /*----Instancias de clases----*/
        $connection=new Connection();
        $consultUser=new User();
        $consultCourts=new Court();
        $consultReserves=new Reserve();
        $forms= new Form();


        /*----Añadir usuario----*/
        if(isset($_POST['add'])){
            if(!empty($_POST['userNameAdd']) && !empty($_POST['passwordAdd'])){
            //Obtener datos del formulario
            $userName=$_POST['userNameAdd'];
            $password=$_POST['passwordAdd'];

            //Añadir usuario y refrescar página
            $consultUser->addUser($userName, $password);
            header('refresh:2, url=administrador.php');

            }else{
                echo 'Rellene todos lo campos para añadir el usuario';
            }
        }
        
        /*----Actualizar usuario----*/
        if(isset($_POST['update'])){
            if($_POST['userIdUpdate']!='' && $_POST['userNameUpdate']!='' && $_POST['passwordUpdate']!='' && $_POST['typeUpdate']!=''){
                //Obtener todos los valores del formulario
                $id=$_POST['userIdUpdate'];
                $userName=$_POST['userNameUpdate'];
                $password=$_POST['passwordUpdate'];
                $type=$_POST['typeUpdate'];

                //Obtener el usuario por el id
                $user=$consultUser->getUserById($id);
                if(mysqli_num_rows($user)==0){
                    echo 'No existe ningún usuario con ese id';
                    header('refresh:2; url=administrador.php');
                }else{
                    $consultUser->updateUser($id, $userName, $password, $type);
                    header('refresh:2; url=administrador.php');
                }
            }else{
                echo 'Rellene todos lo campos para modificar el usuario';
            }
        }
        
        /*----Eliminar usuario----*/
        if(isset($_POST['remove'])){
            if(!empty($_POST['userIdRemove'])){
                $id=$_POST['userIdRemove'];

                $user=$consultUser->getUserById($id);
                if(mysqli_num_rows($user)==0){
                    echo 'No existe ningún usuario con ese id';
                    header('refresh:2; url=administrador.php');
                }else{
                    $consultUser->removeUser($id);
                    header('refresh:2; url=administrador.php');
                }
            }else{
                echo 'Digite el id para eliminar el usuario';
            }
        }
            
        /*----Añadir pista----*/
        if(isset($_POST['addCourt'])){
            if(!empty($_POST['courtName'])){
                $courtName=$_POST['courtName'];
                $consultCourts->addCourt($courtName);
                header('refresh:2; url=administrador.php');
            }else{
                echo 'Introduzca el nombre para añadir la pista';
                header('refresh:2; url=administrador.php');
            }
        }

        /*----Actualizar pista----*/
        if(isset($_POST['updateCourt'])){
            if(!empty($_POST['courtIdUpdate']) && !empty($_POST['courtNameUpdate']) ){
                $id=$_POST['courtIdUpdate'];
                $courtName=$_POST['courtNameUpdate'];

                //Obtener la pista a través del id
                $courts=$consultCourts->getCourtsbyId($id);
               
                if(mysqli_fetch_array($courts)==0){
                    echo 'No hay pistas con el id introducido';
                }else{
                    //Actualizar pista
                    $consultCourts->updateCourt($id, $courtName);
                    header('refresh:2; url=administrador.php');
                }
                
            }else{
                echo 'Rellene todos los campos para actualizar la pista';
                header('refresh:2; url=administrador.php');
            }
        }
        
        /*----Eliminar pista----*/
        if(isset($_POST['removeCourt'])){
            if(!empty($_POST['courtIdRemove'])){
                $id=$_POST['courtIdRemove'];
                $consultCourts->removeCourt($id);
                header('refresh:2; url=administrador.php');
                exit;
            }else{
                echo 'Introduzca el id para eliminar la pista';
                header('refresh:2; url=administrador.php');
            }
        }


        /*----Eliminar todas las reservas----*/
        if(isset($_POST['removeAll'])){
            //Obtener todas las reservas
            $rows=$consultReserves->getReserve();

            if(mysqli_num_rows($rows)==0){
                echo 'No hay reservas que eliminar';
                header('refresh:2; location:administrador.php');
            }else{
                $consultReserves->removeAllReserves();
                header('refresh:2; location:administrador.php');
            }
        }

        
        /*----Eliminar reservas seleccionadas----*/
        if(isset($_POST['removeSelection'])){;
            if(isset($_POST['idReserve'])){
                $idReserve=$_POST['idReserve'];
                foreach ($idReserve as $id){
                    $consultReserves->removeReserveSelected($id);
                    header('refresh:2; location:administrador.php');
                }
            }else{
                echo 'No se ha seleccionado ninguna reserva que eliminar';
                header('refresh:2; location:administrador.php');
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

        /*----TABLAS----*/
        echo '<div class=container-tables>';

            /*--Mostrar usuarios en una tabla--*/
            $consultUser->showUsers();

            /*--Mostrar tabla de pistas--*/
            $consultCourts->showCourts();

            /*--Mostrar tabla de reservas--*/
            $consultReserves->showReserves();

        echo '</div>';


        /*----FORMULARIOS----*/
        $forms->formAddUser();
        $forms->formUpdateUSer();
        $forms->formRemoveUser();

        $forms->formAddCourt();
        $forms->formUpdateCourt();
        $forms->formRemoveCourt();

        $forms->formReserves();
    ?>
</body>

</html>