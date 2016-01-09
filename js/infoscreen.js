function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    m = checkTime(m);
    $("#time").html(h + ":" + m);
    var t = setTimeout(function () {
        startTime()
    }, 500);
}

function checkTime(i) {
    if (i < 10) {
        i = "0" + i
    }
    // add zero in front of numbers < 10
    return i;
}

var old, old2, last, last2, last3, last4, last5, old3, old4, old5;
old = "0";
old2 = "0";
old3 = "0";
old4 = "0";
old5 = "0";
function getDoorData() {
    $.get('http://192.168.1.5/infoscreen/getData.php?type=door', function (response) {
        //response = JSON.parse(data);
        last = response['data']['time'];
        if (last != old) {
            old = last;
            // alert(old);
            $("#testing").draggable();
            $("#username").html(response['data']['user']);
            // $("#mydiv").animate({height:"135px"},1000).delay(5000).animate({height:"0px"},1000);
            $("#doordiv").toggle("blind", {}, 1000).delay(5000).toggle("blind", {}, 1000);
        }
    });

}
function getSongData() {
    $.get('http://192.168.1.5/infoscreen/getData.php?type=music', function (response) {
        //response = JSON.parse(data);
        last2 = response['data']['song'];
        if (last2 != old2) {
            old2 = last2;
            // alert(old);
            $("#song").html(old2);
            $("#songdiv").toggle("blind", {}, 1000).delay(45000).toggle("blind", {}, 1000);
        }
    });
}
function getTempData() {
    $.get('http://192.168.1.5/infoscreen/getData.php?type=localtemperature', function (response) {
        //response = JSON.parse(data);
        last3 = response['data']['value'];
        if (last3 != old3) {
            old3 = last3;
            // alert(old);
            $("#temp").html(old3);
        }
    });
}
function getHumData() {
    $.get('http://192.168.1.5/infoscreen/getData.php?type=localhumidity', function (response) {
        //response = JSON.parse(data);
        last4 = response['data']['value'];
        if (last4 != old4) {
            old4 = last4;
            // alert(old);
            $("#hum").html(old4);
        }
    });
}
function getPresData() {
    $.get('http://192.168.1.5/infoscreen/getData.php?type=localpressure', function (response) {
        last5 = response['data']['value'];
        if (last5 != old5) {
            old5 = last5;
            $("#pres").html(old5);
        }
    });
}
