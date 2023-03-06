<?php
//Iniciamos o nos unimos a la sesión
session_start();
if (isset($_SESSION["token"]) && isset($_SESSION["user"])) {//Si la sesión existe le redirijo directamente a home.php
    header("Location: ./pages/index.php");
}
//Añado la libreria de funciones
require_once "../resources/library/functions/funciones.php";
//Añado las clases necesarias
require_once "../resources/library/db/DB.php";
require_once "../resources/library/model/UserModel.php";
require_once "../resources/library/model/User.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {//Si recibe un método POST
    //Guardo el usuario y contraseña introducidos
    $userLogin = filtrarInput("userLogin", "POST");
    $passLogin = filtrarInput("passLogin", "POST");
    try {//Intentamos conectarnos a la DB
        //Instanciamos el usuario Modal y comprobamos si existe un usuario con las credenciales introducidas
        $userModel = new UserModel();
        $user = $userModel->getUserLogin($userLogin, $passLogin);
        unset($userModel);//Destruyo la instancia a la clase Modal
        if ($user) {//Si el usuario u la pass son correctas
            //Escribo el acceso correcto en log_in.log:
            writeLogInLog($userLogin, true);
            //Guardo el usuario (user y Rol) y el token en la sesión
            $_SESSION["user"] = $user;
            $_SESSION["token"] = hash("sha256", session_id() . date("Y-n-j H:i:s")); //Guardo el token de la sesión
            //Guardamos dos cookies: una con la hora de login del usuario y otra con la de la última actividad (en el login serán ambas la misma hora)
            setcookie("horaLogin", date("Y-n-j H:i:s"), time() + 3600 * 24, "/");
            setcookie("horaUltimaActividad", date("H:i:s"), time() + 3600 * 24, "/");
            //Redirigimos a index.php:
            header("Location: ./pages/index.php");
        } else {//Si la contraseña y/o el usuario no son correctos
            //Escribo el acceso correcto en log_in.log:
            writeLogInLog($userLogin, false);
            $loginError = true;
        }
    } catch (Exception $ex) {//Si la DB no está disponible o ha habido algún error para conectar a la DB
        $errorDB = true;
    }

}
?>

<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>UT6.1 Empresa | Login</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
        <link rel="stylesheet" href="./css/style.css">
        <link rel="stylesheet" href="./css/login.css">

    </head>
    <body class="container-fluid bg-dark bg-gradient p-0 m-0">
        <?php
// put your code here
        ?>

        <div class="row col-5 border border-3 rounded position-absolute top-50 start-50 translate-middle p-5 login">
            <h1 class=" row fs-3 mb-5 justify-content-center login__header">Ejercicio Empresa</h1>
            <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home"
                            type="button" role="tab" aria-controls="pills-home" aria-selected="true">Iniciar Sesión</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link " id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile"
                            type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Registrate</button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                     tabindex="0">
                    <!-- Form de Inicio de sesión -->
                    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" class="form text-dark">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control bg-light opacity-75" id="floatingInput" placeholder="User" name="userLogin">
                            <label for="floatingInput" class="ps-4"><i class="bi bi-person-circle"></i> Usuario</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control bg-light opacity-75" id="floatingPassword"
                                   placeholder="Password" name="passLogin">
                            <label for="floatingPassword" class="ps-4"> <i class="bi bi-key-fill"></i> Contraseña</label>
                        </div>
                        <?php
                        if (isset($loginError) && $loginError) {//Credenciales incorrectas
                            echo '<div class="row p-2">
                                <p class="text-danger m-0"> * Usuario y/o contraseña incorrecta</p>
                              </div>';
                        } else if (isset($errorDB) && $errorDB) {//Error al conectarse a la BD
                            echo '<div class="row p-2">
                                <p class="text-danger m-0"> **Base de Datos en manetnimiento, por favor, intentelo de nuevo más tarde**</p>
                              </div>';
                        }
                        ?>
                        <div class="mb-3 form-check py-2 mt-1 color-white">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label text-light" for="exampleCheck1">Recuerdame</label>
                        </div>
                        <div class="row">
                            <button type="submit" class="btn btn-outline-light m-auto mt-2 mx-auto col-5 fs-5 py-2">Iniciar
                                Sesión</button>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                    <!-- Form de Registro -->
                    <form class="form text-dark" method="GET" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                        <div class="row justify-content-between mb-3">
                            <div class="col-5 form-floating px-1">
                                <input type="text" class="form-control bg-light opacity-75" id="inputName" placeholder="Nombre"
                                       required>
                                <label class="ps-4" for="inputName">Nombre</label>
                            </div>
                            <div class="col-7 form-floating px-1">
                                <input type="text" class="form-control bg-light opacity-75" id="inputApellidos" placeholder="Apellidos"
                                       required>
                                <label class="ps-4" for="inputApellidos">Apellidos</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 form-floating px-1">
                                <input type="email" class="form-control bg-light opacity-75" id="inputEmail" placeholder="Email"
                                       required>
                                <label class="ps-4" for="inputEmail"><i class="bi bi-envelope fs-5"></i>
                                    Email</label>
                            </div>
                        </div>
                        <div class="row justify-content-between mb-3">
                            <div class="col-6 form-floating px-1">
                                <input type="text" class="form-control bg-light opacity-75" id="exampleInputUser2" placeholder="Usuario"
                                       required>
                                <label class="ps-4" for="exampleInputUser2"><i class="bi bi-person fs-5"></i>
                                    Usuario</label>
                            </div>
                            <div class="col-6 form-floating px-1">
                                <input type="password" class="form-control bg-light opacity-75" id="exampleInputPassword2"
                                       placeholder="Contraseña" required>
                                <label class="ps-4" for="exampleInputPassword2"><i class="bi bi-key fs-5"></i>
                                    Contraseña</label>
                            </div>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                            <label class="form-check-label text-light" for="flexSwitchCheckDefault">Quiero recibir newsletters semanales con
                                todas las ofertas</label>
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckCheckedDisabled" checked
                                   disabled required>
                            <label class="form-check-label text-light" for="flexSwitchCheckCheckedDisabled">He leído y acepto la <a
                                    href="#">Política de Privacidad</a> de la empresa</label>
                        </div>
                        <div class="border-0 mx-auto d-flex justify-content-center p-3 pb-4">
                            <button type="submit"
                                    class="btn btn-outline-light m-auto mt-2 mx-auto col-5 fs-5 py-2">Registrate</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
    </body>
</html>
