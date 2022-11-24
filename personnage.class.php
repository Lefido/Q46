<?php

require "lede.class.php";

class Personnage {

    private $nom;
    private $vie;
    private $force_Attaque;
    private $point_Attaque;

    public function __construct($nom)
    {

        $this->nom = $nom;
        $this->vie = 100;
        $this->force_Attaque = 0;
        $this->point_Attaque = 0;

    }

    function attaque($valeurjetdeDe) {

        return $valeurjetdeDe * $this->force_Attaque;

    }

    function degat($valeurdegat) {

        $this->vie = $this->vie - $valeurdegat;
    }

    function get_nom() {
        return $this->nom;
    }

    function get_attaque() {

        return $this->force_Attaque;

    }

    function lancede() {

        $lede = new lede();

        return $lede;


    }

}


