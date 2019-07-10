export default function create(address) {
    let xhr = new XMLHttpRequest();
    let json = JSON.stringify({
        "address": address
    });

    xhr.onreadystatechange = function() {
        if (this.readyState !== 4) return;

        if (this.status === 200) {
            if (this.responseText) {
                document.getElementById('form__address').blur();
                insert(this.responseText);
            }
        } else {
            document.getElementById('form__address').focus();
            error();
        }
    };

    xhr.open('POST', '/', true);
    xhr.setRequestHeader('Content-type', 'application/json');
    xhr.send(json);
}

function insert(json) {
    let object = JSON.parse(json);

    while (document.getElementsByClassName('past').length === 3) {
        // delete oldest link before insert new
        document.getElementsByClassName('past')[2].remove();
    }

    let past = document.createElement('div');
    past.className = 'past';
    document.getElementById('form__address').insertAdjacentElement('afterend', past);
    insertLink(past, object);
    insertCopy(past);
}

function insertLink(past, object) {
    let link = document.createElement('a');
    link.className = 'past__link';
    link.href = object.link;
    link.target = '_blank';
    link.innerText = object.link;
    past.insertAdjacentElement('beforeend', link);
}

function insertCopy(past) {
    let copy = document.createElement('div');
    copy.className = 'past__copy';
    copy.innerHTML = '<i class="fas fa-clone"></i>';
    past.insertAdjacentElement('beforeend', copy);
}

function error() {
    document.getElementById('form__address').style.backgroundColor = '#ff8080';
    document.getElementById('form__address').style.transition = '';

    setTimeout(function() {
        document.getElementById('form__address').style.backgroundColor = '';
        document.getElementById('form__address').style.transition = 'background-color 500ms linear'
    }, 1000);
}