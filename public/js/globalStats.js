function topclick() {
    var xhttp = new XMLHttpRequest();
    xhttp.open("GET", "http://opentracker.dev/stats/topClick", false);
    xhttp.setRequestHeader("Content-type", "application/json");
    xhttp.send();
    console.log(JSON.parse(xhttp.responseText));
    console.log("bjsdhvjh");
    var id = JSON.parse(xhttp.responseText)['t_id'];
    document.getElementById("top_click").innerHTML = id;

    xhttp.open("GET", "http://opentracker.dev/stats/rate?id="+id+"?type=0", false);
    xhttp.setRequestHeader("Content-type", "application/json");
    xhttp.send();
    console.log(JSON.parse(xhttp.responseText));
    console.log("bjsdhvjh");
    document.getElementById("top_percent").innerHTML = JSON.parse(xhttp.responseText)+'%';
}

window.addEventListener('load', topclick);

function secretOpen() {
    var ele  = document.getElementById("s_token");
    var token = ele.dataset.token;
    ele.innerHTML = token;
}

function secretClose() {
    var ele  = document.getElementById("s_token");
    ele.innerHTML = 'XXXXXXXXXX';
}


