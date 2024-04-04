(function() {
    window.OrderEventManager=function (deliveries) {
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
                deliveryPriceDiv.textContent=deliveryPrice+' ₽'
                totalPriceUpdate(deliveryPrice)
            }
        }
        function totalPriceUpdate(deliveryPrice){
            let productsPriceDiv = document.querySelector('.productsPrice')
            let productsPrice = getNumbersFromString(productsPriceDiv.textContent)[0]
            let totalPriceDiv = document.querySelector('.totalPrice')
            totalPriceDiv.textContent=(Number(productsPrice)+Number(deliveryPrice))+' ₽'
        }
        function getNumbersFromString(string) {
            return string.match(/\d+/g)
        }
    }
})();
