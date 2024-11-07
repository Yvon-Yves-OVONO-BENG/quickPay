///////// MA FONCTION DES CONDITIONS DE SAISES
document.addEventListener('DOMContentLoaded', function() {
	
		
		const patient = document.getElementById('confirmer_panier_patient');
		const nomPatient = document.getElementById('confirmer_panier_nomPatient');
		const contact = document.getElementById('confirmer_panier_contactPatient');
		const boutonPayer = document.getElementById('boutonEnvoie');
		
		//////fonction validation
		function verificationDesChamps() {
			if ((patient.value.trim() && contact.value && !nomPatient.value) ||
				(nomPatient.value && contact.value && !patient.value)) {
					boutonPayer.disabled = false;
					console.log('ok');
				}
				else {
					boutonPayer.disabled = true;
				}
		}

		/////j'appelle la finctio au niveau des champs
		patient.addEventListener('input', verificationDesChamps());
		nomPatient.addEventListener('input', verificationDesChamps());
		contact.addEventListener('input', verificationDesChamps());
	
});
