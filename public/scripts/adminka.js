(function (){
   window.adminkaEventManager = function (orders){
       let input = document.getElementById('order')
       input.addEventListener('input',function (){
           let text = this.value
           let list = document.querySelector('.searchOrders')
           list.textContent=''
           if (text !==''){
               for (let order of orders) {
                    if ((order.id.toString().startsWith(text))){
                        let div = document.createElement('a')
                        div.setAttribute('href',order.href)
                        div.className = 'order'
                        let firstP = document.createElement('p')
                        firstP.textContent=order.id
                        let secondP = document.createElement('p')
                        secondP.textContent=order.price
                        let thirdP = document.createElement('p')
                        if (order.payed){
                            thirdP.textContent='Оплачен'
                        } else {
                            thirdP.textContent='Не оплачен'
                        }
                        let fourthP = document.createElement('p')
                        fourthP.textContent=order.status
                        div.appendChild(firstP)
                        div.appendChild(secondP)
                        div.appendChild(thirdP)
                        div.appendChild(fourthP)
                        list.appendChild(div)
                   }
               }
           }
       })
   }
})()
