function getTable(url, post_id, start) {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) { // XMLHttpRequest.DONE == 4
            if (xmlhttp.status == 200) {
                document.getElementById("table-content").innerHTML = xmlhttp.responseText;
                checkEnterInput(post_id);
                deleteFunction(post_id);
            } else if (xmlhttp.status == 400) {
                alert('Error 400');
            } else {
                alert('Error');
            }
        }
    };

    xmlhttp.open("POST", url, true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("id=" + post_id + "&start=" + start);
} // Ajax for show table content


function getSize(url, post_id) {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) { // XMLHttpRequest.DONE == 4
            if (xmlhttp.status == 200) {
                document.getElementById("table-pagination-content").innerHTML = xmlhttp.responseText;
                paginationPages();
            } else if (xmlhttp.status == 400) {
                alert('Error 400');
            } else {
                alert('Error');
            }
        }
    };

    xmlhttp.open("POST", url, true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("id=" + post_id);
}   // AJAX for get database size




function setRecord(post_id, insert_id, value, json) {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) { // XMLHttpRequest.DONE == 4
            if (xmlhttp.status == 200) {
                document.getElementById("info").innerHTML = xmlhttp.responseText;
            } else if (xmlhttp.status == 400) {
                alert('Error 400');
            } else {
                alert('Error');
            }
        }
    };

    xmlhttp.open("POST", "/api/setRecord.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("post_id=" + post_id + "&insert_id=" + insert_id + "&value=" + value + "&json=" + json);
} // Ajax for update field



function deleteRecord(post_id, element, json) {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) { // XMLHttpRequest.DONE == 4
            if (xmlhttp.status == 200) {
                document.getElementById("info").innerHTML = xmlhttp.responseText;
                element.remove();
            } else if (xmlhttp.status == 400) {
                alert('Error 400');
            } else {
                alert('Error');
            }
        }
    };

    xmlhttp.open("POST", "/api/deleteRecord.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("post_id=" + post_id + "&json=" + json);
} // Ajax for update field






var clickTable = document.getElementsByClassName('table-item');

for (var i = 0; i < clickTable.length; i++) {
    var element = clickTable[i];
    element.onclick = function () {
        var post_id = this.getAttribute("data-id");
        document.getElementById("table-content").innerHTML = "<img src='/assets/images/loader.gif' class='loader-records'/>";
        getSize('/api/getTableSize.php?id=', post_id);
        getTable('/api/getTableContent.php?id=', post_id, 0);
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
                json = JSON.stringify(json);

                setRecord(post_id, this.parentNode.getAttribute('data-id'), this.value, json);
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
var formQuery = document.getElementById('form-query');


if (formQueryButton) {
    formQueryButton.onclick = function () {
        var queryValue = formQuery.value;
        console.log(queryValue);
    }
}

// Query field



function paginationPages() {
    var clickTable = document.getElementsByClassName('pagination-item');

    for (var i = 0; i < clickTable.length; i++) {
        var element = clickTable[i];
        element.onclick = function () {
            var post_id = this.getAttribute("data-id");
            var start = (this.getAttribute("data-value") * 30) - 30;
            if (!this.classList.contains('page-active')) {
                document.getElementById("table-content").innerHTML = "<img src='/assets/images/loader.gif' class='loader-records'/>";
                getTable('/api/getTableContent.php?id=', post_id, start);
                var clickActive = document.getElementsByClassName('page-active');
                for (var i = 0; i < clickTable.length; i++) {
                    clickTable[i].classList.remove('page-active');
                }
                this.classList.add('page-active');

            }
            return false;
        };
    }
}



// Pagination

function deleteFunction(post_id) {
    var deleteButton = document.getElementsByClassName('delete-button');


    for (var i = 0; i < deleteButton.length; i++) {
        var element = deleteButton[i];
        element.onclick = function () {
           var json = JSON.parse(this.parentNode.parentNode.getAttribute('data-value'));
           json = JSON.stringify(json);
           deleteRecord(post_id, this.parentNode.parentNode, json);
        }
    }
}

// Delete record


var addInput = document.getElementsByClassName('add-input');
var addObject = document.getElementsByClassName('type');


addInput[0].onclick = function(e) {
    e.preventDefault();
    var copy = addObject[0].cloneNode(true);
    document.getElementById('add-table-form').appendChild(copy);
}





// ADD table form add new value