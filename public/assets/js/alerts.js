(function($) {
    "use strict";

     // Initialize popover
     var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
     var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
       return new bootstrap.Popover(popoverTriggerEl)
     })

     var popover = new bootstrap.Popover(document.querySelector('[data-bs-popover-color="default11"]'), {
      template: '<div class="popover" role="tooltip"><div class="popover-arrow"><\/div><h3 class="popover-header"><\/h3><div class="popover-body"><\/div><\/div>'
  })
  var popover = new bootstrap.Popover(document.querySelector('[data-bs-popover-color="default22"]'), {
    template: '<div class="popover" role="tooltip"><div class="popover-arrow"><\/div><h3 class="popover-header"><\/h3><div class="popover-body"><\/div><\/div>'
})
var popover = new bootstrap.Popover(document.querySelector('[data-bs-popover-color="default33"]'), {
    template: '<div class="popover" role="tooltip"><div class="popover-arrow"><\/div><h3 class="popover-header"><\/h3><div class="popover-body"><\/div><\/div>'
})
var popover = new bootstrap.Popover(document.querySelector('[data-bs-popover-color="default44"]'), {
    template: '<div class="popover" role="tooltip"><div class="popover-arrow"><\/div><h3 class="popover-header"><\/h3><div class="popover-body"><\/div><\/div>'
})
var popover = new bootstrap.Popover(document.querySelector('[data-bs-popover-color="default55"]'), {
    template: '<div class="popover" role="tooltip"><div class="popover-arrow"><\/div><h3 class="popover-header"><\/h3><div class="popover-body"><\/div><\/div>'
})
var popover = new bootstrap.Popover(document.querySelector('[data-bs-popover-color="default66"]'), {
    template: '<div class="popover" role="tooltip"><div class="popover-arrow"><\/div><h3 class="popover-header"><\/h3><div class="popover-body"><\/div><\/div>'
})
    
  // By default, Bootstrap doesn't auto close popover after appearing in the page
	       // resulting other popover overlap each other. Doing this will auto dismiss a popover
	       // when clicking anywhere outside of it
	       $(document).on('click', function (e) {
            $('[data-toggle="popover"],[data-bs-original-title]').each(function () {
                //the 'is' for buttons that trigger popups
                //the 'has' for icons within a button that triggers a popup
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                    (($(this).popover('hide').data('bs.popover')||{}).inState||{}).click = false  // fix for BS 3.3.6
                }

            });
          });
        });