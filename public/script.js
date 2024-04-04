let elem = document.getElementById('elem')
elem.addEventListener('click',function () {
    let self = this;
    setInterval(() => {
        console.log(this);
    }, 1000);
});
