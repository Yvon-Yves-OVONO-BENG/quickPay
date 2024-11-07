////////////POUR LA LISTE DES PRODUITS DU PANIER
document.addEventListener('DOMContentLoaded', function() {
    const quantites = document.querySelectorAll(".quantite");
    const boutonMettreAjour = document.getElementById("mettreAjour");
    
    ////fonction qui vérifie si la valeur de l'un des champ est inférieure à 0
    function verifieValeurChamp(){
        let tousLesChampsValide = true;

        /////je parcours mes champs quantités
        quantites.forEach(function(quantite) {
            if (quantite.value < 1 ) {
                tousLesChampsValide = false;
            }
        });
        
        boutonMettreAjour.disabled = !tousLesChampsValide;

    }

    quantites.forEach(function(quantite) {
        quantite.addEventListener('input', verifieValeurChamp);
    });

    ///j'initialise la vérification
    verifieValeurChamp();
});



