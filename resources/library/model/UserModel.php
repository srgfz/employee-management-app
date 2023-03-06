<?php

//Añado la base de datos
require_once __DIR__ . '/../db/DB.php';
//Añado la clase a la que hace referencia
require_once __DIR__ . '/User.php';

class UserModel {

    //Atributos
    private $db;

    //Constructor
    public function __construct() {
        $this->db = new DB();
    }

    //Métodos de la clase

    /**
     * getAll() --> Método para obtener todos los usuarios con todos sus campos de la tabla usuarios
     * @return --> devuelve un array multidimensional con todos los registros de ejecutar la consulta $query
     */
    public function getAll() {
        $query = $this->db->query('SELECT * FROM usuarios');
        //Cierro la BD
        unset($his->db);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * getUserLogin()--> Método para obtener el nombre de usuario y el rol de la tabla usuarios, correspondiente al usuario $user y contraseña $pass
     * @param type $user --> usuario introducido
     * @param type $pass --> contraseña introducida
     * @return type --> devuelve el array asociativo/objeto del usuario correspondiente a $user y $pass
     */
    public function getUserLogin($user, $pass) {
        $query = $this->db->query('SELECT Nombre, Rol FROM usuarios WHERE Nombre = :user AND Clave = :pass', [':user' => $user, ':pass' => $pass]);
        //Cierro la BD
        unset($his->db);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

}
