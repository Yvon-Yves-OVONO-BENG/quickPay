<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension 
{
    public function getFilters()
    {
        return [
            new TwigFilter('number_format', [$this, 'numberFormat']),
            new TwigFilter('truncate_10', [$this, 'truncate10']),
            new TwigFilter('tempsPublication', [$this, 'tempsPublication']),
        ];
    }

    public function numberFormat($number)
    {
        #j'utilise la fonction
        return number_format($number, 0, '', ' ');
    }

    /**
     * J'affiche 40% du texte
     *
     * @param string $text
     * @return string
     */
    public function truncate10(string $text): string
    {
        #calculer 40% de la longueur du text
        $length = strlen($text);
        $truncateLength = intval($length * 0.10);

        #retourne le texte tronqué
        return substr($text, 0, $truncateLength);
    }


    public function tempsPublication(\DateTime $dateTime)
    {
        $differencePublication = (new \Datetime())->diff($dateTime);

        if ($differencePublication->y > 0) 
        {
            return $differencePublication->y . ' an' .($differencePublication->y > 1 ? 's' : '');
        } 
        elseif ($differencePublication->m > 0) 
        {
            return $differencePublication->m . ' mois' ;
        } 
        elseif ($differencePublication->d > 0) 
        {
            return $differencePublication->d . ' jour' .($differencePublication->d > 1 ? 's' : '');
        } 
        elseif ($differencePublication->h > 0) 
        {
            return $differencePublication->h . ' heure' .($differencePublication->h > 1 ? 's' : '');
        }
        elseif ($differencePublication->i > 0) 
        {
            return $differencePublication->i . ' minute' .($differencePublication->i > 1 ? 's' : '');
        } 
        else
        {
            return "moins d'une minute";
        }
        
    }
}