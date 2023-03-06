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
require_once "../../resources/library/model/DepartmentModel.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {//Si recibe un GET
    $emplToDelete = filtrarInput("codEmpl", "GET");
    //Instanciamos la clase modal de Empleados y de departamentos
    $empModel = new EmployeeModel();
    $depModel = new DepartmentModel();
//Comprobamos que el empleado existe en la BD
    if ($empModel->getEmployee($emplToDelete)) {//Si el empleado existe en la BD
        //Comprobamos si el empleado a eliminar es el jefe de un departamento:
        $department = $depModel->getManager($emplToDelete);
        if ($department) {//Si es el jefe de un departamento primero modifico el jefe de departamento a null y luego borro el empleado
            $depModel->editDepartment($department["CodDept"], ["Jefe" => null]);
        }
        //Borramos el empleado
        $empModel->removeEmployee($emplToDelete);
        //Destruyo las instancias a las clases modales
        unset($depModel, $empModel);
        //Le redirijimos al index
        header("Location: ./index.php?emplDeleted=1");
    } else {//Si el empleado no existe en la BD
        //Destruyo las instancias a las clases modales
        unset($depModel, $empModel);
        //Le redirijimos al index indicando el  error
        header("Location: ./index.php?emplDeleted=0");
    }
} else {//Si no recibe un GET hacemos logOut ya que la única manera de acceder a esta página es empleando un GET
    header("Location: ./logOut.php");
}





