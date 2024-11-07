///////PRIS EN CHARGE SOLDE
document.addEventListener('DOMContentLoaded', function() {
    $('.custom-switch-input').change(function() {
        let patientId = $(this).data('id');
        let isChecked = $(this).is(':checked');
        
        ///je cree un nouvel objet XMLHttpRequest
			var xhr = new XMLHttpRequest();
			xhr.open('POST', '/pharmacie/public/patient/terminer-patient', true);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
			xhr.onreadystatechange = function() 
			{
				if (xhr.readyState === 4 && xhr.status === 200) 
				{
					var response = JSON.parse(xhr.responseText);
					if (response.success) 
					{
						notif({
							msg: "<b>Pris en charge du patient modifiée avec succès !</b>",
							type: "success",
							position: "left",
							width: 500,
							height: 60,
							autohide: true
							});

					}
					else 
					{
						notif({
							msg: "<b>Erreur lors de la mise à jour du patient !</b>",
							type: "danger",
							position: "left",
							width: 500,
							height: 60,
							autohide: true
							});
					}
				}
			};
			
			//j'envoie la request avec le patient ID
			xhr.send('patient_id=' + patientId);
        
    });
});


///////////////PRIS EN CHARGE DE NON SOLDE
document.addEventListener('DOMContentLoaded', function() {
    $('.prisEnChargeNonSolde').change(function() {
        console.log("ok");
			// Exemple d'utilisation de SweetAlert2
			Swal.fire({
				title: 'DANGER',
				text: "Vous ne pouvez pas terminer un pris en charge dont certaines factures ne sont pas soldés.",
				icon: 'error',
				allowOutsideClick: false,
				allowEscapeKey: false,
				allowEnterKey: false,
				showConfirmButton: true,
				confirmButtonText: "D'accord",
			}).then((result) => {
				if (result.isConfirmed) {
					// Redirection vers une autre page ou rafraîchissement de la page actuelle
					window.location.href = '/pharmacie/public/patient/afficher-patient/1'; // Exemple de redirection
				}
			});

			
        
    });
});