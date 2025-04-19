document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('crediterid');
    if (!container) return;
  
    const cardCol = container.closest('.col-xl-3, .col-xl-12');
    const initialColClasses = cardCol.className;
    const initialContent = container.innerHTML;
  
    // Toutes les cartes
    const allCols = document.querySelectorAll('#cardRow > .col-xl-3, #cardRow > .col-xl-12');
    const otherCols = [...allCols].filter(col => col !== cardCol);
  
    // Fonction pour activer l'affichage étendu
    function activerFormulaireCredit() {
      cardCol.className = 'col-xl-12 col-lg-12';
      otherCols.forEach(col => col.style.display = 'none');
      const slugValue = document.getElementById('slug')?.value || '';
      container.innerHTML = `
        <form id="formCredit" action="crediter-compte-marchand" class="row g-3 needs-validation was-validated" novalidate="" method="POST">
            <div class="col-md-4 position-relative">
                <label for="validationTooltip02" class="form-label">Numero de compte QuickPay :</label>
                <input type="text" name="numero" class="form-control mb-2" disabled>
            </div>
            <div class="col-md-4 position-relative">
                <label for="validationTooltip02" class="form-label">Montant à créditer</label>
                <input type="number" id="montant" name="montant" class="form-control mb-2" placeholder="Montant" required autofocus>
            </div>
            <div class="col-md-4 position-relative"  style="margin-top:25px;">
                <button type="submit" class="btn btn-success btn-lg w-100 mt-2" id="submitBtn">Valider</button>
            </div>
             <input type="hidden" id="slug" name="slug" value="${slugValue}">
        </form>
        <div class="row g-3">
            <div class="col-md-4 position-relative">
                
            </div>
            <div class="col-md-4 position-relative">
                
            </div>
            <div class="col-md-4 position-relative">
                <button class="btn btn-secondary btn-lg w-100 mt-2" id="btnRetour" type="button">Retour</button>
            </div>
        </div>
      `;
  
      setTimeout(() => {
        const fadeCard = document.querySelector('.fade-in-card');
        if (fadeCard) fadeCard.classList.add('show');
      }, 10);
  
      document.getElementById('btnRetour').addEventListener('click', () => {
        // Retour à l’état initial
        cardCol.className = initialColClasses;
        otherCols.forEach(col => col.style.display = '');
        container.innerHTML = initialContent;
  
        // Rebranche le bouton
        setTimeout(() => {
          const reloadedBtn = document.getElementById('idbtn');
          if (reloadedBtn) {
            reloadedBtn.addEventListener('click', boutonCreditClick);
          }
        }, 10);

        // Soumission du formulaire via XMLHttpRequest
        const form = document.getElementById('formCredit');
        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Empêche la soumission classique

            const montant = document.getElementById('montant').value;
            const slug = document.getElementById('slug')?.value || '';


            if (!montant) {
            alert("Veuillez entrer un montant !");
            return;
            }

            const xhr = new XMLHttpRequest();
            xhr.open('POST', form.action, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

            xhr.onload = function () {
            if (xhr.status === 200) {
                const response = xhr.responseText;
                // Traiter la réponse
                alert("Crédit effectué avec succès !");
                // Remettre l'interface à son état initial
                document.getElementById('btnRetour').click();
            } else {
                alert("Erreur lors du traitement : " + xhr.status);
            }
            };

            xhr.onerror = function () {
            alert("Erreur réseau !");
            };

            // Construction manuelle des données
            const params = `montant=${encodeURIComponent(montant)}&slug=${encodeURIComponent(slug)}`;
            xhr.send(params);
        });



      });
    }
    
  
    // Fonction liée au bouton "Créditer"
    function boutonCreditClick(e) {
      e.preventDefault(); //bloque l’envoi du formulaire
      activerFormulaireCredit();
    }
  
    // Au chargement initial
    const initialBtn = document.getElementById('idbtn');
    if (initialBtn) {
      initialBtn.addEventListener('click', boutonCreditClick);
    }
  }); 