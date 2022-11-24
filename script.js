


const list_personnage = document.querySelectorAll('.supp-perso');

list_personnage.forEach((personnage) => {

    personnage.addEventListener("click" , function(){

        let confirm = window.confirm('Supprimer le personnage');

        console.log(confirm);

        if (confirm) {
            personnage.type = "submit";
        }

    })

})


const modif_personnage = document.querySelectorAll('.modif-perso')

modif_personnage.forEach((personnage,id) => {

    personnage.addEventListener("click" , function(){

        console.log(personnage);

        let list_personnage = document.querySelectorAll('.name-perso')
        // console.log(list_personnage[id].value);
        //
        let name = list_personnage[id].value;

        let confirm = window.prompt('Modifier le nom du personnage ', name);

        if (confirm) {
            console.log( list_personnage[id]);
            console.log(confirm, "OK");
            list_personnage[id].value = confirm;
            list_personnage[id].innerHTML = confirm;
            personnage.type = "submit";

        } else {
            console.log('Annuler')
        }

    })

})

const new_partie = document.querySelector(".lancer-partie")

new_partie.addEventListener('click', function (){

    let nb = 0;
    const liste_check = document.querySelectorAll('.check-perso')

    liste_check.forEach((check, id) => {

        if (check.checked) {
            nb++
        }

    })

    if(nb < 2) {
        alert("Veuillez selectionner 2 personnages maximum")
    } else if(nb > 2) {
        alert("Trop de personnage selectionnés, Veuillez n'en selectionner que 2")
    } else {
        new_partie.type = "submit";
    }

})












