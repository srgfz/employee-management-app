<?php

//Iniciamos o nos unimos a la sesión
session_start();
if (!isset($_SESSION["token"]) || $_SESSION["user"]["Rol"] != 1) {//Si la sesión no existe o su rol no es admin hago logOut
    header("Location: ./logOut.php");
}
//Añado la libreria de funciones
require_once "../../resources/library/functions/funciones.php";
//Añado las clases necesarias
require_once "../../resources/library/model/EmployeeModel.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {//Si recibe un POST
    $emplToEdit = filtrarInput("codEmpl", "POST");
    $errorInput = false;
    $employeeUpdate = filtrarArrayInput("employeeUpdate", ["Nombre", "Apellido1", "Apellido2", "Departamento"], $errorInput);
    //Instanciamos la clase modal de Empleados
    $empModel = new EmployeeModel();
//Comprobamos que el empleado existe en la BD
    if ($errorInput) {//Si hay algún campo en blanco no actualizo el registro y se lo indico al usuario
        //Destruyo la instancia a la clase modal
        unset($empModel);
        header("Location: ./index.php?errorInput=1");
    } else if ($empModel->getEmployee($emplToEdit)) {//Si el empleado existe en la BD
        //Editamos el empleado
        $empModel->editEmployee($emplToEdit, $employeeUpdate);
        //Destruyo la instancia a la clase modal
        unset($empModel);
        //Le redirijimos al index
        header("Location: ./index.php?emplUpdated=1");
    } else {//Si el empleado no existe en la BD
        //Destruyo la instancia a la clase modal
        unset($empModel);
        //Le redirijimos al index indicando el  error
        header("Location: ./index.php?emplUpdated=0");
    }
} else {//Si no recibe un POST hacemos logOut
    header("Location: ./logOut.php");
}






