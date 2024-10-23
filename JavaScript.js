console.log("Файл прочтён");

let s = document.getElementsByName("goods");
s[0].addEventListener("change", function(event) {
    let select = event.target;
    let service1 = document.getElementById("not_at_all");
    let service2 = document.getElementById("not_all");
    let service3 = document.getElementById("all");
    let check1 = document.getElementById("check1");
    let check2 = document.getElementById("check2");
    if (select.value == "Chair") 
    {
        service1.style.display = "none";
        service2.style.display = "none";
        service3.style.display = "none";
        check1.style.display = "none";
        check2.style.display = "none";
    }
    if (select.value=="Armchair") 
    {
        service1.style.display = "none";
        service2.style.display = "none";
        service3.style.display = "none";
        check1.style.display = "inline";
        check2.style.display = "inline";
    }
    if (select.value=="Sofa")
    {
        service1.style.display = "inline";
        service2.style.display = "inline";
        service3.style.display = "inline";
        check1.style.display = "none";
        check2.style.display = "none";
    }
    });

let g, h;
let r = document.querySelectorAll(".services input[type=radio]");
  r.forEach(function(radio) {
    radio.addEventListener("change", function(event1) {
      let r = event1.target;
      g = r.value;
    });    
  });

let k1 = 0, k2 = 0;
checks.onclick = function()
{
    if (check1.checked)
    {
        k1 = 100;
    }
    if (check2.checked)
    {
        k2 = 2000;
    }
    if (!check1.checked)
    {
        k1 = 0;
    }
    if (!check2.checked)
    {
        k2 = 0;
    }
}
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
    var num2, num3, result;
    switch(good)
    {
        case "Chair": num2 = 5000; break;
        case "Armchair": num2 = 15000; k1*=2; break;
        case "Sofa": num2 = 50000; k1*=3; break;
    }
    switch(g)
    {
        case "self": num3 = 1; break;
        case "delivery": num3 = 2; break;
        case "all_included": num3 = 2.5; break;
        default: num3=1;
    }
    console.log(typeof num1);
    console.log(" r = " + r);
    
    result = num1*num2*num3+k1+k2;
    console.log(result);
    document.getElementById("result").innerHTML = result;
}
