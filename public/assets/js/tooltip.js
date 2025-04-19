(function($) {
    "use strict";

    // ______________ Tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    var tooltip = new bootstrap.Tooltip(document.querySelector('[data-bs-toggle="tooltip-primary"]'), {
        template: '<div class="tooltip tooltip-primary" role="tooltip"><div class="tooltip-arrow"><\/div><div class="tooltip-inner"><\/div><\/div>'
    })
    var tooltip = new bootstrap.Tooltip(document.querySelector('[data-bs-toggle="tooltip-secondary"]'), {
        template: '<div class="tooltip tooltip-secondary" role="tooltip"><div class="tooltip-arrow"><\/div><div class="tooltip-inner"><\/div><\/div>'
    })
    var tooltip = new bootstrap.Tooltip(document.querySelector('[data-bs-toggle="tooltip-primary1"]'), {
        template: '<div class="tooltip tooltip-primary1" role="tooltip"><div class="tooltip-arrow"><\/div><div class="tooltip-inner"><\/div><\/div>'
    })
    var tooltip = new bootstrap.Tooltip(document.querySelector('[data-bs-toggle="tooltip-secondary1"]'), {
        template: '<div class="tooltip tooltip-secondary1" role="tooltip"><div class="tooltip-arrow"><\/div><div class="tooltip-inner"><\/div><\/div>'
    })
    
})(jQuery);   

$('#myonoffswitch54').click(function() {
		
	// tooltipleft
	var tooltipLeft = document.getElementById('tooltipLeft');
	var tooltip = bootstrap.Tooltip.getInstance(tooltipLeft) // Returns a Bootstrap tooltip instance
	tooltip._config.placement = "left";
	tooltip.update()
	// tooltipRight
	var tooltipRight = document.getElementById('tooltipRight');
	var tooltip1 = bootstrap.Tooltip.getInstance(tooltipRight) // Returns a Bootstrap tooltip instance
	tooltip1._config.placement = "right";
	tooltip1.update()
    // colored
	// tooltipleft
	var tooltipColorLeft = document.getElementById('tooltipColorLeft');
	var tooltipColor = bootstrap.Tooltip.getInstance(tooltipColorLeft) // Returns a Bootstrap tooltip instance
	tooltipColor._config.placement = "left";
	tooltipColor.update()
	// tooltipRight
	var tooltipColorRight = document.getElementById('tooltipColorRight');
	var tooltipColor1 = bootstrap.Tooltip.getInstance(tooltipColorRight) // Returns a Bootstrap tooltip instance
	tooltipColor1._config.placement = "right";
	tooltipColor1.update()
})

$('#myonoffswitch55').click(function() {
	// tooltipleft
	var tooltipLeft = document.getElementById('tooltipLeft');
	var tooltip = bootstrap.Tooltip.getInstance(tooltipLeft) // Returns a Bootstrap tooltip instance
	tooltip._config.placement = "right";
	tooltip.update()
	// tooltipRight
	var tooltipRight = document.getElementById('tooltipRight');
	var tooltip1 = bootstrap.Tooltip.getInstance(tooltipRight) // Returns a Bootstrap tooltip instance
	tooltip1._config.placement = "left";
	tooltip1.update()
    // colored
	// tooltipleft
	var tooltipColorLeft = document.getElementById('tooltipColorLeft');
	var tooltipColor = bootstrap.Tooltip.getInstance(tooltipColorLeft) // Returns a Bootstrap tooltip instance
	tooltipColor._config.placement = "right";
	tooltipColor.update()
	// tooltipRight
	var tooltipColorRight = document.getElementById('tooltipColorRight');
	var tooltipColor1 = bootstrap.Tooltip.getInstance(tooltipColorRight) // Returns a Bootstrap tooltip instance
	tooltipColor1._config.placement = "left";
	tooltipColor1.update()
});