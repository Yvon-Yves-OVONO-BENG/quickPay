$(document).ready(function () {
    $('#enregistrer-region').click(function(e) {
        e.preventDefault();

        var paysId = $('#pays').val();
        var nomRegion = $('#nom-region').val();

        $.ajax({
            type: 'POST',
            url: '/quickpay/public/region/ajouter-region',
            data: {pays_id: paysId, nom_region: nomRegion},
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Enregistrement réussi!',
                        text: 'La région a été enregistrée avec succès.',
                        icon: 'success',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true
                    });
                    //je vide les champs 
                    $('#nom-region').val('');
                }
                else {
                    Swal.fire({
                        title: 'Erreur',
                        text: "Une erreur est survenue lors de l'enregistrement",
                        icon: 'error'
                    });
                }
            }
        });
    });
});