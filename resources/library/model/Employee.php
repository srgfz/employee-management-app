<?php

class Employee {

    //Atributos
    private $cod;
    private $name;
    private $lastname1;
    private $lastname2;

    //Constructor
    public function __construct($cod, $name, $lastname1, $lastname2) {
        $this->cod = $cod;
        $this->name = $name;
        $this->lastname1 = $lastname1;
        $this->lastname2 = $lastname2;
    }

    //Getters y Setters:
    public function getCod() {
        return $this->cod;
    }

    public function getName() {
        return $this->name;
    }

    public function getLastname1() {
        return $this->lastname1;
    }

    public function getLastname2() {
        return $this->lastname2;
    }

    public function setCod($cod): void {
        $this->cod = $cod;
    }

    public function setName($name): void {
        $this->name = $name;
    }

    public function setLastname1($lastname1): void {
        $this->lastname1 = $lastname1;
    }

    public function setLastname2($lastname2): void {
        $this->lastname2 = $lastname2;
    }

}
