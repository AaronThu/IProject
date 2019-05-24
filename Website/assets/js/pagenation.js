function CountPage($int) {
    var el = document.getElementById("pageNumber");
    el.value = Math.max(1, parseInt(el.value) + $int);
    if (el.value > 1) {
        el.form.submit()
    }
}   