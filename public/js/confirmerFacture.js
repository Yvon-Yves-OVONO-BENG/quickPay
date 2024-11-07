document.addEventListener('DOMContentLoaded', function() {

	//je sélectionne les champs de mon formulaire avec leurs ID
	const prisEnCharge = document.getElementById('confirmer_panier_patient');
	const nomPatient = document.getElementById('confirmer_panier_nomPatient');
	const contactPatient = document.getElementById('confirmer_panier_contactPatient');
	const bouton = document.getElementById('boutonEnvoie');

	////////////EVENEMENT SUR LA LISTE DEROULANTE
	prisEnCharge.addEventListener('change', function() {
		if(prisEnCharge.value.trim()) {
			console.log(prisEnCharge.value);
			nomPatient.disabled = true;
			nomPatient.value = "";
		}
		else
		{
			nomPatient.disabled = false;
			nomPatient.required = true;
		}
	});

	////////////EVENEMENT SUR LE CHAMP TEXT
	nomPatient.addEventListener('input', function() {
		if (nomPatient.value.trim()) {
			prisEnCharge.disabled = true;
			prisEnCharge.value = "";

		}
		else{
			prisEnCharge.disabled = false;
		}
	});
	
});
	