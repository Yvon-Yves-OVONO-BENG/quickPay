<?php

namespace App\Service;

class BlocChiffreService 
{
    function diviserEnBlocs($nombre) {
        // Convertir le nombre en chaîne de caractères
        $nombre_str = strval($nombre);
        
        // Récupérer la longueur de la chaîne
        $longueur = strlen($nombre_str);
        
        // Initialiser une chaîne vide pour stocker les blocs
        $blocs = '';
        
        // Parcourir la chaîne à partir de la droite par pas de trois
        for ($i = $longueur - 1; $i >= 0; $i -= 3) {
            // Extraire un bloc de trois chiffres
            $bloc = substr($nombre_str, max(0, $i - 2), 3);
            
            // Ajouter le bloc à la chaîne de blocs
            $blocs = $bloc . ($blocs ? ' ' : '') . $blocs;
        }
        
        return $blocs;
    }
}