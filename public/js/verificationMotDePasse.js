/////////
document.addEventListener('DOMContentLoaded', function() {
    ///je récupère mes champs
    const motDePasse = document.getElementById('motDePasse');
    const confirmerMotDePasse = document.getElementById('confirmerMotDePasse');
    const boutonEnvoyer = document.getElementById('boutonEnvoyer');
   console.log(boutonEnvoyer);
    /////
    function verifieMesMotDePasse() {
        if ((motDePasse.value && confirmerMotDePasse.value) && (motDePasse.value === confirmerMotDePasse.value) ) {
            console.log(motDePasse);
            boutonEnvoyer.removeAttribute('disabled');
        }
        else
        {
            boutonEnvoyer.setAttribute('disabled', 'disabled');
        }
    }

    ////
    motDePasse.addEventListener('input', verifieMesMotDePasse);
    confirmerMotDePasse.addEventListener('input', verifieMesMotDePasse);
});