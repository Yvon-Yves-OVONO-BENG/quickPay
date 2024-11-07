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
        ];
    }

    public function numberFormat($number)
    {
        #j'utilise la fonction
        return number_format($number, 0, '', ' ');
    }
}