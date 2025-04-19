<?php

namespace App\Service;

use GeoIp2\Database\Reader;

class LocalisationService
{
    public function __construct(private string $geoDbPath) 
    {
        if (!file_exists($this->geoDbPath)) 
        {
           throw new \RuntimeException("Fichier GeoIP non trouvé à : " . $this->geoDbPath);
        }
    }

    public function detecterPaysParIp(string $ip): ?string
    {
        $reader = new Reader($this->geoDbPath);
        try {
            $record = $reader->country($ip);
            return $record->country->isoCode; // Exemple : "CM"
        } catch (\Exception $e) {
            return null;
        }
    }
}