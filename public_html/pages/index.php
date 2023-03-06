<?php
//Iniciamos o nos unimos a la sesión
session_start();
if (!isset($_SESSION["token"])) {//Si la sesión no existe le redirijo directamente a login.php
    header("Location: ./logOut.php");
}
//Añado la libreria de funciones
require_once "../../resources/library/functions/funciones.php";

//Actualizo la hora de última Actividad:
setcookie("horaUltimaActividad", date("H:i:s"), time() + 3600 * 24, "/");

//Guardo en una variable la hora de última actividad
$ultimaConexion = isset($_COOKIE["horaUltimaActividad"]) ? $_COOKIE["horaUltimaActividad"] : null;

//Guardo en una variable el rol del usuario
$rol = isset($_SESSION["user"]["Rol"]) ? $_SESSION["user"]["Rol"] : null;
if ($rol == 1) {//Rol de usuario administrador
    //Añado las clases necesarias
    require_once "../../resources/library/db/DB.php";
    require_once "../../resources/library/model/EmployeeModel.php";
    require_once "../../resources/library/model/Employee.php";
    require_once "../../resources/library/model/DepartmentModel.php";
    require_once "../../resources/library/model/Department.php";

//Guardo los objetos departamentos con un array con los empleados que pertenecen a dicho departamento:
//Instanciamos el departamento Modal
    $depModel = new DepartmentModel();
    $empModel = new EmployeeModel();
    $deps = [];
    $empls = [];
//Instancio y guardo los departamentos devueltos en el array $deps
    foreach ($depModel->getAll() as $dep) {//Recorro la respuesta de la BD de todos los departamentos
        //Creo el objeto empleados y lo añado al array $empls
        foreach ($empModel->getEmployeesFromDept($dep["CodDept"]) as $emp) {//Recorro cada empleado de ese departamento y voy añadiendolo a $empls
            $empls[] = new Employee($emp['CodEmple'], $emp['Nombre'], $emp['Apellido1'], $emp['Apellido2'], $emp['Departamento']);
        }
        //Creo los departamentos con todos sus atributos y los voy añadiendo al array $deps
        $deps[] = new Department($dep["CodDept"], $dep["Nombre"], $dep['Jefe'], $dep["Presupuesto"], $dep["Ciudad"], $empls);
        $empls = []; //Reseteo los empleados
    }
    //Destruyo las instancias Modales
    unset($depModel, $empModel);

    if ($_SERVER["REQUEST_METHOD"] == "GET") {//Si recibe un GET
        $typeItemsToShow = filtrarInput("show", "GET");
        $emplDeleted = filtrarInput("emplDeleted", "GET");
        $emplUpdated = filtrarInput("emplUpdated", "GET");
        $errorInput = filtrarInput("errorInput", "GET");
    }
} else if ($rol == 0) {//Rol de usuario normal
    if ($_SERVER["REQUEST_METHOD"] == "GET") {//Si recibe un GET
        $emailSent = filtrarInput("emailSent", "GET");
        $emailInput = filtrarInput("emailInput", "GET");
        $email = filtrarInput("email", "GET");
    }
} else {//Si no es ninguno de los dos roles hago logOut
    header("Location: ./logOut.php");
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>HUT6.1 Empresa | Home</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>

    <body class="container-fluid bg-dark bg-gradient p-0 m-0">
        <!-- Comienzo del Header -->
        <?php
        if ($rol == "1") {//Si es administrador
            //Inluyo la cabecera de admin
            include "../../resources/templates/adminHeader.php";
        } else {//Si no es ninguna de las dos hago logout
            include "../../resources/templates/userHeader.php";
        }
        ?>
        <main class="mx-auto py-2">
            <?php
            //Muestro la fecha y hora de la última conexión
            echo "<p class='text-center pt-3'><span class='fw-bold'>Hora de la última conexión: </span>$ultimaConexion</p>";
            if ($rol == 1) {//Si es administrador
                include "../../resources/templates/adminMain.php";
            } else {//Si es un usuario normal
                include "../../resources/templates/userMain.php";
            }
            ?>

        </main>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    </body>

</html>
