function SelectNext(element, baseClass, depth, postName) {
    if (element == undefined || baseClass == undefined || postName == undefined) {
        return;
    }
    var index = element.selectedIndex;
    var option = element.options;
    ClearName(baseClass)
    element.setAttribute("name", postName);
    SelectDropdown(baseClass, option[index].value, depth, postName);
}

function SelectDropdown(baseClass, id, depth, postName) {
    var allElements = document.getElementsByClassName(baseClass);
    for (let i = 0; i < allElements.length; i++) {
        let rubrieknummer = allElements[i].dataset.rubrieknummer;
        let elementDepth = allElements[i].dataset.depth;
        if (elementDepth != undefined) {
            if (rubrieknummer != undefined && rubrieknummer == id && elementDepth <= depth + 1) {
                if (allElements[i].classList.contains("noShow")) {
                    allElements[i].classList.remove("noShow");
                }
            } else {
                if (elementDepth > depth) {
                    if (!allElements[i].classList.contains("noShow")) {
                        allElements[i].classList.add("noShow");
                    }
                }
            }
        }
    }
}

function ClearName(baseClass) {
    var allElements = document.getElementsByClassName(baseClass);
    for (let i = 0; i < allElements.length; i++) {
        allElements[i].setAttribute("name", "");
    }
}