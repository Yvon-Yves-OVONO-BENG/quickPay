document.addEventListener('DOMContentLoaded', function() {
    $('.custom-switch-input').change(function() {
        let patientId = $(this).data('id');
        let isChecked = $(this).is(':checked');
        
        $.ajax({
            url: '/pharmacie/public/patient/terminer-patient/' + patientId,
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    notif({
                        msg: "<b>Prise en charge du patient terminé avec succès !</b>",
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
                        msg: "<b>Erreur lors de la modification de la prise en charge du patient !</b>",
                        type: "error",
                        position: "left",
                        width: 500,
                        height: 60,
                        autohide: true
                        });
                }
            },
            error: function() {
                notif({
                    msg: "<b>Erreur lors de la requête AJAX !</b>",
                    type: "error",
                    position: "left",
                    width: 500,
                    height: 60,
                    autohide: true
                    });
            }
        });
        
    });
});