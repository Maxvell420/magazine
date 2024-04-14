async function func(){
    let four = await getSmth(2)
    let nine = await getSmth(3)
    console.log(four+nine)
}
async function getSmth(num){
    return num**2
}
func();
