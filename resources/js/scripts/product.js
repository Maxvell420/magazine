;export function productEventManager (translations){
        let cartButton = document.querySelector('.buttons button:first-child')
        let cart = getCookie('cart')
        let parent = cartButton.closest('.product')
        let value = getNumbersFromString(parent.id)[0]
        if (!cart) {
            createCartCookie()
            cart = getCookie('cart')
        }
        cart = parseCookieValue(cart)
        let productsAmount = getProductsAmount(cart);
        cartButton.addEventListener('click',function (){
            if (!isNaN(value)) {
                if (!cart){
                    productsAmount=addProductIdToCart(cart,value);
                }  else if(!productInCart(cart,value)){
                    productsAmount=addProductIdToCart(cart,value);
                } else{
                    productsAmount=removeProductIdFromCart(cart,value)
                }
                changeProductButton(this,cart,value)
                updateCartButton(productsAmount)
            }
        })
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
        function getNumbersFromString(string){
            return string.match(/\d+/g)
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
        function addProductIdToCart(cart,id) {
            let time = new Date().toUTCString()
            if (!cart){
                cart = {
                    products: [],
                    last_access: time
                };
            } else{
                cart.last_access=time
            }

            cart.products.push(id);

            createCartCookie(cart);

            return cart.products.length
        }

        function parseCookieValue(cookieValue) {
            return JSON.parse(cookieValue)
        }
        function productInCart(cart, product_id) {
            return cart.products.includes(product_id)
        }
        changeProductButton(cartButton,cart,value)
        function changeProductButton(button,cart,product) {
            let img = button.querySelector('img')
            if (productInCart(cart,product)){
                button.className = 'removeFromCart'
                img.src='../../../images/buttons/remove-from-cart-icon.svg'
            } else{
                img.src='../../../images/buttons/shopping-cart.svg'
                button.className = 'addToCart'
            }
        }
        function replaceUnderscoreWithSpace(str) {
            return str.replace(/_/g, ' ');
        }
        function removeProductIdFromCart(cart, id) {

            let time = new Date().toUTCString()

            cart.products = cart.products.filter(function (value) {
                return value !== id
            })

            cart.last_access=time

            createCartCookie(cart);

            return cart.products.length
        }
        function countProductsInCart(cart){
            return cart.products.length
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
            button.textContent=translations.cart+ ':' + vaslue
        }
        function getProductsAmount(cart){
            return cart.products.length
        }
        function activeSectionEvents(){
            let div = document.querySelector('.productActive')
            let charButton = document.getElementById('characteristics')
            let revButton = document.getElementById('reviews')
            charButton.addEventListener('click',async function(){
                let section = document.querySelector('.productActive');
                section.innerHTML=''
                let href = this.getAttribute('data-href')
                let data = await sendAjaxToRetrieveDiv(href)
                div.appendChild(data)
            })
            revButton.addEventListener('click',async function(){
                let section = document.querySelector('.productActive');
                section.innerHTML=''
                let href = this.getAttribute('data-href')
                let data = await sendAjaxToRetrieveDiv(href)
                div.appendChild(data)
            })
            async function sendAjaxToRetrieveDiv(href){
                let promise = await fetch(href)
                let response = await promise.text()
                console.log(response)
                if (response){
                    // let data = JSON.parse(response)
                    let tempDiv = document.createElement('div');
                    tempDiv.innerHTML = response
                    return tempDiv.firstChild
                }
            }
            revButton.click()
        }
        activeSectionEvents()
}
export function replaceUnderScore(){
       let ps = document.querySelectorAll('.properties p')
       for (let p of ps) {
           let text = p.textContent;
           p.textContent=replaceUnderscoreWithSpace(text)
       }
       function replaceUnderscoreWithSpace(str) {
           return str.replace(/_/g, ' ');
       }
}
