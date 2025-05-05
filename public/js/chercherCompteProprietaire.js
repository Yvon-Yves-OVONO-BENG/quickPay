 document.getElementById("numeroCompte").addEventListener("input", function (){
        const numero = this.value;
        if(numero.length >= 12) {
            fetch('/quickPay/public/chercher-proprietaire-compte', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ numeroCompte: numero}),
            })
            .then(response => response.json())
            .then(data => {
                const nomElement = document.getElementById("nomProprietaire");
                const numCni = document.getElementById("numCni");
                
                if(data.nom) {
                    nomElement.innerText = data.nom;
                    nomElement.classList.add("nom-trouve");
                    nomElement.classList.remove("nom-introuvable");

                    numCni.innerText = data.numCni;
                    numCni.classList.add("nom-trouve");
                    numCni.classList.remove("nom-introuvable");
                } else {
                    nomElement.innerText = "Compte introuvable";
                    nomElement.classList.add("nom-introuvable");
                    nomElement.classList.remove("nom-trouve");

                    numCni.innerText = "";
                    numCni.classList.add("nom-introuvable");
                    numCni.classList.remove("nom-trouve");


                }
            });
        }
    });

    document.getElementById("montantEnvoye").addEventListener("input", function() {
        const montant = parseFloat(this.value);
       
        if(!isNaN(montant)) {
            const frais = Math.min(montant * 0.01, 5000);
            //const frais = montant * 0.01;
            const montantReel = montant - frais;
            document.getElementById("montantReel").innerText = `Montant réel à envoyer : ${montantReel.toFixed(0)} XAF`;
        }
        else {
            document.getElementById("montantReel").innerText = "";
        }
    });