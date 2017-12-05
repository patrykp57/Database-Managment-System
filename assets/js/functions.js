function getTable(url, post_id, start) {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) { // XMLHttpRequest.DONE == 4
            if (xmlhttp.status == 200) {
                document.getElementById("table-content").innerHTML = xmlhttp.responseText;
                document.getElementById("info").innerHTML = '';
                checkEnterInput(post_id);
                deleteFunction(post_id);
                addRecord();

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
} // AJAX for get database size




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
} // Change form select VALUE





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
    formQueryButton.onclick = function (e) {
        e.preventDefault();
        var queryValue = formQuery.value;
        querySelect('api/querySelect.php', formQuery.value);
    }
}

// Query field

function querySelect(url, value) {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) { // XMLHttpRequest.DONE == 4
            if (xmlhttp.status == 200) {
                document.getElementById("table-content").innerHTML = xmlhttp.responseText;
                document.getElementById("info").innerHTML = '';
            } else if (xmlhttp.status == 400) {
                alert('Error 400');
            } else {
                alert('Error');
            }
        }
    };

    xmlhttp.open("POST", url, true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send('value=' + value);
}



// Query Get Ajax

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
var i = 1;

if (addInput.length > 0) {
    addInput[0].onclick = function (e) {
        e.preventDefault();
        var copy = addObject[0].cloneNode(true);
        copy.childNodes[2].setAttribute('name', 'recordName[' + i + ']');
        copy.childNodes[4].setAttribute('name', 'recordType[' + i + ']');
        document.getElementById('add-table-form').appendChild(copy);
        i++;
    }
}

// ADD table form add new value



var addTableSubmit = document.getElementById('add-table-submit');

if (addTableSubmit != null || addTableSubmit != undefined) {
    addTableSubmit.onclick = function (e) {
        e.preventDefault();
        var form = JSON.stringify(serialize(this.parentNode));
        createTable("api/createTable.php", form);


    }
}

// Create table submit

function createTable(url, formValue) {

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

    xmlhttp.open("POST", url, true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send('value=' + formValue);

}



// Create table submit


var deleteButtons = document.getElementsByClassName('deleteTable');

if (deleteButtons) {
    for (var i = 0; i < deleteButtons.length; i++) {

        deleteButtons[i].onclick = function () {
            deleteTable('api/deleteTable.php', this.getAttribute('data-value'));
            this.parentNode.remove();
        };
    }
}


// Delete table

function deleteTable(url, id) {

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) { // XMLHttpRequest.DONE == 4
            if (xmlhttp.status == 200) {
                document.getElementById("info").innerHTML = xmlhttp.responseText;
                document.getElementById("table-content").innerHTML = '';
            } else if (xmlhttp.status == 400) {
                alert('Error 400');
            } else {
                alert('Error');
            }
        }
    };

    xmlhttp.open("POST", url, true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send('id=' + id);

}

// DELETE TABLE AJAX

function addRecord() {
    var addRecordButton = document.getElementById('addRecordButton');
    var addRecordInputs = document.getElementsByClassName('addRecordInputs');
    if (addRecordButton) {
        addRecordButton.onclick = function (e) {
            e.preventDefault();
            var inputValues = [];
            for (var i = 0; i < addRecordInputs.length; i++) {
                inputValues.push(addRecordInputs[i].value);
            }
     
            addRecordAjax('api/addRecord.php', inputValues);
        }

    }
}


// Add record button

function addRecordAjax(url, value) {
    
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == XMLHttpRequest.DONE) { // XMLHttpRequest.DONE == 4
                if (xmlhttp.status == 200) {
                    document.getElementById("info").innerHTML = xmlhttp.responseText;
                    document.getElementById("table-content").innerHTML = '';
                    // Tutaj APPEND
                } else if (xmlhttp.status == 400) {
                    alert('Error 400');
                } else {
                    alert('Error');
                }
            }
        };
    
        xmlhttp.open("POST", url, true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send('value=' + value);
    
    }

    // Add record ajax

var serialize = (function (slice) {
    return function (form) {
        //no form, no serialization
        if (form == null)
            return null;

        //get the form elements and convert to an array
        return slice.call(form.elements)
            .filter(function (element) {
                //remove disabled elements
                return !element.disabled;
            }).filter(function (element) {
                //remove unchecked checkboxes and radio buttons
                return !/^input$/i.test(element.tagName) || !/^(?:checkbox|radio)$/i.test(element.type) || element.checked;
            }).filter(function (element) {
                //remove <select multiple> elements with no values selected
                return !/^select$/i.test(element.tagName) || element.selectedOptions.length > 0;
            }).map(function (element) {
                switch (element.tagName.toLowerCase()) {
                    case 'checkbox':
                    case 'radio':
                        return {
                            name: element.name,
                            value: element.value === null ? 'on' : element.value
                        };
                    case 'select':
                        if (element.multiple) {
                            return {
                                name: element.name,
                                value: slice.call(element.selectedOptions)
                                    .map(function (option) {
                                        return option.value;
                                    })
                            };
                        }
                        return {
                            name: element.name,
                            value: element.value
                        };
                    default:
                        return {
                            name: element.name,
                            value: element.value || ''
                        };
                }
            });
    }
}(Array.prototype.slice));