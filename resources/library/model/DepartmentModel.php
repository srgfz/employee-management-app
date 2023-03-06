<?php

//Añado la base de datos
require_once __DIR__ . '/../db/DB.php';

class DepartmentModel {

    //Atributos
    private $db;

    //Constructor
    public function __construct() {
        $this->db = new DB();
    }

    //Métodos de la clase

    /**
     * getAll() --> Método para obtener todos los departamentos con todos sus campos de la tabla departamentos
     * @return --> devuelve un array multidimensional con todos los registros resultantes de ejecutar la consulta $query
     */
    public function getAll() {
        $query = $this->db->query("SELECT * FROM departamentos;");
        //Cierro la BD
        unset($his->db);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * getManager() --> Método para obtener los campos del departamento y del empleado del jefe de un departamento
     * @param type $codManager --> código de empleado del jefe de departamento
     * @return type --> devuelve el array asociativo/objeto del empleado correspondiente al código de empleado $codManager
     */
    public function getManager($codManager) {
        $query = $this->db->query('SELECT * FROM departamentos INNER JOIN empleados ON departamentos.Jefe = empleados.codEmple WHERE Jefe = :codManager GROUP BY empleados.CodEmple', [
            ':codManager' => $codManager
        ]);
        //Cierro la BD
        unset($his->db);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * editDepartment() --> Método para editar un departamento cuyo código de departamento es $cod con los valores de $arrayNewValues
     * @param type $cod --> Código del departamento que se desea modificar
     * @param type $arrayNewValues --> Array con los nuevos valores. Las claves de los valores deben ser iguales al nombre de los campos de la BD
     */
    public function editDepartment($cod, $arrayNewValues) {
        $values = "";
        //Guardamos los valores que vamos a actualizar
        foreach ($arrayNewValues as $key => $value) {//Concatenamos el nombre de los campos (su clave) y los valores de dichas variables
            if (is_string($value)) {
                $values .= "$key = '$value'";
            } else if (is_numeric($value)) {
                $values .= "$key = $value";
            } else if (is_null($value)) {
                $values .= "$key = null";
            }
            if ($key !== array_key_last($arrayNewValues)) {//Si no es el último valor del array pongo la coma
                $values .= ", ";
            }
        }
        echo $values;
        //Ejecutamos la query
        $query = $this->db->query("UPDATE departamentos SET $values  WHERE CodDept = :cod", [
            ':cod' => $cod
        ]);
        //Cierro la BD
        unset($his->db);
    }

}
