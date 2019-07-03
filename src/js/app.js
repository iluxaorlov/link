import '../scss/app.scss';
import send from './send';
import copy from './copy';

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

document.getElementById('form').addEventListener('click', function(event) {
    let element = event.target;

    if (element.className === 'past__copy fas fa-copy') {
        copy.call(element);
    }
});