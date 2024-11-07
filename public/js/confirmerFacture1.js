document.addEventListener('DOMContentLoaded', () => {

	//je sélectionne les champs de mon formulaire avec leurs ID
	const prisEnCharge = document.getElementById('confirmer_panier_patient');
	const nomPatient = document.getElementById('confirmer_panier_nomPatient');
	const contactPatient = document.getElementById('confirmer_panier_contactPatient');
	const bouton = document.getElementById('boutonEnvoie');

	function miseAjourFormulaire() {
		const prisEnChargeValue = prisEnCharge.value;
		const nomPatientValue = nomPatient.value;
		const contactPatientValue = contactPatient.value;

		////désactive le champ nomPatient si prisenCharge est sélectionne
		if (prisEnChargeValue) {
			nomPatient.setAttribute('disabled', 'disabled');
			nomPatient.value = "";
		}
		else {
			nomPatient.removeAttribute('disabled');
		}

		///////si on saisie dans le champs nomPatient
		if (nomPatientValue) {
			prisEnCharge.selectIndex = 0;
			prisEnCharge.setAttribute('disabled', 'disabled');
		}
		else {
			prisEnCharge.removeAttribute('disabled');
		}

		//////GERE L'ETAT DU BOUTON
		if ((prisEnChargeValue && contactPatientValue) || 
			(nomPatientValue && contactPatientValue)) {
				bouton.disabled = false;
				bouton.classList.remove('btn-outline-danger btn-lg btn-block', 'disabled');
				bouton.classList.add('btn-outline-success btn-lg btn-block');
			}
			else {
				bouton.disabled = true;
				bouton.classList.remove('btn-outline-success btn-lg btn-block');
				bouton.classList.add('btn-outline-danger btn-lg btn-block', 'disabled');
			}
	}

	prisEnCharge.addEventListener('change', miseAjourFormulaire);
	nomPatient.addEventListener('input', miseAjourFormulaire);
	contactPatient.addEventListener('input', miseAjourFormulaire);

});	