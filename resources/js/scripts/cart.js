export function ProductEventManager(product,translations) {
    let deleteButton = document.getElementById('delete_' + product.id)
    // let cartButton = document.getElementById('cart')
    // cartButton.textContent=translations.cart+':'+(Number(getNumbersFromString(cartButton.textContent)[0])+1).toString()
    let positiveButton = document.getElementById('plus_'+product.id)
    let negativeButton = document.getElementById('minus_'+product.id)
    let input = document.getElementById(product.id)
    input.value = 0
    window.addEventListener('load',function (){
        deleteButton.addEventListener('click', deleteProductHandler(product))
        positiveButton.addEventListener('click',addProductQuantity(product))
        negativeButton.addEventListener('click',removeProductQuantity(product))
        positiveButton.click()
    })
    function deleteProductHandler(product) {
        return function (event) {
            let cart = parseCookieValue(getCookie('cart'))
            calcNewTotalPrice(product)
            let cartAmount = removeProductIdFromCart(cart,product.id)
            updateCartButton(cartAmount)
            deleteProductDiv(product)
            let totalPriceDiv = document.getElementById('total')
            let totalPrice = Number(getNumbersFromString(totalPriceDiv.textContent)[0])
            totalPriceDiv.textContent=translations.total+':'+(totalPrice-(product.price*Number(input.value))).toString()+" ₽"
            if (cartAmount===0){
                document.querySelector('.order').remove()
            }
        }
    }
    function addProductQuantity(product){
        return function (event){
            let totalPriceDiv = document.getElementById('total')
            let totalPrice = Number(getNumbersFromString(totalPriceDiv.textContent)[0])
            let input = document.getElementById(product.id)
            let productTotalPriceDiv = document.getElementById('totalProductPrice_'+product.id)
            let productTotalQuantityDiv = document.getElementById('totalQuantity_'+product.id)
            let productTotalPrice= Number(getNumbersFromString(productTotalPriceDiv.textContent)[0])
            let productTotalQuantity = productTotalQuantityDiv.textContent
            if(productTotalQuantity<product.quantity){
                input.value=(Number(input.value)+1).toString()
                productTotalPriceDiv.textContent=(Number(productTotalPrice)+Number(product.price)).toString()+" ₽"
                productTotalQuantityDiv.textContent=(Number(productTotalQuantityDiv.textContent)+1).toString()
                totalPriceDiv.textContent=translations.total+':'+(totalPrice+Number(product.price)).toString()+" ₽"
            }
        }
    }
    function removeProductQuantity(product){
        return function (event){
            let totalPriceDiv = document.getElementById('total')
            let totalPrice = Number(getNumbersFromString(totalPriceDiv.textContent)[0])
            let input = document.getElementById(product.id)
            let productTotalPriceDiv = document.getElementById('totalProductPrice_'+product.id)
            let productTotalQuantityDiv = document.getElementById('totalQuantity_'+product.id)
            let productTotalPrice= Number(getNumbersFromString(totalPriceDiv.textContent)[0])
            let productTotalQuantity = productTotalQuantityDiv.textContent
            if(productTotalQuantity>1){
                input.value-=1
                productTotalPriceDiv.textContent=(Number(productTotalPrice)-Number(product.price)).toString()+" ₽"
                productTotalQuantityDiv.textContent=(Number(productTotalQuantityDiv.textContent)-1).toString()
                totalPriceDiv.textContent=translations.total+':'+(totalPrice-Number(product.price)).toString()+" ₽"
            }
        }
    }
    function getNumbersFromString(string) {
        return string.match(/\d+/g)
    }
    function calcNewTotalPrice(product) {
        let input = document.getElementById(product.id)
        let quantity = input.value
        let totalPrice = getNumbersFromString(document.getElementById('total').textContent)
        let newValue = (Number(totalPrice) - (Number(product.price) * Number(quantity))).toString()
        if (newValue<0){
            newValue = 0
        }
        totalPrice.textContent = newValue+" ₽"
    }
    function deleteProductDiv(product) {
        let div = document.getElementById('product_' + product.id)
        div.remove()
    }
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
    function parseCookieValue(cookieValue) {
        return JSON.parse(cookieValue)
    }
    function removeProductIdFromCart(cart, id) {
        let time = new Date().toUTCString()
        cart.products = cart.products.filter(function (value) {
            return Number(value) !== Number(id)
        })
        cart.last_access = time
        createCartCookie(cart);
        return cart.products.length
    }
    function countProductsInCart(cart) {
        return cart.products.length
    }
    function updateCartButton(value) {
        let button = document.getElementById('cart')
        button.textContent = translations.cart+ ":" + value
    }
    function getProductsAmount(cart) {
        return cart.products.length
    }
    function extractNonDigits(str) {
        return str.replace(/\d/g, '');
    }
}

