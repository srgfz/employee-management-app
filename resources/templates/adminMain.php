<?php

//Muestro los mensajes al usuario en caso de error o éxito de la opración
if (isset($emplDeleted) && $emplDeleted) {//Si se ha borrado el empleado
    echo "<p class='ps-5 text-info'> * Empleado eliminado correctamente</p>";
} else if (isset($emplDeleted) && !$emplDeleted) {//Si no se ha podido borrar el empleado
    echo "<p class='ps-5 text-danger'> * El empleado que ha intentado eliminar ya había sido eliminado previamente</p>";
} else if (isset($emplUpdated) && $emplUpdated) {//Si se ha modificado el empleado
    echo "<p class='ps-5 text-info'> * Empleado editado correctamente</p>";
} else if (isset($emplUpdated) && !$emplUpdated) {//Si no se ha modificado el empleado
    echo "<p class='ps-5 text-danger'> * El empleado que ha intentado modificar ha sido eliminado previamente</p>";
} else if (isset($errorInput) && $errorInput) {
    echo "<p class='ps-5 text-danger'> * Debe rellenar todos los campos para editar un registro</p>";
}
//Muestro el listado
if ($typeItemsToShow === "deps") {//Listar Departamentos
    if (isset($deps) && $deps) {
        listDepartaments($deps);
    } else {
        echo "<p class='p-3 text-center'> - - - Actualmente no hay ningún registro de departamentos - - - </p>";
    }
} else {//Listar Empleados
    foreach ($deps as $dep) {//Compruebo si hay algún empleado que listar
        if($dep->getEmpls()){
            $listEmployees=true;
        }
    }
    if (isset($listEmployees) && $listEmployees) {
        listEmployees($deps,);
    } else {
        echo "<p class='p-3 text-center'> - - - Actualmente no hay ningún registro de empleados - - - </p>";
    }
}