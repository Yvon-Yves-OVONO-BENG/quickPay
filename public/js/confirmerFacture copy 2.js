///////// MA FONCTION DES CONDITIONS DE SAISES
document.addEventListener('DOMContentLoaded', function() {
	
	const patient = document.getElementById('confirmer_panier_patient');
	const nomPatient = document.getElementById('confirmer_panier_nomPatient');
	const contact = document.getElementById('confirmer_panier_contactPatient');
	const boutonPayer = document.getElementById('boutonEnvoie');
	
	///Condition 1 : si la liste déroulnte(patient) et nomPatient sont renseignés, 
	/////le bouton reste sur disabled
	if (patient.value.trim() != '' && nomPatient.value.trim() != '') {
		boutonPayer.setAttribute('disabled', 'disabled');

		return;
	} 


	///Condition 2 : si un champ est renseigné seul, le bouton reste sur disabled
	if ((patient.value.trim() != '' && nomPatient.value.trim() === '' && contact.value.trim() === '' ) ||
		(patient.value.trim() === '' && nomPatient.value.trim() != '' && contact.value.trim() === '') ||
		(patient.value.trim() === '' && nomPatient.value.trim() === '' && contact.value.trim() != '')) {
			boutonPayer.setAttribute('disabled', 'disabled') = true;

			return;
	}

	////Condition 3 : si patient et contact sont renseignés
	if (patient.value.trim() != '' && contact.value.trim() != '') {
		boutonPayer.removeAttribute('disabled');

		return;
	}


	///Condition 4 : si nomPatient et contact sont renseignés
	if (nomPatient.value.trim() != '' && contact.value.trim() != '') {
		boutonPayer.setAttribute('disabled');

		return;
	}


	/////PAR DEFAUT LE BOUTON EST SUR DISABLES
	boutonPayer.setAttribute('disabled', 'disabled');
});
