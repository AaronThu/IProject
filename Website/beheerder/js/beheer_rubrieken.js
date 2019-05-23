var isMaken = false;

function Aanpassen(el) {
    isMaken = false;
    Elementen = document.getElementsByClassName("maken");
    for (let i = 0; i < Elementen.length; i++) {
        Elementen[i].classList;
        if (!Elementen[i].classList.contains("noShow")) {
            Elementen[i].classList.add("noShow");
        }
    }
    Highlight(el, "knoppen", "highlight");
}

function Maken(el) {
    isMaken = true;
    var Elementen = document.getElementsByClassName("eigenschappen");
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

function setRubriek(element, id, IN_Name, parentID, parentName, volgNummer) {
    var name = IN_Name.replace(/_/g, " ");
    var pName = parentName.replace(/_/g, " ");
    var nameElement = document.getElementById("Title");
    nameElement.innerHTML = name;
    if (!isMaken) {
        OpenEigenschappen();
    }
    Highlight(element, "zoekresultaat", "selected");
    setValue("ID", id, true);
    setValue("Name", name, true);
    setValue("RubriekParent", parentID, true);
    setValue("VolgNummer", volgNummer, true);
    setValue("parentName", pName, true);

}

function setValue(tag, val, override = true) {
    var Elementen = document.getElementsByClassName(tag);
    for (let i = 0; i < Elementen.length; i++) {
        if (override) {
            Elementen[i].value = val;
        } else {
            Elementen[i].value = Math.max(0, parseInt(Elementen[i].value) + val);
        }
    }
}

function Highlight(el, tag, style) {
    Elementen = document.getElementsByClassName(tag);
    for (let i = 0; i < Elementen.length; i++) {
        Elementen[i].classList;
        if (Elementen[i].classList.contains(style)) {
            Elementen[i].classList.remove(style);
        }
    }
    if (el != undefined) {
        el.classList.add(style);
    }
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


function CountVolgnummer(val) {
    setValue("inputNummer", val, false);
}