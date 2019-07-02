function copy() {
    let range = document.createRange();
    let selection = window.getSelection();
    selection.removeAllRanges();
    range.selectNode(this.previousElementSibling);
    selection.addRange(range);
    document.execCommand('copy');
    selection.removeAllRanges();
    click(this);
}

function click(element) {
    element.style.color = '#00ff00';
    element.style.transition = '';

    setTimeout(function() {
        element.style.color = '';
        element.style.transition = 'color 500ms linear';
    }, 1000);
}

export default copy;