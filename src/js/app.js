import '../scss/app.scss';
import create from './create';
import copy from './copy';

document.getElementById('form__address').addEventListener('keydown', function(event) {
    if (event.keyCode === 13) {
        create(this.value);
    }
});

document.getElementById('form__address').addEventListener('paste', function() {
    // creating some delay
    setTimeout(() => {
        create(this.value);
    });
});

document.getElementById('form').addEventListener('click', function(event) {
    let element = event.target;

    while (element !== this) {
        if (element.className === 'past__copy') {
            copy.call(element);
        }

        element = element.parentElement;
    }
});