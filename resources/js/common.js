const button = document.getElementById('button');

button.addEventListener('click', function(e) {

    const confirm = window.confirm('購入しますか？');

    if (confirm) {
        purchaseForm.submit();
    }
    if (confirm) {
        button.classList.add('disable');
    }
});
