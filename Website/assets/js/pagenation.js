function CountPage($int) {
    var el = document.getElementById("pageNumber");
    var old = el.value;
    el.value = Math.max(1, parseInt(el.value) + $int);
    if (old != el.value) {
        el.form.submit()
    }
}   