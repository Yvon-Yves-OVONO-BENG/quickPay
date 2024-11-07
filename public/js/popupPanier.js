document.addEventListener("DOMContentLoaded", function() {
    var cartIcon = document.getElementById('cart-icon');
    var popup = document.getElementById('popup');

    var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                ///l'icone du panier est visible
                popup.style.display = 'none';
            }
            else {
                //L'icone du panier n'est pas visible
                popup.style.display = '';
            }
        });
    }, { threshold: [0] });

    observer.observe(cartIcon);
});