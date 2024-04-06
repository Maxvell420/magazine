(function() {
    window.headerButtonEventManager=function (selector) {
        let buttons = document.querySelectorAll(selector)
        buttons.forEach(function (button){
            button.addEventListener('click',function (){
                let link = this.querySelector('a')
                link.click()
            })
        })
    }
})();
