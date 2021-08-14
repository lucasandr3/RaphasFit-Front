<!doctype html>
<html lang="pt-BR">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <meta name="theme-color" content="#00" /> -->
    <!-- Bootstrap CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="<?=url('assets/css/main.css')?>">

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <title><?=getStore()->information['name_store']?></title>
    <link rel="shortcut icon" href="<?=getStore()->information['logo']?>" />
</head>

<body onload="cartData()">

<header style="height: 50px;margin-bottom: 20px;">
    <div class="h-cart shadow">
        <div class="h-arrow">
            <a href="<?=url('/'.getStore()->slug)?>"><span class="material-icons" style="margin-right:5px;line-height: 2;">keyboard_backspace</span></a>
        </div>
        <div>
            <span class="h-title">Minha Sacola</span>
        </div>
    </div>
</header>

<main>
    <div class="container">
        <div class="alert alert-warning" role="alert">
            A simple warning alert—check it out!
        </div>

        <div id="cart-item"></div>

<!--        <div class="cart-item shadow">-->
<!--            <div>-->
<!--                <img src="http://192.168.100.5/descomplicazap/assets/img/products/bbqseg.jpeg" class="img-cart" alt="">-->
<!--            </div>-->
<!--            <div class="cart-item--info">-->
<!--                <span style="font-weight: bold;color: #333;">Segunda</span>-->
<!--                <small style="font-size: 12px;">Segunda</small>-->
<!--                <span style="font-size: 15px;font-weight: bold;color: #555;">R$ 12,00</span>-->
<!--            </div>-->
<!--            <div>-->
<!--                <div class="btn-group" role="group" aria-label="Basic example">-->
<!--                    <button type="button" class="btn btn-outline-success" style="background-color: #00968817;border:#00968817;border-radius: 8px;color: green;">-</button>-->
<!--                    <input type="number" value="1" class="input-cart-qt" style="width: 35px;border:none;">-->
<!--                    <button type="button" class="btn btn-success" style="background-color: #22bb9c;border:#22bb9c;border-radius: 8px;">+</button>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <div class="cart-item shadow">-->
<!--            <div>-->
<!--                <img src="http://192.168.100.5/descomplicazap/assets/img/products/bbqseg.jpeg" class="img-cart" alt="">-->
<!--            </div>-->
<!--            <div class="cart-item--info">-->
<!--                <span style="font-weight: bold;color: #333;">Segunda</span>-->
<!--                <small style="font-size: 12px;">Segunda</small>-->
<!--                <span style="font-size: 15px;font-weight: bold;color: #555;">R$ 12,00</span>-->
<!--            </div>-->
<!--            <div>-->
<!--                <div class="btn-group" role="group" aria-label="Basic example">-->
<!--                    <button type="button" class="btn btn-outline-success" style="background-color: #00968817;border:#00968817;border-radius: 8px;color: green;">-</button>-->
<!--                    <input type="number" value="1" class="input-cart-qt" style="width: 35px;border:none;">-->
<!--                    <button type="button" class="btn btn-success" style="background-color: #22bb9c;border:#22bb9c;border-radius: 8px;">+</button>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <div class="cart-item shadow">-->
<!--            <div>-->
<!--                <img src="http://192.168.100.5/descomplicazap/assets/img/products/bbqseg.jpeg" class="img-cart" alt="">-->
<!--            </div>-->
<!--            <div class="cart-item--info">-->
<!--                <span style="font-weight: bold;color: #333;">Segunda</span>-->
<!--                <small style="font-size: 12px;">Segunda</small>-->
<!--                <span style="font-size: 15px;font-weight: bold;color: #555;">R$ 12,00</span>-->
<!--            </div>-->
<!--            <div>-->
<!--                <div class="btn-group" role="group" aria-label="Basic example">-->
<!--                    <button type="button" class="btn btn-outline-success" style="background-color: #00968817;border:#00968817;border-radius: 8px;color: green;">-</button>-->
<!--                    <input type="number" value="1" class="input-cart-qt" style="width: 35px;border:none;">-->
<!--                    <button type="button" class="btn btn-success" style="background-color: #22bb9c;border:#22bb9c;border-radius: 8px;">+</button>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->

        <div class="line-cart"></div>

        <button class="btn btn-success btn-block" style="background-color: #22bb9c;border:#22bb9c;width: 100%;padding: 12px;border-radius: 10px;">Enviar Pedido</button>
    </div>
</main>
</div>

<!-- Optional JavaScript; choose one of the two! -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
<!-- Option 1: Bootstrap Bundle with Popper -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
</script> -->

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
-->

<script>var company = <?= json_encode(getStore()->information['id_company'])?></script>
<script src="<?=url('assets/js/cardapio/main.js')?>"></script>
</body>

</html>