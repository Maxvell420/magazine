(function (){
   window.productEditEventManager = function (){
       let additionalInfoDiv = document.querySelector('.additionalInfo')
       let moreButton = document.getElementById('more')
       let deleteButtons = document.querySelectorAll('form .property .button button')
       let properties = document.querySelectorAll('.property')
       properties.forEach(function (property){
           let input = property.querySelector('input')
           input.value=replaceUnderscoreWithSpace(input.value)
           let textarea = property.querySelector('textarea')
           textarea.textContent=replaceUnderscoreWithSpace(textarea.textContent)
           input.addEventListener('input',function (){
               changeElementName(this.value,textarea)
           })
       })
       deleteButtons.forEach(function (button){
           button.addEventListener('click',function (){
               deleteProperty(this)
           })
       })
       moreButton.addEventListener('click',function (){
           appendNewInputs()
       })
       function replaceUnderscoreWithSpace(str) {
           return str.replace(/_/g, ' ');
       }
       function appendNewInputs(){
           let properties = document.querySelectorAll('.property')
           let num = properties.length
           let div = document.createElement('div')
           div.className = 'property'
           let nameInput = document.createElement('input')
           nameInput.id = ('data_'+num+1).toString()
           let nameInputLabel = document.createElement('label')
           nameInput.setAttribute('placeholder','Название свойства:')
           nameInputLabel.textContent = 'Название свойства:'
           nameInputLabel.setAttribute('for',nameInput.id)
           let dataTextarea = document.createElement('textarea')
           let dataInputLabel = document.createElement('label')
           dataInputLabel.textContent='Описание'
           dataTextarea.setAttribute('placeholder','Данные свойства')
           dataTextarea.id = (num+1).toString()
           dataInputLabel.setAttribute('for',dataTextarea.id)
           nameInput.addEventListener('input',function (){
               let name = this.value
               changeElementName(name,dataTextarea)
           })
           let emptyDiv = document.createElement('div')
           div.appendChild(nameInputLabel)
           div.appendChild(nameInput)
           div.appendChild(dataInputLabel)
           div.appendChild(dataTextarea)
           div.appendChild(emptyDiv)
           let deleteButton = createDeleteButtonDiv()
           div.appendChild(deleteButton)
           additionalInfoDiv.appendChild(div)
       }
       function createDeleteButtonDiv(){
           let div = document.createElement('div')
           div.className = 'button'
           let deleteButton = document.createElement('button')
           deleteButton.setAttribute('type','button');
           deleteButton.textContent='Удалить свойство'
           deleteButton.addEventListener("click",function (){
               deleteProperty(this)
           })
           div.appendChild(deleteButton)
           return div
       }
       function deleteProperty(button){
           let property = button.closest('.property')
           property.remove()
       }
       function changeElementName(name,input){
           input.setAttribute('name',name)
       }
   }
})()
