<?php

class Lede
{

    private $lede;


    public function __construct()
    {

        $this->lede = rand(1, 6);

    }

    function get_lede() {
        return $this->lede;
    }

}

