<?php
    require_once "consultCourt.php";

    $consultCourt=new Court();
    
    class Form extends Connection{

        function __construct(){
            parent::__construct();
        }

    /*----ADMINISTRADOR----*/

        /*----FORMULARIOS DE USUARIO----*/
        function formAddUser(){
            echo "
            <hr>
            <div class='container-form'>
                <div class='form'>
                    <h2>Gestión de usuarios</h2>
    
                    <form action='' method='post'>
                        <fieldset>
                            <legend>Añadir usuario</legend>
                            <div class='label'>
                                <label for='userNameAdd'>Nombre:
                                    <input type='text' name='userNameAdd' id='userNameAdd'>
                                </label>
                            </div>
                            <div class='label'>
                                <label for='passwordAdd'>Password:
                                    <input type='text' name='passwordAdd' id='passwordAdd'>
                                </label>
                            </div>
    
                            <button class='btn-add' type='submit' name='add'>Añadir usuario</button>
                        </fieldset>
                    </form>";
        }

        function formUpdateUSer(){
            echo "
                <form action='' method='post'>
                    <fieldset>
                        <legend>Actualizar usuario</legend>
                        <div class='label'>
                            <label for='userIdUpdate'>Id:
                                <input type='text' name='userIdUpdate' id='userIdUpdate' value=''>
                            </label>
                        </div>
                        <div class='label'>
                            <label for='userNameUpdate'>Nombre:
                                <input type='text' name='userNameUpdate' id='userNameUpdate' value=''>
                            </label>
                        </div>
                        <div class='label'>
                            <label for='passwordUpdate'>Password:
                                <input type='text' name='passwordUpdate' id='passwordUpdate' value=''>
                            </label>
                        </div>
                        <div class='label'>
                            <label for='typeUpdate'>Tipo:
                                <input type='text' name='typeUpdate' id='typeUpdate' value=''>
                            </label>
                        </div>

                        <button class='btn-update' type='submit' name='update'>Modificar usuario</button>
                    </fieldset>
                </form>";
        }

        function formRemoveUser(){
            echo "
                <form action='' method='post'>
                    <fieldset>
                        <legend>Eliminar usuario</legend>
                        <div class='label'>
                            <label for='userIdRemove'>Id:
                                <input type='text' name='userIdRemove' id='userIdRemove'>
                            </label>
                        </div>

                        <button class='btn-remove' type='submit' name='remove'> Eliminar usuario</button>
                    </fieldset>
                </form>
            </div>";
        }


        /*----FORMULARIOS DE PISTAS----*/

        function formAddCourt(){
            echo"
            <div class='form'>
                <!----FORMULARIOS DE PISTAS---->
                <h2>Gestión de pistas</h2>

                <form action='' method='post'>
                    <fieldset>
                        <legend>Añadir pista</legend>
                        <div class='label'>
                            <label for='courtName'>Nombre:
                                <input type='text' name='courtName' id='courtName'>
                            </label>
                        </div>

                        <button class='btn-add' type='submit' name='addCourt'>Añadir pista</button>
                    </fieldset>
                </form>";
        }

        function formUpdateCourt(){
            echo "
                <form action='' method='post'>
                    <fieldset>
                        <legend>Actualizar pista</legend>
                        <div class='label'>
                            <label for='courtIdUpdate'>Id:
                                <input type='text' name='courtIdUpdate' id='courtIdUpdate'>
                            </label>
                        </div>
                        <div class='label'>
                            <label for='courtNameUpdate'>Nombre:
                                <input type='text' name='courtNameUpdate' id='courtNameUpdate'>
                            </label>
                        </div>

                        <button class='btn-update' type='submit' name='updateCourt'>Actualizar pista</button>
                    </fieldset>
                </form>";
        }

        function formRemoveCourt(){
            echo "
                <form action='' method='post'>
                    <fieldset>
                        <legend>Eliminar pista</legend>
                        <div class='label'>
                            <label for='courtIdRemove'>Id:
                                <input type='text' name='courtIdRemove' id='courtIdRemove'>
                            </label>
                        </div>

                        <button class='btn-remove' type='submit' name='removeCourt'>Eliminar pista</button>
                    </fieldset>
                </form>
            </div>";
        }

        /*----FORMULARIO DE RESERVAS----*/
        function formReserves(){
            echo "
            <div class='form'>
                <h2>Gestión de reservas</h2>

                <form action='' method='post'>
                    <fieldset>
                        <legend>Gestión de reservas</legend>
                        <div class='container-btn'>
                            
                            <button class='btn-remove-reserve' type='submit' name='removeAll'>Eliminar todas las reservas</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>";
        }
    
    /*----USUARIO----*/
        /*----FORMULARIO AÑADIR RESERVA */
        function formAddReserve(){
            echo "
            <div class='container-form'>
                <form action='' method='post'>
                    <fieldset>
                        <legend>Reservar pista</legend>
                        <div class='label'>
                            <label for='court'> Pista
                                <select name='court' id='court'>
                                    <option value=''>Seleccione una pista</option>";
                                $courts=$GLOBALS['consultCourt']->getCourts();
                                while($row=mysqli_fetch_array($courts)){
                                    extract($row);
                                    echo "<option value=$id_pista>$nombre_pista</option>";
                                }

                        echo "  </select>
                            </label>
                        </div>
                        <div class='label'>
                            <label for='turn'>Hora
                                <select name='turn' id='turn'>
                                    <option value=''>Seleccione un turno</option>
                                    <option value=10>10:00</option>
                                    <option value=11>11:00</option>
                                    <option value=12>12:00</option>
                                    <option value=13>13:00</option>
                                    <option value=14>14:00</option>
                                    <option value=15>15:00</option>
                                    <option value=16>16:00</option>
                                    <option value=17>17:00</option>
                                    <option value=18>18:00</option>
                                    <option value=19>19:00</option>
                                    <option value=20>20:00</option>
                                    <option value=21>21:00</option>
                                </select>
                            </label>
                        </div>
                            <button class='btn-add' type='submit' name='reserve'>Reservar pista</button>
                    </fieldset>
                </form>";
        }

        /*----FORMULARIO ELIMINAR RESERVA----*/
        function formRemoveReserve(){
            echo "
            <form action='' method='post'>
                    <fieldset>
                        <legend>Eliminar reserva</legend>
                        <div class='label'>
                            <label for='idReserve'> Id reserva:
                                <input type='text' name='idReserve' id='idReserve'>
                            </label>
                        </div>
                        <div class='container-btn'>
                            <button class='btn-remove-reserve' type='submit' name='removeReserveId'>Eliminar reserva por id</button>
                        </div>

                    </fieldset>
                </form>
            </div>";
        }

    }
?>