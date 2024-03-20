function populateProfTable(request) {
    let table = document.getElementById("profs-table");
    table.innerHTML = request.responseText;
}

function getProfAccounts() {
    try {
        const req = new XMLHttpRequest();
        req.open("GET", "./get_profs.php", true);
        req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        req.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                populateProfTable(req);
            }
        }
        req.send(null);
    } catch (exception) {
        alert("Request failed. Please try again.");
    }
}

function saveMultipleProfAccounts() {
    let csv = document.getElementById("prof-upload-csv").files[0];
    let formData = new FormData();
    formData.append("file", csv);

    console.log("exists");

    try {
        const syncRequest = new XMLHttpRequest();
        syncRequest.open("POST", "./import_profs.php", false);
        syncRequest.send(formData);

        if (syncRequest.status === 200) {
            let parser = new DOMParser();
            let xmlDoc = parser.parseFromString(syncRequest.responseText, "text/xml");
            let error_msgs = xmlDoc.getElementsByClassName("error");
            
            // check if we received an error while trying to register
            if (error_msgs.length > 0) {
                let error_div = document.getElementById("prof-error-msg-cont");
                // append all error messages
                for (msg of error_msgs) {
                    error_div.appendChild(msg);
                }
            }
        }
    } catch (exception) {
        console.log(exception);
        alert("Request failed. Please try again.");
    }
}

function saveProfAccount() {
    // Clear error messages
    const error_div = document.getElementById("prof-error-msg-cont");
    while (error_div.firstChild) {
        error_div.removeChild(error_div.lastChild);
    }

    const formData = new FormData(document.getElementById("add-profs-form"));

    try {
        const syncRequest = new XMLHttpRequest();
        syncRequest.open("POST", "./add_profs.php", false);
        syncRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        syncRequest.send(`sender=sysop&professor=${formData.get('inst-email')}&faculty=${formData.get('faculty')}&department=${formData.get('dept')}&course=${formData.get('crn-num')}`);

        if (syncRequest.status === 200) {
            let parser = new DOMParser();
            let xmlDoc = parser.parseFromString(syncRequest.responseText, "text/xml");
            let error_msgs = xmlDoc.getElementsByClassName("error");
            
            // check if we received an error while trying to register
            if (error_msgs.length > 0) {
                let error_div = document.getElementById("error-msg-cont");
                // append all error messages
                for (msg of error_msgs) {
                    error_div.appendChild(msg);
                }
            }
        }
    } catch (exception) {
        console.log(exception);
        alert("Request failed. Please try again.");
    }
}