(function() {
    window.headerButtonEventManager=function () {
        let buttons = document.querySelectorAll('.headerButtons button')
        buttons.forEach(function (button){
            button.addEventListener('click',function (){
                let link = this.querySelector('a')
                link.click()
            })
        })
    }
})();
