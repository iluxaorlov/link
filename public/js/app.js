'use strict';

document.getElementById('form').addEventListener('submit', function(event) {
    event.preventDefault();

    let xhr = new XMLHttpRequest();
    let data = new FormData(this);

    xhr.onreadystatechange = function() {
        if (this.readyState !== 4) return;

        if (this.status === 200) {
            if (this.responseText) {
                document.getElementById('form__address').blur();
                success(this.responseText);
            }
        }

        if (this.status === 400) {
            document.getElementById('form__address').focus();
            error();
        }
    }

    if (data.get('address').trim()) {
        xhr.open('POST', '/');
        xhr.send(data);
    } else {
        document.getElementById('form__address').focus();
    }
});

document.getElementById('form__address').addEventListener('paste', function() {
    setTimeout(function() {
        document.getElementById('form__submit').click();
        document.getElementById('form__address').blur();
    });
});

function success(responseText) {
    let json = JSON.parse(responseText);
    document.getElementById('output').style.display = 'block';
    document.getElementById('output__link').href = json.direction;
    document.getElementById('output__link').innerText = json.direction;
}

function error() {
    let address = document.getElementById('form__address');
    let output = document.getElementById('output');
    address.style.backgroundColor = '#ff8080';
    address.style.transition = '';
    output.style.display = 'none';

    setTimeout(function() {
        address.style.backgroundColor = '';
        address.style.transition = 'background-color 500ms linear'
    }, 500);
}