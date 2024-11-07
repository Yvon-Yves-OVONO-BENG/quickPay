// public/js/form.js
document.addEventListener('DOMContentLoaded', function() {
    const addButton = document.getElementById('add-item');
    const itemsContainer = document.getElementById('items');

    addButton.addEventListener('click', function() {
        const index = itemsContainer.children.length; // Calculer le nouvel index
        const prototype = itemsContainer.getAttribute('data-prototype');
        const newForm = prototype.replace(/__name__/g, index); // Remplacer les placeholders par le nouvel index

        const div = document.createElement('div');
        div.innerHTML = newForm;
        itemsContainer.appendChild(div);
    });

    // Supprimer un élément
    itemsContainer.addEventListener('click', function(event) {
        if (event.target && event.target.matches('.delete-item')) {
            event.preventDefault();
            event.target.closest('.item').remove();
        }
    });
});
