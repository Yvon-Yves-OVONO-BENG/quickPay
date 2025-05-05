$(document).ready(function(){
    $('.modifier-region').click(function(e) {
        e.preventDefault();

        var regionId = $(this).data('region-id');
        $.ajax({
            type: 'GET',
            url: '/quickpay/public/region/modifier_region',
            data: { region_id: regionId },
            success: function(response) {
                $('#region-id').val(response.id);
                $('#pays').val(response.pays_id);

                $('#nom-region').val(response.nom);
                $('#modifier-region-modal').modal('show');
            }
        });
    });
    $('#enregistrer-modification-region').click(function(e) {
        e.preventDefault();

        var regionId = $('#region-id').val();
        var paysId = $('#pays').val();
        var nomRegion = $('#nom-region').val();

        $.ajax({
            type: 'GET',
            url: '/quickpay/public/modifier-region',
            data: {region_id: regionId, pays_id: paysId, nom_region: nomRegion},
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Modification réussie',
                        text: 'La région a été modifiée avec succès',
                        icon: 'success',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true
                    });
                    $('#modifier-region-modal').modal('hide');
                }
                else {
                    Swal.fire({
                        title: 'Erreur',
                        text: 'Une erreur est survenue mors de la modification.',
                        icon: 'error',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true
                    });
                }
            }
        });
    });
});