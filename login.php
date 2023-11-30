<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Login</title>
</head>
<body>
    <?php
        session_start();

        require_once ('connection.php');
        require_once ('createTables.php');
        require_once ('consultUser.php');
        

        $connection=new Connection();
        $connection->veryfyConnection();
        $connection->createDB();

        /*--Crear tablas sino existen--*/
        $crear=new Crear(); 
        $crear->create(); 

        $consultUser=new User();

        echo "<form action='' method='post'>
                <fieldset>
                    <legend>Login</legend>
                    <label for='user'>
                        <input type='text' name='user' id='user'>
                    </label>
                    <label for='password'>
                        <input type='text' name='password' id='password'>
                    </label>
                    
                    <button class='btn-login' type='submit' name='consultUser'>Login</button>
                </fieldset>
            </form>";
        
            
            if(isset($_POST['consultUser'])){
                
                //Comprobar y asignar valores del formulario
                if (!empty($_POST['user']) && !empty($_POST['password'])){

                    //Detectar caracteres sospechosos
                    $_SESSION['$user']=$_POST['user']; 
                    $_SESSION['$password']=$_POST['password'];

                    //Consultar si existe el usuario y su tipo.
                    $consultUser->consultUser($_SESSION['$user'], $_SESSION['$password']); 
                    
                    //Cerrar conexión a base de datos
                    $connection->closeConnection();

                }else{
                    echo 'Rellene todos los campos';
                }
            }
    ?>
    
</body>
</html>