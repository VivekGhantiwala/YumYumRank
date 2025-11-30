<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/locomotive-scroll@3.5.4/dist/locomotive-scroll.css">
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: sans-serif;
    }
    .main {
        background-color: beige;
    }
    html, body {
        width:100%;
        height:100%;
    }
    .page1,.page2{
        width: 100vw;
        height: 100vh;
    }
    .page1{
        background-color: crimson;
    }
    .page2{
        background-color: lightblue;
    }
</style>

<body>
    <div class="main">
    <div class="page1"></div>
    <div class="page2"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/locomotive-scroll@3.5.4/dist/locomotive-scroll.js"></script>
    <script>

        const scroll = new LocomotiveScroll({
            el: document.querySelector('.main'),
            smooth: true
        });
    </script>
</body>

</html>