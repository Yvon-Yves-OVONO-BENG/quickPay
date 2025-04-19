<?php

namespace App\Service;

use App\Repository\PorteMonnaieRepository;

class NumeroCompteService
{
    public function __construct(
        private PorteMonnaieRepository $porteMonnaieRepository
        ) {}

    /**
     * function qui me permet d'avoir le numero de compte
     *
     * @return string
     */
    public function genererNumeroUnique(): string
    {
        do 
        {
            $numero = $this->genererFormat();
        }
        while ($this->porteMonnaieRepository->findOneBy(['numeroCompte' => $numero]));

        return $numero;
    }

    /**
     * fonction qui me génère le format du numéro de compte
     *
     * @return string
     */
    private function genererFormat(): string
    {
        $gauche = "";

        for ($i = 0; $i < 10; $i++) 
        { 
            $gauche .=random_int(0,9); 
        }

        $droite = "";

        for ($i = 0; $i < 2; $i++) 
        { 
            $droite .= random_int(0,9);
        }

        return $gauche . '-' . $droite;
    }

}