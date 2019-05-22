
function Aanpassen(el) {
    console.log(el.classList);
    Elementen = document.getElementsByClassName("maken");
    for (let i = 0; i < Elementen.length; i++) {
        Elementen[i].classList;
        if (!Elementen[i].classList.contains("noShow")) {
            Elementen[i].classList.add("noShow");
        }
    }

    var Elementen = document.getElementsByClassName("zoeken");
    for (let i = 0; i < Elementen.length; i++) {
        Elementen[i].classList;
        if (Elementen[i].classList.contains("noShow")) {
            Elementen[i].classList.remove("noShow");
        }
    }
    Highlight(el, "knoppen", "highlight");
}

function Maken(el) {
    var Elementen = document.getElementsByClassName("eigenschappen");
    for (let i = 0; i < Elementen.length; i++) {
        Elementen[i].classList;
        if (!Elementen[i].classList.contains("noShow")) {
            Elementen[i].classList.add("noShow");
        }
    }

    var Elementen = document.getElementsByClassName("zoeken");
    for (let i = 0; i < Elementen.length; i++) {
        Elementen[i].classList;
        if (!Elementen[i].classList.contains("noShow")) {
            Elementen[i].classList.add("noShow");
        }
    }

    Elementen = document.getElementsByClassName("maken");
    for (let i = 0; i < Elementen.length; i++) {
        Elementen[i].classList;
        if (Elementen[i].classList.contains("noShow")) {
            Elementen[i].classList.remove("noShow");
        }
    }

    Highlight(el, "knoppen", "highlight");
}

function setRubriek(element, id, IN_Name, parentID, volgNummer) {
    var name = IN_Name.replace(/_/g, " ");
    var nameElement = document.getElementById("Title");
    nameElement.innerHTML = name;

    var parentIDElement = document.getElementById("parentID");
    parentIDElement.innerHTML = parentID;

    var volgNrElement = document.getElementById("Volgnummer");
    volgNrElement.innerHTML = volgNummer;

    OpenEigenschappen();
    Highlight(element, "zoekresultaat", "selected")
    // console.log(id);
    // console.log(name);
    // console.log(parentID);
    // console.log(volgNummer);
}

function Highlight(el, tag, style) {
    Elementen = document.getElementsByClassName(tag);
    for (let i = 0; i < Elementen.length; i++) {
        Elementen[i].classList;
        if (Elementen[i].classList.contains(style)) {
            Elementen[i].classList.remove(style);
        }
    }
    el.classList.add(style);
}

function OpenEigenschappen() {
    var Elementen = document.getElementsByClassName("eigenschappen");
    for (let i = 0; i < Elementen.length; i++) {
        Elementen[i].classList;
        if (Elementen[i].classList.contains("noShow")) {
            Elementen[i].classList.remove("noShow");
        }
    }
}
