<?php

class User {
    //Atributos
    private $cod;
    private $name;
    private $pass;
    private $rol;

    //Constructor
    public function __construct($cod, $name, $pass, $rol) {
        $this->cod = $cod;
        $this->name = $name;
        $this->pass = $pass;
        $this->rol = $rol;
    }

    //Getters y Setters
    public function getCod() {
        return $this->cod;
    }

    public function getName() {
        return $this->name;
    }

    public function getPass() {
        return $this->pass;
    }

    public function getRol() {
        return $this->rol;
    }

    public function setCod($cod): void {
        $this->cod = $cod;
    }

    public function setName($name): void {
        $this->name = $name;
    }

    public function setPass($pass): void {
        $this->pass = $pass;
    }

    public function setRol($rol): void {
        $this->rol = $rol;
    }

}
