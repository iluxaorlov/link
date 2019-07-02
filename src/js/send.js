function send(address) {
    let xhr = new XMLHttpRequest();
    // creating json object
    let json = JSON.stringify({
        address: address
    });

    xhr.onreadystatechange = function() {
        if (this.readyState !== 4) return;

        if (this.status === 200) {
            if (this.responseText) {
                document.getElementById('form__address').blur();
                create(this.responseText);
            }
        }

        if (this.status === 400) {
            document.getElementById('form__address').focus();
            error();
        }
    };

    xhr.open('POST', '/', true);
    xhr.setRequestHeader('Content-type', 'application/json');
    xhr.send(json);
}

function create(responseText) {
    let json = JSON.parse(responseText);

    if (document.getElementById('past')) {
        document.getElementById('past').innerHTML = `<a id="past__link" href="${json.link}" target="_blank">${json.link}</a><i id="past__copy" class="fas fa-copy"></i>`;
    } else {
        let item = `<div id="past"><a class="past__link" href="${json.link}" target="_blank">${json.link}</a><i id="past__copy" class="fas fa-copy"></i></div>`;
        document.getElementById('form__address').insertAdjacentHTML('afterend', item);
    }
}

function error() {
    document.getElementById('form__address').style.backgroundColor = '#ff8080';
    document.getElementById('form__address').style.transition = '';

    setTimeout(function() {
        document.getElementById('form__address').style.backgroundColor = '';
        document.getElementById('form__address').style.transition = 'background-color 500ms linear'
    }, 1000);
}

export default send;