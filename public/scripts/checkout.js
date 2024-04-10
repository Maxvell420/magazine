(function() {
    window.OrderEventManager=function (deliveries,translations) {
        let inputs = document.querySelectorAll('input[type="radio"]')
        inputs.forEach(function (input){
            input.addEventListener('click',radioInputEvent(deliveries))
        })
        function radioInputEvent(deliveries){
            return function (event){
                let deliveryPriceDiv = document.querySelector('.deliveryPrice')
                let deliveryPrice = 0
                for (let delivery of deliveries) {
                    if (Number(delivery.id) === Number(this.value)){
                        deliveryPrice=delivery.price
                    }
                }
                let text = extractNonDigitsAndSymbol(deliveryPriceDiv.textContent)
                deliveryPriceDiv.textContent=text + deliveryPrice+' ₽'
                totalPriceUpdate(deliveryPrice)
            }
        }
        function totalPriceUpdate(deliveryPrice){
            let productsPriceDiv = document.querySelector('.productsPrice')
            let productsPrice = getNumbersFromString(productsPriceDiv.textContent)[0]
            let totalPriceDiv = document.querySelector('.totalPrice')
            let text = extractNonDigitsAndSymbol(totalPriceDiv.textContent)
            totalPriceDiv.textContent=text + (Number(productsPrice)+Number(deliveryPrice))+' ₽'
        }
        function getNumbersFromString(string) {
            return string.match(/\d+/g)
        }
        function extractNonDigitsAndSymbol(str) {
            console.log(str)
            return str.replace(/[\d₽]/g, '');
        }
    }
})();
