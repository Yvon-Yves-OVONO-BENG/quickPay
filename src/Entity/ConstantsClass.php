<?php

namespace App\Entity;

class ConstantsClass
{
    public const ROLE_ADMINISTRATEUR = 'ROLE_ADMINISTRATEUR';
    public const ROLE_SUPER_ADMINISTRATEUR = 'ROLE_SUPER_ADMINISTRATEUR';
    public const ROLE_UTILISATEUR = 'ROLE_UTILISATEUR';

    public const GESTIONNAIRE = 'GESTIONNAIRE';
    public const UTILISATEUR = 'UTILISATEUR';
    public const ADMINISTRATEUR = 'ADMINISTRATEUR';
    public const SUPER_ADMINISTRATEUR = 'SUPER ADMINISTRATEUR';

    #ETAT TRANSACTION
    public const ERROR = 'ERROR';
    public const EN_ATTENTE = 'EN ATTENTE';
    public const EFFECTUEE = 'EFFECTUEE';
    public const ECHOUEE = 'ECHOUEE';
    public const ANNULEE = 'ANNULEE';
    public const REMBOURSEE = 'REMBOURSEE';
    public const EN_COURS = 'EN COURS';
    public const EXPIREE = 'EXPIREE';

    public const CONNEXION = 'CONNEXION';
    public const DECONNEXION = 'DECONNEXION';

    #CATEOGORIE USER
    public const AGENCE_VOYAGE = 'AGENCE DE VOYAGE';
    public const FACTURIER = 'FACTURIER';
    public const ABONNEMENT = 'ABONNEMENT';

    #TYPE USER
    public const PERSONNE_MORALE = 'PERSONNE MORALE';
    public const PERSONNE_PHYSIQUE = 'PERSONNE PHYSIQUE';


    #######  nom de la photo par defaut
    public const NOM_PHOTO = 'user.png';

    public const FEMININ = 'F';
    public const MASCULIN = 'M';

    public const FEMININ_IMAGE = 'f.png';
    public const MASCULIN_IMAGE = 'm.jpg';

}
