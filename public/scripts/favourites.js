// function generateCartButtons(){
//     let buttons = document.querySelectorAll('.buttons button:first-child')
//     let cart = getCookie('cart')
//     if (!cart) {
//         createCartCookie()
//         cart = getCookie('cart')
//     }
//     cart = parseCookieValue(cart)
//     buttons.forEach(function (button){
//         let parent = button.closest('.product')
//         let value = getNumbersFromString(parent.id)[0]
//         let productsAmount = getProductsAmount(cart);
//         button.addEventListener('click',function (event){
//             event.preventDefault()
//             if (!isNaN(value)) {
//                 if (!cart){
//                     productsAmount=addProductIdToCart(cart,value);
//                 }  else if(!productInCart(cart,value)){
//                     productsAmount=addProductIdToCart(cart,value);
//                 } else{
//                     productsAmount=removeProductIdFromCart(cart,value)
//                 }
//                 changeProductButton(this,cart,value)
//                 updateCartButton(productsAmount)
//             }
//         })
//         updateCartButton(productsAmount)
//         changeProductButton(button,cart,value)
//     })
// }
function appendAfter(nodeToInsert,parentNode,nextNode){
    if (nextNode===null){
        return parentNode.appendChild(nodeToInsert)
    } else{
        parentNode.insertBefore(nodeToInsert,nextNode)
    }
}
function showSubcategories(subcategories,productParams){
    let current = document.querySelector('.current')
    let form = document.querySelector('.filterWindow form .filterInputs')
    form.innerHTML=''
    if (current !== null){
        for (let i = 0;i<subcategories.length;i++){
            if(Number(subcategories[i]['category_id'])===Number(getNumbersFromString(current.id)[0])){
                let div = document.createElement('div')
                let [radio,label] = makeRadioInput(subcategories[i])
                div.append(label)
                div.append(radio)
                div.className='filterCategory'
                form.append(div)
                radio.addEventListener('click',function (){
                    let radios = document.querySelectorAll('.filterWindow form .filterInputs div input')
                    for (let radiosKey of radios) {
                        /*Вот здесь бы как-то сделать закрывание */
                        if (radiosKey.checked){
                            let childDiv = showSubcategoryParams(radiosKey,productParams)
                            childDiv.className='productsParams'
                            div.appendChild(childDiv)
                        } else {
                            let parentNode = radiosKey.parentNode
                            let childDiv = parentNode.querySelector('div')
                            if(childDiv !== null){
                                childDiv.remove()
                            }
                        }
                    }
                })
            }
        }
    }
}
function clearFilterDiv(parentNode){
    let div = parentNode.querySelector('div')
    if(div !== null){
        div.innerHTML='';
    }
}
function createDiv(parentNode){
    return parentNode.createElement('div');
}
function createSpan(param){
    let span = document.createElement('span')
    span.textContent=replaceUnderscoreWithSpace(param)
    return span
}
function showSubcategoryParams(radio,productParams){
    let parentNode = radio.parentNode
    let div = parentNode.querySelector('div');
    if (div !== null) {
        div.remove();
    }
    div = document.createElement('div')
    let id = getNumbersFromString(radio.id);
    let params = productParams[id];
    let counter = 1;
    for (let paramsKey in params) {
        let span = createSpan(paramsKey);
        div.appendChild(span);
        span.addEventListener('click', (function(counter) {
            return function() {
                let spanDiv = document.getElementById('spanDiv' + counter.toString());
                if (spanDiv !== null) {
                    spanDiv.remove();
                } else {
                    spanDiv = filterSpanInputs(params[paramsKey], paramsKey);
                    appendAfter(spanDiv,div,this.nextSibling)
                    // div.appendChild(spanDiv);
                }
                spanDiv.id = 'spanDiv' + counter.toString();
            };
        })(counter));
        counter++
    }
    return div
}
function filterSpanInputs(params,key){
    let div = document.createElement('div');
    div.className = 'paramsInputs'
    // let div = document.createElement('div');
    let i = 1;
    for (let param of params) {
        let input = document.createElement('input')
        input.id = key+'_'+i.toString()
        input.name = replaceUnderscoreWithSpace(key)+'[]'
        input.type = 'checkbox'
        input.value = param
        let label = document.createElement('label')
        label.setAttribute('for',input.id)
        label.innerText=param;
        div.appendChild(label)
        div.appendChild(input)
        i++
    }
    return div
}
function makeRadioInput(object){
    let radio = document.createElement('input')
    radio.type='radio';
    radio.name='subcategory';
    radio.value=object['id']
    radio.id='radio_'+object['id']
    let label = document.createElement('label')
    label.setAttribute('for',radio.id)
    label.textContent=object['name']
    return [radio,label]
}
function getNumbersFromString(string){
    return string.match(/\d+/g)
}
function replaceUnderscoreWithSpace(str) {
    return str.replace(/_/g, ' ');
}

// cart and buttons part


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
/**
 * Пробует получить куки с значением cart и если нет то создает новую и добавляет в нее значение
 *
 * @return string
 * @param [value] object
 */
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

/**
 * Пробует получить куки с значением cart и если нет то создает новую и добавляет в нее значение
 *
 * @return number
 * @param cart
 * @param id int
 */
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

function generateButtonForProduct(product) {
    let cart = getCookie('cart')
    if (!cart) {
        createCartCookie()
        cart = getCookie('cart')
    }
    cart = parseCookieValue(cart)
    let button = document.createElement('button')
    let div = document.getElementById('product_' + product);
    let img = document.createElement('img')
    if (productInCart(cart, product)) {
        button.className = 'addToCart'
        img.src='../images/buttons/shopping-cart.svg'
    } else {
        button.className = 'removeFromCart'
        img.src='../images/buttons/remove-from-cart-icon.svg'
    }
    div.appendChild(button)
    button.appendChild(img)
}

function productInCart(cart, product_id) {
    return cart.products.includes(product_id)
}

function changeProductButton(button,cart,product) {
    let img = button.querySelector('img')
    if (productInCart(cart,product)){
        button.className = 'removeFromCart'
        img.src='../images/buttons/remove-from-cart-icon.svg'
    } else{
        img.src='../images/buttons/shopping-cart.svg'
        button.className = 'addToCart'
    }
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
    button.textContent='Корзина:' + value
}
function getProductsAmount(cart){
    return cart.products.length
}
