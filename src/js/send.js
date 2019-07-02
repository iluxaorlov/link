export default (function() {

    document.getElementById('form__address').addEventListener('keydown', function(event) {
        if (event.keyCode === 13) {
            send(this.value);
        }
    });

    document.getElementById('form__address').addEventListener('paste', function() {
        // creating some delay
        setTimeout(() => {
            send(this.value);
        });
    });

})();

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
    let item = `<div class="item"><a class="item__link" href="${json.link}" target="_blank">${json.link}</a><i class="item__copy fas fa-copy"></i></div>`;
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