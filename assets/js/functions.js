function getTable(url, post_id) {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) { // XMLHttpRequest.DONE == 4
            if (xmlhttp.status == 200) {
                document.getElementById("table-content").innerHTML = xmlhttp.responseText;
                checkEnterInput(post_id);
            } else if (xmlhttp.status == 400) {
                alert('Error 400');
            } else {
                alert('Error');
            }
        }
    };

    xmlhttp.open("POST", url + post_id, true);
    xmlhttp.send();
}           // Ajax for show table content




function setRecord(post_id, insert_id, value) {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) { // XMLHttpRequest.DONE == 4
            if (xmlhttp.status == 200) {
                console.log(xmlhttp.responseText);
            } else if (xmlhttp.status == 400) {
                alert('Error 400');
            } else {
                alert('Error');
            }
        }
    };

    xmlhttp.open("POST", "/api/setRecord.php?post_id=" + post_id + "&insert_id=" + insert_id + "&value=" + value, true);
    xmlhttp.send();
}  // Ajax for update field



var clickTable = document.getElementsByClassName('table-item');

for (var i = 0; i < clickTable.length; i++) {
    var element = clickTable[i];
    element.onclick = function () {
        var post_id = this.getAttribute("data-id");
        getTable('/api/getTableContent.php?id=', post_id);
        changeFormValue(post_id);
        changeRecordActive(this, post_id);
        return false;
    };
}

// Ajax show tables




function checkEnterInput(post_id) {
    var inputEnter = document.getElementsByClassName('input');
    for (var i = 0; i < inputEnter.length; i++) {
        var element = inputEnter[i];
        element.addEventListener("keyup", function (event) {
            event.preventDefault();

            if (event.keyCode == 13) {
                var input_value = this.value;
                this.setAttribute('value', this.value);
                this.setAttribute('name', this.value);

                var json = JSON.parse(this.parentNode.parentNode.getAttribute('data-value'));
                console.log(json);

                setRecord(post_id, this.parentNode.getAttribute('data-id'), this.value);           
            }
        });
    }
}


// Update on enter click


function changeFormValue(id) {
    var formQuery = document.getElementById('form-query');
    formQuery.value = "SELECT * FROM " + id;
}

// Change form select VALUE

function removeAllActive() {
    var clickTable = document.getElementsByClassName('table-item');

    for (var i = 0; i < clickTable.length; i++) {
        clickTable[i].classList.remove('item-active');
    }
}


// Remove all active classes


function changeRecordActive(current, id) {
    removeAllActive();
    current.classList.add('item-active');
}

// Change current active record


var formQueryButton = document.getElementById('form-query-button');


if (formQueryButton) {
    formQueryButton.onclick = function () {
        var queryValue = formQuery.value;
        console.log(queryValue);
    }
}