




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
        alert("Veuillez selectionner 2 personnages")
    } else if(nb > 2) {
        alert("Trop de personnage selectionnés, Veuillez n'en selectionner que 2")
    } else {
        new_partie.type = "submit";
    }

})

// Création constante du body
const screen = document.querySelector('body');

// Création du dé

let tailleDe = 50;
const de = document.createElement('div')
de.classList.add('de');
de.style.position = "absolute";
de.style.display = "flex";
de.style.justifyContent = "center";
de.style.alignItems = "center";
de.style.width = tailleDe + "px";
de.style.height = tailleDe + "px";
de.style.backgroundColor = "white";
de.style.borderRadius = "5px";
de.style.border = "1px solid gray";
de.style.fontSize = "24px"
screen.appendChild(de);
de.style.top = "0px";
de.style.left = "0px";

// Définition des parametres des joureurs
let taillex = 200
let tailley = 300
let borderRadius = "25px"

// Création du player 1
const player_1 = document.createElement('div');
player_1.classList.add('player1');
player_1.style.position = "absolute";
player_1.style.width = taillex + "px";
player_1.style.height = tailley + "px";
player_1.style.left = "10%"
player_1.style.background = "url('./assets/minion_1.gif') center / cover no-repeat";
player_1.style.borderRadius = borderRadius;
player_1.style.display = "flex";
player_1.style.justifyContent = "center";
player_1.style.alignItems = "start";
player_1.style.color = "white"
player_1.style.fontSize = "25px"
player_1.innerHTML = gaming[0].attaquant;

// Création du player 2
const player_2= document.createElement('div');
player_2.classList.add('player2');
player_2.style.position = "absolute";
player_2.style.width = taillex + "px";
player_2.style.height = tailley + "px";
player_2.style.right = "10%"
player_2.style.background = "url('./assets/minion_2.gif') center/ cover no-repeat";
player_2.style.borderRadius = borderRadius;
player_2.style.display = "flex";
player_2.style.justifyContent = "center";
player_2.style.alignItems = "start";
player_2.style.color = "white"
player_2.style.fontSize = "25px"
player_2.innerHTML = gaming[1].attaquant;

// Ajout des players sous forme de div
screen.appendChild(player_1);
screen.appendChild(player_2);

player_1.style.top = - tailley + "px"
player_2.style.top = - tailley + "px"

// Création constantes des players
const p1 = document.querySelector('.player1');
const p2 = document.querySelector('.player2');

let velocityDefaut = 0;
let velocity = velocityDefaut;
let vyVelocity = 4;

let py1 = - player_1.clientHeight
let py2 = - player_2.clientHeight

// let running = true;
let chutep1 = true;
let chutep2 = false;
let scenario = false;

let debutScenario = 0;
let action = true;
let posXduDe;
let posYduDe;

let vitesseDuDe;
let puissanceDe = 15;

 let idInterval = setInterval(start, 1000/60)

function start() {

    if (chutep1) {
        chute_perso_1();
    }

    if (chutep2) {
        chute_perso_2();
    }

    if (scenario) {
        animatioScenario()
    }

}

function chute_perso_1() {

    velocity = velocity + vyVelocity
    py1 = py1 + velocity

    if (py1 >= screen.clientHeight - p1.clientHeight) {
        py1 = screen.clientHeight - p1.clientHeight

        chutep1 = false
        chutep2 =true
        velocity = velocityDefaut;
        console.log("Chute du player 1 terminée")

    }

    p1.style.top = py1 + "px";


}

function chute_perso_2() {

    velocity = velocity + vyVelocity
    py2 = py2 + velocity

    if (py2 >= screen.clientHeight - p2.clientHeight) {
        py2 = screen.clientHeight - p2.clientHeight
        chutep2 = false
        scenario = true
        console.log("Chute du player 2 terminée")

    }

    p2.style.top = py2 + "px";

}

function  animatioScenario(){

    if (debutScenario < gaming.length) {

        if (debutScenario % 2 == 0) {

            if (action) {
                console.log("Le player 1 joue")
                console.log(gaming[debutScenario])
                de.innerHTML = gaming[debutScenario].de
                vitesseDuDe = puissanceDe

                posXduDe = player_1.offsetLeft + player_1.offsetWidth
                posYduDe = player_1.offsetTop + player_1.clientHeight / 2

                action = false

            }

        } else {

            if (action) {
                console.log("Le player 2 joue")
                console.log(gaming[debutScenario])
                de.innerHTML = gaming[debutScenario].de
                vitesseDuDe = - puissanceDe


                posXduDe = player_2.offsetLeft
                posYduDe = player_2.offsetTop + player_2.clientHeight / 2

                action = false

            }

        }


        // debutScenario++

    } else  {

        console.log("Fin du scénario")
        scenario = false
        clearInterval(idInterval)
    }

    animation_Action()

    // console.log(posXduDe, posYduDe)

    // if (debutScenario == 1) {
    //     clearInterval(idInterval)
    // }



}

function animation_Action() {


     posXduDe = posXduDe + vitesseDuDe;

     if (posXduDe >= player_2.offsetLeft || posXduDe <= player_1.offsetLeft + player_1.clientWidth) {

         action = true
         debutScenario++

         let num = Math.floor(Math.random() *11)
         console.log(num)
         const crie = new Audio(`./assets/crie_${num}.mp3`);
         crie.play();

     }



        de.style.left = posXduDe + "px";
        de.style.top = posYduDe + "px";



}












