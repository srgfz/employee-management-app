<?php

//Añado la base de datos
require_once __DIR__ . '/../db/DB.php';

class EmployeeModel {

    //Atributos
    private $db;

    //Constructor
    public function __construct() {
        $this->db = new DB();
    }

    //Métodos de la clase

    /**
     * getAll() --> Método para obtener todos los empleados con todos sus campos de la tabla empleados
     * @return type --> devuelve un array multidimensional con todos los registros resultantes de ejecutar la consulta $query
     */
    public function getAll() {
        $query = $this->db->query("SELECT * FROM empleados;");
        //Cierro la BD
        unset($his->db);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * getEmployee() --> Método para obtener los campos del empleado correspondiente al código de empleado $cod
     * @param type $codManager --> código de empleado que se desea consultar
     * @return type --> devuelve el array asociativo/objeto del empleado correspondiente al código de empleado $cod
     */
    public function getEmployee($cod) {
        $query = $this->db->query('SELECT * FROM empleados WHERE codEmple = :cod', [
            ':cod' => $cod
        ]);
        //Cierro la BD
        unset($his->db);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * getEmployeesFromDept() --> Método para obtener todos los empleados de un departamento
     * @param type $codDept --> Código del departamento del que se desean obtener los empleados
     * @return type --> devuelve un array multidimensional con todos los registros resultantes de ejecutar la consulta $query
     */
    public function getEmployeesFromDept($codDept) {
        $query = $this->db->query('SELECT * FROM empleados WHERE Departamento = :codDept', [
            ':codDept' => $codDept
        ]);
        //Cierro la BD
        unset($his->db);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * removeEmployee() --> Método para borrar un empleado de la BD
     * @param type $cod --> Código del empleado que se desea eliminar
     */
    public function removeEmployee($cod) {
        $query = $this->db->query('DELETE FROM empleados WHERE codEmple = :cod', [
            ':cod' => $cod
        ]);
        //Cierro la BD
        unset($his->db);
    }

    /**
     * editEmployee() --> Método para editar un empleado cuyo código de empleado es $cod con los valores de $arrayNewValues
     * @param type $cod --> Código del empleado que se desea modificar
     * @param type $arrayNewValues --> Array con los nuevos valores. Las claves de los valores deben ser iguales al nombre de los campos de la BD
     */
    public function editEmployee($cod, $arrayNewValues) {
        $values = "";
        //Guardamos los valores que vamos a actualizar
        foreach ($arrayNewValues as $key => $value) {//Concatenamos el nombre de los campos (su clave) y los valores de dichas variables
            if (is_string($value)) {
                $values .= "$key = '$value'";
            } else if (is_numeric($value)) {
                $values .= "$key = $value";
            }
            if ($key !== array_key_last($arrayNewValues)) {//Si no es el último valor del array pongo la coma
                $values .= ", ";
            }
        }
        //Ejecutamos la query
        $query = $this->db->query("UPDATE empleados SET $values  WHERE codEmple = :cod", [
            ':cod' => $cod
        ]);
        //Cierro la BD
        unset($his->db);
    }

}
