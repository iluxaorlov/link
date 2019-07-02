export default (function() {

    document.getElementById('form').addEventListener('click', function(event) {
        let element = event.target;

        if (element.className === 'item__copy fas fa-copy') {
            click.call(element);
            copy.call(element);
            notification();
        }
    });

})();

function click() {
    this.style.transform = 'scale(0.75)';

    setTimeout(() => {
        this.style.transform = 'scale(1)';
    }, 500);
}

function notification() {
    let notification = document.getElementById('notification');
    notification.style.transition = '';
    notification.style.visibility = 'visible';
    notification.style.opacity = '1';

    setTimeout(function() {
        notification.style.transition = 'opacity 500ms linear, visibility 500ms linear';
        notification.style.visibility = 'hidden';
        notification.style.opacity = '0';
    }, 1000);
}

function copy() {
    let range = document.createRange();
    let selection = window.getSelection();
    selection.removeAllRanges();
    range.selectNode(this.previousElementSibling);
    selection.addRange(range);
    document.execCommand('copy');
    selection.removeAllRanges();
}