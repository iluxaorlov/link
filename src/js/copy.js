export default function copy() {
    let range = document.createRange();
    let selection = window.getSelection();
    selection.removeAllRanges();
    range.selectNode(this.previousElementSibling);
    selection.addRange(range);
    document.execCommand('copy');
    selection.removeAllRanges();
    click.call(this);
}

function click() {
    this.style.opacity = '0.5';
    this.style.transition = '';

    setTimeout(() => {
        this.style.opacity = '';
        this.style.transition = 'opacity 500ms linear';
    }, 1000);
}