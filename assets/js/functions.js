function loadTableContent(post_id) {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) { // XMLHttpRequest.DONE == 4
            if (xmlhttp.status == 200) {
                document.getElementById("table-content").innerHTML = xmlhttp.responseText;
                checkEnter();
            } else if (xmlhttp.status == 400) {
                alert('Error 400');
            } else {
                alert('Error');
            }
        }
    };

    xmlhttp.open("GET", "/api/getTableContent.php?id=" + post_id, true);
    xmlhttp.send();
}



var clickTable = document.getElementsByClassName('table-item');

for (var i = 0; i < clickTable.length; i++) {
    var element = clickTable[i];
    element.onclick = function () {
        var post_id = this.getAttribute("data-id");
        loadTableContent(post_id);
        return false;
    };
}

// Ajax show tables

function checkEnter() {
    var inputEnter = document.getElementsByClassName('input');
    for (var i = 0; i < inputEnter.length; i++) {
        var element = inputEnter[i];
        element.addEventListener("keyup", function (event) {
            event.preventDefault();
       
            if (event.keyCode == 13) {
                var input_value = this.value;
                console.log(input_value);
            }
        });
    }
}


// Update on enter click