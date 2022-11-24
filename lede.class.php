<?php

class Lede
{

    private $valeurMax;

    public function __construct($ValeurDeMax)
    {

        $this->valeurMax = $ValeurDeMax;

    }

    function lanceLeDe() {

        return rand(1, $this->valeurMax);

    }


}

