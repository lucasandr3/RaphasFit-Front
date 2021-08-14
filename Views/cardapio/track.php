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
    <title>Pedido - <?=$viewData['title']?></title>
    <link rel="shortcut icon" href="" />
    <!--<script>var track = <?= json_encode($order);?></script>-->
</head>

<body>

    <div class="shadow" style="height: 60px;display: flex !important;align-items: center;background-color:white;">
        <!--<div class="display: flex !important;align-items: center !important;">-->
            <img src="<?=json_decode($order->name_company)[1];?>" style="width: 45px !important;height: 45px !important;border-radius: 10px !important;margin-left:15px;" />
            <p style="margin: 0;color: #555;filter: none;font-size: 20px;margin-left:5px;font-weight:bold;"><?=json_decode($order->name_company)[0];?></p>
        <!--</div>-->
    </div>

    <div class="container mt-3 mb-5">
	<main>
        <div class="row">
                <div class="col-md-6 offset-md-3">
                    <h5 style="margin-left: 5px;margin-bottom: -30px;">Acompamento do Pedido <?=$viewData['title']?></h5>
                    <ul class="timeline">
                        <?php if($order->order_status === 'WAITING'): ?>
                            <div class="balao"></div>
                            <li id="waiting">
                                <a target="#" href="#">Pedido Enviado</a>
                                <p>Aguardando confirmação do estabelecimento</p>
                            </li>
    
                            <div class="balao2"></div>
                            <li  id="progress" class="disabled">
                                <a href="#">Pedido Confirmado</a>
                                <p>Pedido Confirmado, e está sendo preparado</p>
                            </li>
    
                            <div class="balao"></div>
                            <li  id="delivery" class="disabled">
                                <a href="#">Saiu para Entrega</a>
                                <p>Motoboy saiu para entrega</p>
                            </li>
                        <?php endif; ?>
                        
                        <?php if($order->order_status === 'PROGRESS'): ?>
                            <div class="balao"></div>
                            <li id="waiting">
                                <a target="_blank" href="#">Pedido Enviado</a>
                                <p>Aguardando confirmação do estabelecimento</p>
                            </li>
    
                            <div class="balao"></div>
                            <li  id="progress">
                                <a href="#">Pedido Confirmado</a>
                                <p>Pedido Confirmado, e está sendo preparado</p>
                            </li>
    
                            <div class="balao"></div>
                            <li  id="delivery" class="disabled">
                                <a href="#">Saiu para Entrega</a>
                                <p>Motoboy saiu para entrega</p>
                            </li>
                        <?php endif; ?>
                        
                        <?php if($order->order_status === 'DELIVERY'): ?>
                            <div class="balao"></div>
                            <li id="waiting">
                                <a target="_blank" href="#">Pedido Enviado</a>
                                <p>Aguardando confirmação do estabelecimento</p>
                            </li>
    
                            <div class="balao2"></div>
                            <li  id="progress">
                                <a href="#">Pedido Confirmado</a>
                                <p>Pedido Confirmado, e está sendo preparado</p>
                            </li>
    
                            <div class="balao3"></div>
                            <li  id="delivery">
                                <a href="#">Saiu para Entrega</a>
                                <p>Motoboy saiu para entrega</p>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="card-final">
            <?php foreach(json_decode($order->order_object) as $obj): ?>
                <p style="font-size: 15px;margin: 5px 5px;text-transform: capitalize;"><?=$obj->nameProduct;?> - <?=real($obj->priceProduct)?></p>
                <div class="line"></div>
                <?php if(sizeOf($obj->aditional) > 0): ?>
                    <div style="margin-left: 15px;">
                        [ adicionais
                        <?php foreach($obj->aditional as $ad): ?>
                            <p style="font-size: 15px;margin: 5px 20px;text-transform: capitalize;"><?=$ad->item?> - <?=real($ad->preco)?></p>
                        <?php endforeach; ?>
                        ]
                    </div>
                    <div class="line"></div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        
        <div style="text-align:center;margin: 10px 10px;">
            <a href="<?=url('pedido/entregue/'.$order->id)?>" class="btn btn-success btn-block" style="width:100%;margin-bottom: 50px;">Pedido foi Entregue</a>
        </div>

    </main>
  
    <style>
        ul.timeline {
    list-style-type: none;
    position: relative;
}
ul.timeline:before {
    content: ' ';
    background: #d4d9df;
    display: inline-block;
    position: absolute;
    left: 8px;
    width: 2px;
    height: 100%;
    z-index: 400;
}
ul.timeline > li {
    background-color: #FFF;
    border-radius: 5px;
    margin: 50px 0;
    padding-left: 20px;
}
ul.timeline > li:before {
    content: ' ';
    background: #22bb9c;
    display: inline-block;
    position: absolute;
    border-radius: 50%;
    border: 3px solid #22bb9c;
    left: -1px;
    width: 20px;
    height: 20px;
    z-index: 400;
    animation: animate 3s linear infinite
}

a {
    text-decoration: none;
    color: #555;
    font-weight: bold;
}

.pulse {
    width: 70px;
    height: 70px;
    background-color: red;
    border-radius: 50%;
    position: relative;
    animation: animate 3s linear infinite
}

.pulse i {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 30px;
    color: #fff;
    height: 100%;
    cursor: pointer
}

@keyframes animate {
    0% {
        box-shadow: 0 0 0 0 rgb(32, 173, 36, 0.48), 0 0 0 0 rgb(34, 187, 156, 1)
    }

    40% {
        box-shadow: 0 0 0 30px rgb(255, 109, 74, 0), 0 0 0 0 rgb(34, 187, 156, 1)
    }

    80% {
        box-shadow: 0 0 0 30px rgb(255, 109, 74, 0), 0 0 0 20px rgb(255, 109, 74, 0)
    }

    100% {
        box-shadow: 0 0 0 0 rgb(255, 109, 74, 0), 0 0 0 20px rgb(255, 109, 74, 0)
    }
}

.disabled {
    opacity: 0.3;
}

.card-final {
    background-color: #fff;
    margin: 0 10px;
    border-radius: 5px;
    padding: 10px;
    margin-top: -80px;
}

.balao {
    content: "";
    position: absolute;
    top: 0px;
    left: 21px;
    border-width: 0px 15px 15px 0px;
    border-style: solid;
    border-color: #ccdbdc00 #fff;
    display: block;
    width: 0;
}

.balao2 {
    content: "";
    position: absolute;
    top: 122px;
    left: 21px;
    border-width: 0px 15px 15px 0px;
    border-style: solid;
    border-color: #ccdbdc00 #fff;
    display: block;
    width: 0;
}

.balao3 {
    content: "";
    position: absolute;
    top: 244px;
    left: 21px;
    border-width: 0px 15px 15px 0px;
    border-style: solid;
    border-color: #ccdbdc00 #fff;
    display: block;
    width: 0;
}

.line {
    margin: 1rem 0;
    border: 1px dotted;
    border-color: #aaa;
}
    </style>

  
    <script>var company = <?= json_encode(getStore()->information['id_company'])?></script>
    <script>var phone_company = <?= json_encode(getStore()->information['phone'])?></script>
    <script>var products_shedule = <?= json_encode($categories)?></script>
    <script src="<?=url('assets/js/cardapio/main.js')?>"></script>
</body>

</html>