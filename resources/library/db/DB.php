<?php

//Añado la configuración de la base de datos
require_once __DIR__ . '/../config/dbconfig.php';

class DB {

    protected $db;

//Constructor
    public function __construct() {//En el constructor creo la conexión a la BD
        try {
            $this->db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DBUSER, DBPASS);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $ex) {//Si hay algún problema al hacer la conexión lanzo una excepción para indicar al usuario que la DB no está disponible
            throw new ErrorException("Error DB");
        }
    }

//Métodos propios de la clase

    /**
     * query() --> Método para ejecutar una consulta $query en el objeto DB con las condiciones indicadas en el array $conditions
     * @param type $query --> consulta prepare a ejecutar
     * @param type $conditions --> condiciones de la consulta prepare
     * @return type --> devuelve el objeto PDOStatment
     */
    public function query($query, $conditions = []) {
        $query = $this->db->prepare($query);
        foreach ($conditions as $key => $value) {
            $query->bindValue($key, $value);
        }
        try {
            $query->execute();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        //Cierro la conexión
        $this->closeDB();
        return $query; //Devuelvo el objeto PDO
    }

    /**
     * closeDB() --> método para cerrar la conexión a la DB
     */
    private function closeDB() {
        $this->BDcon = null;
    }

}
