<?php

class Database
{
    private $host;
    private $user;
    private $pass;
    private $dbName;
    private $connexion;
    private $request;

    public function __construct($host, $user, $dbName, $pass)
    {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->dbName = $dbName;
    }

    public function connect()
    {
        $path = "mysql:host=$this->host;dbname=$this->dbName;charset=utf8";

        try
        {
            $this->connexion = new PDO($path, $this->user, $this->pass);
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->connexion;
        }
        catch (PDOException $e)
        {
            throw new PDOException($e->getMessage() , (int)$e->getCode());
        }
    }

    public function prepReq($query, $array = [])
    {
        $this->request = $this->connexion->prepare($query);
        $this->request->execute($array);
        return $this->request;
    }


    public function fetchData()
    {
        return $this->request->fetchAll();
    }

    public function supprimer($id) {

        $this->prepReq("delete FROM personnages where id = :id", ["id" => $id]);
        $this->fetchData();

    }

    public function nouveau($nom) {

        $this->prepReq("SELECT * FROM personnages where nom = :name", ["name" => $nom]);
        $personnages = $this->fetchData();

        if (count($personnages) == 0) {

            $this->prepReq("INSERT INTO personnages (nom, vie, force_attaque, point_attaque )  values (:name, 100, 0, 0)", ["name" => $nom]);

        };

    }

    public function modification($id, $newName) {

        $this->prepReq("SELECT * FROM personnages where nom = :name", ["name" => $newName]);
        $personnages = $this->fetchData();

        if (count($personnages) == 0) {

            $this->prepReq("UPDATE personnages set nom = :name where id = :id", ["name" => $newName, "id" => $id]);

        };


    }

}

