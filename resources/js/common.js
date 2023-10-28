const button = document.getElementById('button');

button.addEventListener('click',function(){

    const confirm = window.confirm('購入しますか？');

    if(confirm){
        button.classList.add('disable');
    }
});
