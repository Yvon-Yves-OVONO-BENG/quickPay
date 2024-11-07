////////////POUR LA LISTE DES PRODUITS
const quantites = document.querySelectorAll(".quantite");
const boutonsAjoutPanier = document.querySelectorAll(".ajout-produit-panier");

quantites.forEach(function(quantite, index){
    quantite.addEventListener("change", () => 
    {
        var boutonAjoutPanier = boutonsAjoutPanier[index];
        //// POUR LE CHAMP quantite
        if (quantite.value < 1)
        {
            //j'ajoute l'attribut 'required' dans le champs
            quantite.required = true;
            quantite.classList.add('required-field', 'vibrate');
            quantite.style.borderColor = 'red';

            boutonAjoutPanier.setAttribute('disabled', 'disabled');


            //je retire la classe 'vibrate' après l'animation pour permettre des vibrations répétées
            setTimeout(function(){
                quantite.classList.remove('vibrate');
            }, 300);
        }
        else
        {
            //j'enlève le required dans le champ
            quantite.required = false;
            quantite.classList.remove('required-field');
            quantite.style.borderColor = 'green';
            
            boutonAjoutPanier.removeAttribute('disabled');
        }

    });

});

