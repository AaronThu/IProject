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