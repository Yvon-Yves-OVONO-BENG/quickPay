<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;

class SessionService
{
    public function recuperationEtMiseAjouSession(Request $request)
    {
        # je récupère ma session
        $maSession = $request->getSession();
        
        #mes variables témoin pour afficher les sweetAlert
        $maSession->set('ajout', null);
        $maSession->set('suppression', null);

        

    }
}