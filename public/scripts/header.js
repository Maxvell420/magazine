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
        function getCookie(cookieName) {
            let cookies = document.cookie.split('; ');

            // Проходим по всем кукам
            for (let i = 0; i < cookies.length; i++) {
                // Разделяем каждую куку по знаку равно, чтобы получить ключ и значение
                let cookie = cookies[i].split('=');

                // Если имя куки совпадает с искомым именем, возвращаем её значение
                if (cookie[0] === cookieName) {
                    return cookie[1];
                }
            }

            // Если кука с заданным именем не найдена, возвращаем null
            return null;
        }
        function updateCartValue(){
            let cart = getCookie('cart')
            if(!cart){
                cart = createCartCookie()
            }
            cart = parseCookieValue(cart)
            let value = countProductsInCart(cart)
            updateCartButton(value)
        }
        function updateCartButton(value){
            let button = document.getElementById('cart')
            let text = extractNonDigits(button.textContent)
            button.textContent=text + value
        }
        function extractNonDigits(str) {
            return str.replace(/\d/g, '');
        }
        function parseCookieValue(cookieValue) {
            return JSON.parse(cookieValue)
        }
        function countProductsInCart(cart){
            return cart.products.length
        }
        function createCartCookie(value) {
            let expirationDate = new Date();
            if (typeof value === 'undefined' || value === null) {
                value = {
                    products: [],
                    last_access: expirationDate.toUTCString()
                };
            }
            let jsonValue = JSON.stringify(value);
            expirationDate.setTime(expirationDate.getTime() + (60 * 1000 * 5));
            document.cookie = 'cart=' + jsonValue + '; expires=' + expirationDate.toUTCString() + '; path=/; SameSite=Lax';
            return jsonValue
        }
        updateCartValue()
    }
})();
(function() {
    window.adminHeaderButtonEventManager=function (selector) {
        let buttons = document.querySelectorAll(selector)
        console.log(buttons)
        buttons.forEach(function (button){
            button.addEventListener('click', hrefRedirect)
        })
        function hrefRedirect(){
            let link = this.querySelector('a')
            link.click()
        }
    }
})();
