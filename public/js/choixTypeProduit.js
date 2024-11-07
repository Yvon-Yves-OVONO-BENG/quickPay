	///je déclare mes constantes pour gérer l'évènement choix type produit
	const choixTypeProduit = document.querySelector('#choixTypeProduit');
	const produit = document.querySelector('#produit');
	const kit = document.querySelector('#kit');

	const produitForm = document.querySelector('#produitForm');
	const kitForm = document.querySelector('#kitForm');

	console.log(choixTypeProduit);
	

	////AU chargement de la page
	window.onload = () => 
	{
		/////evenement choixTypeProduit
		choixTypeProduitEvent(produit, produitForm, kitForm);

	};


	///si est choixTypeProduit est checké
	if(produit.checked == true)
	{
		/////j'affiche la div type handicap
		produitForm.style.display = "";
		kitForm.style.display = "none";
	}
	///sinon
	else
	{
		produitForm.style.display = "none";
		kitForm.style.display = "";
	}


	// Si il/elle est handicapé(e)
	choixTypeProduit.addEventListener('change', function()
	{
		choixTypeProduitEvent(produit, produitForm, kitForm);
	});

	
	//////////////////TYPE PRODUIT EVENEMENT
	const choixTypeProduitEvent = (produit, produitForm, kitForm) => 
	{
		if(produit.checked == true)
		{
			produitForm.style.display = "";
			kitForm.style.display = "none";
			
		}else{
			
			produitForm.style.display = "none";
			kitForm.style.display = "";
		}
	};
