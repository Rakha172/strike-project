<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>spin</title>
    <link href="{{ asset('css/spin.css') }}" rel="stylesheet">
</head>
<body>
    <button id="spin">spin</button>
    <span class="arrow"></span>
    <div class="container">
        <div class="one">1</div>
        <div class="two">2</div>
        <div class="three">3</div>
        <div class="four">4</div>
        <div class="five">5</div>
        <div class="six">6</div>
        <div class="seven">7</div>
        <div class="eight">8</div>
        <div class="nine">9</div>
        <div class="ten">10</div>
    </div>

     <script>
    let container = document.querySelector('.container');
    let btn = document.getElementById('spin');
    let number = Math.ceil(Math.random() * 1000);

    btn.onclick = function () {
    container.style.transform = "rotate(" + number + "deg)";
    number += Math.ceil(Math.random() * 1000);

}
     </script>
</body>
</html>
