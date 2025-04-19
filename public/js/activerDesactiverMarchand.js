document.addEventListener('DOMContentLoaded', () => {
  const checkbox = document.getElementById('etatCheckbox');
  const route = document.getElementById('routeid');

  if (checkbox) {
    checkbox.addEventListener('change', () => {
      const etat = checkbox.checked ? 1 : 0;
      const slug = checkbox.dataset.slug;

      const xhr = new XMLHttpRequest();
      xhr.open('POST', route.action, true);
      xhr.setRequestHeader('Content-Type', 'application/json');
      xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);
          console.log(response);
          // Affichage d'un message flash à partir de la réponse
          if (response.success) {
              notif({
              msg: `<b>${response.message}</b>`,
              type: `${response.type}`,
              position: "right",
              width: 500,
              height: 60,
              autohide: true
              });
             
          }
        }
      };

      const data = JSON.stringify({
        slug: slug,
        etat: etat
      });

      xhr.send(data);
    });
  }
});


