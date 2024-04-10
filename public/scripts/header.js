(function() {
    window.headerButtonEventManager=function (selector) {
        let buttons = document.querySelectorAll(selector)
        buttons.forEach(function (button){
            button.addEventListener('click', hrefRedirect)
        })
        function hrefRedirect(){
            let link = this.querySelector('a')
            link.click()
        }
        function langChangeSelect(){
            let a = document.getElementById('language')
            a.addEventListener('click', function(event) {
                event.preventDefault();
                // Дополнительные действия, которые нужно выполнить при клике на ссылку
            });
            let button = a.closest('button')
            button.removeEventListener('click',hrefRedirect)
            button.addEventListener('click',function (){
                let languages = document.getElementById('languages')
                let classes = languages.classList
                if (classes.contains('hidden')){
                    classes.remove('hidden')
                } else{
                    classes.add('hidden')
                }
            })
        }
        langChangeSelect()
    }
})();
