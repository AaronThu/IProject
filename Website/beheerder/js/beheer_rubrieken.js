var isMaken = false;

function Aanpassen(el) {
    isMaken = false;
    AddClass("maken", "noShow");
    Highlight(el, "knoppen", "highlight");
}

function Maken(el) {
    isMaken = true;
    AddClass("eigenschappen", "noShow");
    RemoveClass("maken", "noShow");
    Highlight(el, "knoppen", "highlight");
}

function setRubriek(element, id, IN_Name, parentID, parentName, volgNummer, isOpen) {
    var name = IN_Name.replace(/_/g, " ");
    var pName = parentName.replace(/_/g, " ");
    var nameElement = document.getElementById("Title");
    nameElement.innerHTML = name;
    if (!isMaken) {
        OpenEigenschappen();
    }
    Highlight(element, "zoekresultaat", "selected");
    if (isOpen == 0) {
        AddClass("delete", "noShow");
        RemoveClass("heropen", "noShow");
    } else {
        RemoveClass("delete", "noShow");
        AddClass("heropen", "noShow");
    }
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
    RemoveClass("eigenschappen", "noShow");
}

function AddClass(className, tag) {
    var el = document.getElementsByClassName(className);
    for (let i = 0; i < el.length; i++) {
        el[i].classList;
        if (!el[i].classList.contains(tag)) {
            el[i].classList.add(tag);
        }
    }
}

function RemoveClass(className, tag) {
    var el = document.getElementsByClassName(className);
    for (let i = 0; i < el.length; i++) {
        el[i].classList;
        if (el[i].classList.contains(tag)) {
            el[i].classList.remove(tag);
        }
    }
}

function CountVolgnummer(val) {
    setValue("inputNummer", val, false);
}