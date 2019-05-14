var allElements = document.getElementsByClassName("Timer");
for (let i = 0; i < allElements.length; i++) {
    makeTimer(allElements[i]);

}

function makeTimer(element) {
    var time = "";
    console.log(element.dataset);
    if (element.dataset.time != undefined) {
        time = element.dataset.time;
    } else {
        return
    }

    var countDownDate = sqlToJsDate(time);
    var timer = setInterval(() => {
        var now = new Date().getTime();
        var distance = countDownDate - now;
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        var text = "Beëindigd";
        var classList = element.parentNode.classList;
        if (distance > 0) {
            if (days <= 0) {
                // minder dan 1 dag
                text = numberFormat(hours) + ":" + numberFormat(minutes) + ":" + numberFormat(seconds);
                if (!classList.contains("opschieten")) {
                    classList.add("opschieten");
                }
            } else {
                if (days > 1) {
                    text = days + " dagen";
                } else {
                    text = days + " dag";
                }
            }
        } else {
            // gestopt
            clearInterval(timer);
            if (!classList.contains("opschieten")) {
                classList.remove("opschieten");
            }
            if (!classList.contains("beeindigd")) {
                classList.add("beeindigd");
            }
        }
        element.innerHTML = text;
    }, 1000);
}

function sqlToJsDate(sqlDate) {
    var sqlDateArr1 = sqlDate.split("-");
    var sYear = sqlDateArr1[0];
    var sMonth = (Number(sqlDateArr1[1]) - 1).toString();
    var sqlDateArr2 = sqlDateArr1[2].split(" ");
    var sDay = sqlDateArr2[0];
    var sqlDateArr3 = sqlDateArr2[1].split(":");
    var sHour = sqlDateArr3[0];
    var sMinute = sqlDateArr3[1];
    var sqlDateArr4 = sqlDateArr3[2].split(".");
    var sSecond = sqlDateArr4[0];
    var sMillisecond = sqlDateArr4[1];
    return new Date(sYear, sMonth, sDay, sHour, sMinute, sSecond, sMillisecond);
}
function numberFormat($number) {
    if ($number > 9) {
        return $number;
    } else {
        return "0" + $number;
    }
}
