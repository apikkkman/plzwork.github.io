console.log("Файл прочтён");
// function click1() {
//     let f1 = document.getElementsByName("field1");
//     let f2 = document.getElementsByName("field2");
//     let r = document.getElementById("result");
//     r.innerHTML = f1[0].value + f2[0].value;
//     return false;
//    }
// function onClick() {
// alert('click');
// }
// var b = document.getElementById('button1');
// b.addEventListener('click', onClick);
function count()
{
    var num1 = Number(document.getElementById("num1").value);
    if (isNaN(num1)==true)
    {
        alert("Недопустимые значения!");
        return 0;
    }
    console.log(num1);
    var num11=num1-num1%1;
    if (num11!=num1)
        {
            num11++;
            alert("Количество было округлено до верхней границы, а именно: " + num11);
            num1=num11;
        }
        if (num1<=0)
            {
                alert("Мы не покупаем мебель!");
        return 0;
    }
    var good = (document.getElementById("good").value);
    var num2, result;
    switch(good)
    {
        case "Chair": num2 = 5000; break;
        case "Armchair": num2 = 15000; break;
        case "Sofa": num2 = 50000; break;
    }
    console.log(typeof num1);
    result = num1*num2;
    console.log(result);
    document.getElementById("result").innerHTML = result;
}