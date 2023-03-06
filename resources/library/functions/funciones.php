<?php

/**
 * filtrarInput() --> función para filtrar un input mediante htmlspecialchars()
 * @param type string $input --> nombre de la variable input a filtrar
 * @param type string $metodo --> Para indicar el método utilizado ("GET" o "POST")
 * @return type string --> Devuelve la variable del input filtrada
 */
function filtrarInput($input, $metodo) {
    if ($metodo === "POST") {//Si el método es POST
        $variableFiltrada = isset(filter_input_array(INPUT_POST)[$input]) ? htmlspecialchars(filter_input_array(INPUT_POST)[$input]) : null;
    } else if ($metodo === "GET") {//Si el método es GET
        $variableFiltrada = isset(filter_input_array(INPUT_GET)[$input]) ? htmlspecialchars(filter_input_array(INPUT_GET)[$input]) : null;
    }
    return $variableFiltrada;
}

/**
 * filtrarArrayInput() --> función para filtrar un input POST tipo array. Filtra hasta dos niveles de array anidados con htmlspecialchars() y si las $clavesAComprobar están vacias (1 nivel)
 * @param type string $arrayInputName --> nombre de la variable array a filtrar
 * @param type array $clavesAComprobar --> array con las claves de los campos que se quiere comprobar si están vacíos
 * @param type boolean $errorInputVacio --> referencia a un booleano. Será false si alguno de las claves a comprobar está vacía
 * @return type array --> Devuelve el array POST filtrado y puede cambiar el valor del parámetro que pasemos como $errorInputVacio
 */
function filtrarArrayInput($arrayInputName, $clavesAComprobar, &$errorInputVacio) {
    $arrayInputs = isset(filter_input_array(INPUT_POST)[$arrayInputName]) ? filter_input_array(INPUT_POST)[$arrayInputName] : null;
    if (isset($arrayInputs)) {//Si el array existe
        //Filtro con htmlspecialchars todos los campos del array
        foreach ($arrayInputs as &$value) {
            $value = htmlspecialchars($value);
        }
        //Compruebo si los campos necesarios existen y si están vacios
        foreach ($clavesAComprobar as $inputs) {
            if (!isset($arrayInputs[$inputs]) || (isset($arrayInputs[$inputs]) && trim($arrayInputs[$inputs]) == "")) {//Si no existe o si existe y está vacio
                $errorInputVacio = true; //Cambio el valor del error a true
            }
        }
    }
    return $arrayInputs;
}

/**
 * writeLogInLog() --> Función para escribir el .log con datos de los intentos de inicio de sesión exitosos y los erróneos
 * @param type $nameUser --> User introducido en el intento de Log In
 * @param type $logIn --> será true en caso de que el inicio de sesión hubiera sido exitoso, en caso contrario será false
 */
function writeLogInLog($nameUser, $logIn) {
    $log = fopen(__DIR__."/../../../logs/log_in.log", "a"); //Abro el fichero y si no existe lo creo
    if (file_exists(__DIR__."/../../../logs/log_in.log")) { //Si el archivo se ha creado correctamento escribo en él
        if ($logIn) {//Si ha iniciado sesión correctamente
            fwrite($log, "- " . date('F j, Y, g:i a') . " --> El usuario $nameUser ha iniciado sesión CORRECTAMENTE \n"); //Escribo en el log
        } else {//Si las credenciales no eran correctas
            fwrite($log, "- " . date('F j, Y, g:i a') . " --> El usuario $nameUser ha intentado iniciar sesión de forma ERRÓNEA \n"); //Escribo en el log
        }
        fclose($log); //Cierro el archivo
    }
}

/**
 * showSelectDepartments() --> Función para mostrar un Select con los departamentos $depts
 * @param type $label --> Nombre de le etiqueta del select
 * @param type $depts --> Array con todos los options que queramos mostrar
 * @param type $selected --> Option seleccionada
 * @param type $inputName --> Nombre que queremos que tenga el name del select
 */
function showSelectDepartments($label, $depts, $selected, $inputName) {//Función para imprimir select y seleccionar una si ya la había elegido previamente
    echo "<div class='col-2'><span class='fw-bold'>$label: </span>";
    echo "<select name='employeeUpdate[$inputName]' class='bg-secondary bg-opacity-25 rounded col-6 px-2 text-dark ms-3'>";
    foreach ($depts as $dept) {
        if ($dept->getCod() == $selected) {
            echo "<option value=" . $dept->getCod() . " selected>" . $dept->getName() . "</option>";
        } else {
            echo "<option value=" . $dept->getCod() . ">" . $dept->getName() . "</option>";
        }
    }
    echo "</select></div>";
}

/**
 * listDepartmentItem() --> Función para mostrar en HTML cada campo del departamento
 * @param type $label --> Nombre de la etiqueta del campo
 * @param type $value --> Valor del campo
 * @param type $presupuesto --> Moneda utilizada para mostrar el presupuesto
 */
function listDepartmentItem($label, $value, $presupuesto = "") {
    echo "<div><span class='fw-bold'>$label: </span>";
    echo "<span>$value $presupuesto</span></div>";
}

/**
 * listEmplyoeeItem() --> Función para mostrar en HTML cada campo del empleado
 * @param type $label --> Nombre de la etiqueta del campo
 * @param type $value --> Valor del campo
 * @param type $input --> será true si queremos que meustre el valor dentro de un input, en caso contrario y por defecto será false
 * @param type $inputName --> Nombre que queremos que tenga el input, por defecto será null
 */
