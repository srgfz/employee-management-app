<?php

class Department {

    //Atributos
    private $cod;
    private $name;
    private $codManager;
    private $budget;
    private $city;
    private $empls = array();

    //Constructor
    public function __construct($cod, $name, $codManager, $budget, $city, $emps) {
        $this->cod = $cod;
        $this->name = $name;
        $this->codManager = $codManager;
        $this->budget = $budget;
        $this->city = $city;
        $this->empls = $emps;
    }

    //Getters y Setters:
    public function getCod() {
        return $this->cod;
    }

    public function getName() {
        return $this->name;
    }

    public function getCodManager() {
        return $this->codManager;
    }

    public function getBudget() {
        return $this->budget;
    }

    public function getCity() {
        return $this->city;
    }

    public function getEmpls() {
        return $this->empls;
    }

    public function setCod($cod): void {
        $this->cod = $cod;
    }

    public function setName($name): void {
        $this->name = $name;
    }

    public function setCodManager($codManager): void {
        $this->codManager = $codManager;
    }

    public function setBudget($budget): void {
        $this->budget = $budget;
    }

    public function setCity($city): void {
        $this->city = $city;
    }

    public function setEmpls($empls): void {//Añade una nueva posicion al array de empleados
        $this->empls[] = $empls;
    }

}
