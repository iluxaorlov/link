export default function send(address) {
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

    while (document.getElementsByClassName('past').length === 3) {
        // delete oldest link before insert new
        document.getElementsByClassName('past')[2].remove();
    }

    // creating html code of link
    let item = `<div class="past"><a class="past__link" href="${json.link}" target="_blank">${json.link}</a><i class="past__copy fas fa-copy"></i></div>`;
    // insert link in document
    document.getElementById('form__address').insertAdjacentHTML('afterend', item);
}

function error() {
    document.getElementById('form__address').style.backgroundColor = '#ff8080';
    document.getElementById('form__address').style.transition = '';

    setTimeout(function() {
        document.getElementById('form__address').style.backgroundColor = '';
        document.getElementById('form__address').style.transition = 'background-color 500ms linear'
    }, 1000);
}