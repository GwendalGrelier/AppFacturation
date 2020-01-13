<?php


abstract class Model
{

    const SERVER = 'sqlprive-pc2372-001.privatesql.ha.ovh.net:3306';
    const USER = 'cefiidev957';
    const PASSWORD = '4iC9Ze6t';
    const BASE = 'cefiidev957';
    

    protected $connexion;

    public function __construct()
    {
        //connexion
        try {
            $this->connexion = new PDO("mysql:host=" . self::SERVER . ";dbname=" . self::BASE, self::USER, self::PASSWORD);
            $this->connexion->exec("SET NAMES 'UTF8'");
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }

   
}