function listEmplyoeeItem($label, $value, $input = false, $inputName = null) {
    echo "<div class='col-2'><span class='fw-bold'>$label: </span>";
    if ($input) {//Si quiero mostrar la información en un input
        echo "<input type='text' value='$value' placeholder='$value' name='employeeUpdate[$inputName]' class='bg-secondary bg-opacity-25 rounded col-10 px-2 text-dark ms-3'>";
    } else {//Si quiero mostrar la información en texto normal
        echo "<span class='ms-3'>$value</span>";
    }
    echo "</div>";
}

/**
 * listEmployees() --> Función para listar los empleados de cada departamento
 * @param type $depts --> Array con los objetos departamento, que contendrán un array todos los empleados correspondiente a dicho departamento y que deseamos mostrar
 */
function listEmployees($depts) {
    echo '<ul class="list-group col-10 mx-auto gap-4">';
    foreach ($depts as $dept) {//Recorro los departamentos
        foreach ($dept->getEmpls() as $empl) {//Recorro cada empleado de departamento
            echo '<li class="list-group-item rounded py-3 shadow-sm">';
            echo "<form class='d-flex flex-row justify-content-between align-items-center flex-wrap m-0' method='POST' action='./editEmployee.php'>";
            showModalToRemoveItem($empl);
            //Pasamos el código del empleado a editar como un input oculto:
            echo "<input type='hidden' value='" . $empl->getCod() . "' name='codEmpl'>";
            //Mostramos los campos que queramos: los que van a poder ser modificados los mostramos en inputs y los que no los mostramos como texto
            listEmplyoeeItem("Código de Empleado", $empl->getCod());
            listEmplyoeeItem("Nombre", $empl->getName(), true, "Nombre");
            listEmplyoeeItem("Primer Apellido", $empl->getLastname1(), true, "Apellido1");
            listEmplyoeeItem("Segundo Apellido", $empl->getLastname2(), true, "Apellido2");
            showSelectDepartments("Departamento", $depts, $dept->getCod(), "Departamento");

            echo "<input type='submit' value='Editar' class='btn btn-outline-dark mt-2 py-2'></form></li>";
        }
    }
    echo '</ul>';
}

/**
 * listDepartaments() --> Función para listar los departamentos
 * @param type $depts --> Array con todos los objetos departamento que queremos mostrar
 */
function listDepartaments($depts) {
    echo '<ul class="list-group col-10 mx-auto gap-4">';
    foreach ($depts as $dept) {
        echo '<li class="list-group-item d-flex flex-row justify-content-around align-items-center rounded flex-wrap py-3">';
        //Vamos mostrando cada campo:
        listDepartmentItem("Código de departamento", $dept->getCod());
        listDepartmentItem("Nombre", $dept->getName());
        //Para el jefe muestro su nombre completo:
        $managerName = null; //Reseteo el nombre del jefe porque puede que haya departamentos sin él
        foreach ($dept->getEmpls() as $emp) {//Recorro los empleados
            if ($dept->getCodManager() == $emp->getCod()) {//Guardo el nombre del jefe
                $managerName = $emp->getName() . " " . $emp->getLastname1() . " " . $emp->getLastname2();
            }
        }
        if (isset($managerName)) {//Si el departamento tiene algún jefe
            listDepartmentItem("Jefe", $managerName);
        } else {//Si el departemento no tiene jefe
            listDepartmentItem("Jefe", " ***Puesto Vacante***");
        }
        listDepartmentItem("Presupuesto", $dept->getBudget(), "€");
        listDepartmentItem("Ciudad", $dept->getCity());
        listDepartmentItem("Número de empleados", count($dept->getEmpls()));
        echo "</li>";
    }
    echo '</ul>';
}

/**
 * showModalToRemoveItem() --> Función para imprimir el botón modal y el modal de confiramción para eliminar un registro
 * @param type $itemToRemove --> Objeto que queremos eliminar de la BD
 */
function showModalToRemoveItem($itemToRemove) {
    echo'<button type="button" class="btn btn-outline-danger me-4" data-bs-toggle="modal" data-bs-target="#' . $itemToRemove->getName() . $itemToRemove->getCod() . '">
  <i class="bi bi-trash3-fill"></i>
</button>';
    echo '<div class="modal fade" id="' . $itemToRemove->getName() . $itemToRemove->getCod() . '" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title fs-5">Confirmación para eliminar un registro</h2>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Realmente desea eliminar de la base de datos el registro de ' .
    "<div class='fw-bold fs-5'>" . $itemToRemove->getName() . " " . $itemToRemove->getLastName1() . " " . $itemToRemove->getLastName2() .
    " (Código de Empleado: " . $itemToRemove->getCod() . ")</div>"
    . '</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a href="./removeEmployee.php?codEmpl=' . $itemToRemove->getCod() . '" class="btn btn-primary">Eliminar Empleado</a>
      </div>
    </div>
  </div>
</div>';
}

/**
 * emailForm() --> Función para mostrar el formulario de envio de email
 */
function emailForm() {
    echo '<form class="bg-secondary col-6 mx-auto p-5 py-4 rounded" action="./sendEmail.php" method="POST">
        <div class="mb-3">
            <label for="controlInput1" class="form-label">Destinatario del Email</label>
            <input type="email" class="form-control" id="controlInput1" placeholder="email@gmail.com" name="email[gmail]">
          </div>
          <div class="mb-3">
            <label for="controlInput2" class="form-label">Asunto del Email</label>
            <input type="text" class="form-control" id="controlInput2" placeholder="Asunto" name="email[subject]">
          </div>
          <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Cuerpo del Email</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="10" placeholder="Cuerpo del mensaje" name="email[body]"></textarea>
          </div>
          <div class="row"><button type="submit" class="bg-dark btn btn-secondary btn-lg mx-auto border border-primary col-5">Enviar</button></div>
        </form>';
}
