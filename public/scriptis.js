let input = document.querySelector('input')
let button = document.querySelector('button')
let p = document.querySelector('p')

function calcFactorial(number){
    let res =1
    while (number>1){
        res*=number
        number--
    }
    return res
}
button.addEventListener('click',function(){
    let value = input.value
    p.textContent=calcFactorial(value).toString()
})
