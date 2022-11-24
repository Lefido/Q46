<?php



class Personnage {

    private $nom;
    private $vie;
    public $force_Attaque;
    private $point_Attaque;

    public function __construct($nom)
    {

        $this->nom = $nom;
        $this->vie = 100;
        $this->force_Attaque = 0;
        $this->point_Attaque = 0;

    }

    function set_force_attaque($force_attack) {

        $this->force_Attaque = $force_attack;

    }

    function attaque($valeurjetdeDe) {

        return $valeurjetdeDe * $this->force_Attaque;

    }

    function degat($valeurdegat) {

        $this->vie = $this->vie - $valeurdegat;
        if ($this->vie < 0) {
            $this->vie = 0;
        }
    }

    function get_vie() {
        return $this->vie;
    }

    function get_nom() {
        return $this->nom;
    }

    function get_attaque() {

        return $this->force_Attaque;

    }


}


