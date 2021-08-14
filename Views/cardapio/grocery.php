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
    <link rel="stylesheet" href="<?=($config['skin'] === 'dark' ? url('assets/css/dark.css') : '') ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <title><?=getStore()->information['name_store']?></title>
    <link rel="shortcut icon" href="<?=getStore()->information['logo']?>" />
    <style>
        .nav-p-fix {
            background: <?=getStore()->config['color_primary']?>!important;
        }
    </style>
</head>

<body>

    <header style="background-image: url(<?=getStore()->information['cover']?>);background-size: cover;">
        <div class="bg-opacity">
            <div class="box-header">
                <img src="<?=getStore()->information['logo']?>" alt="<?=getStore()->information['name_store']?>">
                <h2><?=getStore()->information['name_store']?></h2>
                <p><?=getStore()->information['neighborhood']?>, <?=getStore()->information['number']?> -
                    <?=getStore()->information['city']?></p>
                <?php if(getStore()->information['open_status'] === 'OPEN'): ?>
                <span class="open">Aberto</span>
                <?php else: ?>
                <span class="close">Fechado</span>
                <?php endif; ?>
                <button><span class="material-icons" style="margin-right:5px;">access_time</span>Entrega:
                    <?=getStore()->information['delivery_time']?></button>
            </div>
        </div>
    </header>

    <main>
        
        <!--<div class="tab">-->
        <!--    <button class="tablinks active" style="font-weight: bold;" onclick="openCity(event, 'cardapio')">-->
        <!--        <?php if(getStore()->information['open_status'] === 'OPEN'):?>-->
                    
        <!--        <?php else: ?>-->
        <!--            <div class="msg-div-close">-->
        <!--    <span>Loja fechada! Abre às 16:00hs</span>        -->
        <!--</div>-->
        <!--        <?php endif; ?>-->
        <!--    </button>-->
            <!-- <button class="tablinks" style="font-weight: bold;" onclick="openCity(event, 'informacao')">
                <span class="material-icons">
                    bookmarks
                </span>Promoções
            </button> -->
            <!-- <button class="tablinks" onclick="openCity(event, 'Tokyo')">
    <span class="material-icons">
      location_on
    </span>Informações
  </button> -->

        <!--</div>-->

        <div id="cardapio" class="tabcontent" style="display:block;">
            <div class="inputarea">
                <input type="text" class="input-custom"
                    onKeyDown="seachProducts(this.value, '<?=getStore()->information['id_company']?>')"
                    placeholder="Procurar...">
                <div class="icon-area">
                    <span class="material-icons" style="color:#555;">
                        search
                    </span>
                </div>
            </div>

            <div id="search-div"></div>
            <div id="search-hide">
                <nav class="navTop">
                    <?php foreach($categories as $category): ?>
                    <a href="#<?=$category['name_category']?>" class="botones-menu shadow" id="categ-menu-a">
                        <p><?=$category['name_category']?></p>
                    </a>
                    <?php endforeach; ?>
                </nav>

                <?php foreach($menu as $item): ?>
                <h2 id="<?=$item['name_category']?>" class="name-category shadow"><?=$item['name_category']?></h2>
                <?php if($config['view_products'] == '0'): ?>
                    <div style="">
                <?php else: ?>
                    <div style="display:grid;grid-template-columns: 1fr 1fr;grid-column-gap: 10px;">
                <?php endif; ?>
                <?php foreach($item['products'] as $prod): ?>

                <?php if($config['view_products'] == '0'): ?>
                <div class="card-c shadow" onclick="verifyDay('<?=$prod['id']?>','<?=$prod['category']?>')">
                    <?php if($prod['promo'] === 'yes'): ?>
                        <div class="ribbon">
                            <div class="wrap">
                                <span class="ribbon6">Promoção</span>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="row-c">
                        <div class="img-c">
                            <img src="<?=$prod['image']?>" class="img-card" alt="<?=$prod['name_product']?>">
                        </div>
                        <div class="info-c">
                            <h5 class="card-title" style="font-weight:bold;color:#555;"><?=$prod['name_product']?></h5>
                            <p class="card-text text-truncate" style="color: #777;font-size: 0.9rem;width: 210px;">
                                <?=$prod['description']?></p>
                            <p class="card-text"><span
                                    style="color: #d25850;font-weight: bold;letter-spacing: 1px;"><?=real($prod['price'])?></span>
                            </p>
                        </div>
                    </div>
                </div>

                <?php else: ?>
                
                    <div class="card" onclick="verifyDay('<?=$prod['id']?>','<?=$prod['category']?>')" style="border-radius: 10px;filter: drop-shadow(0px 1px 5px rgba(0, 0, 0, 0.2));margin: 0px 0px 15px 0px;">
                        <?php if($prod['promo'] === 'yes'): ?>
                            <div class="ribbon">
                                <div class="wrap">
                                    <span class="ribbon6">Promoção</span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="<?=$prod['image']?>" style="width:100%;border-radius: 10px;object-fit: cover;height:120px;"
                                    alt="<?=$prod['name_product']?>">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title" style="font-weight:bold;color:#555;text-align:center;"><?=$prod['name_product']?>
                                    </h5>
                                    <p class="card-text" style="color: #777;font-size: 0.9rem;text-align:center;">
                                        <?=$prod['description']?></p>
                                    <p class="card-text" style="text-align:center;">
                                        <?php if($prod['promo'] === 'yes'): ?>
                                            <span class="span-price-dark" style="color: #d25850;opacity: 0.3;margin-right: 10px;"><s><?=real($prod['price'])?></s></span>
                                            <span class="span-price-dark" style="color: #d25850;font-weight: bold;"><?=real($prod['promo_price'])?></span>
                                        <?php else: ?>
                                            <span class="span-price-dark" style="color: #d25850;font-weight: bold;"><?=real($prod['price'])?></span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                        <!-- Modal -->
                        <div class="modal fade" id="modalproduct<?=$prod['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog modal-fullscreen">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title text-capitalize" id="exampleModalLabel"><?=$prod['name_product']?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body" style="padding:0;">
                                        <img src="<?=$prod['image']?>" class="img-modal-cart" id="img-cart<?=$prod['id']?>">
                                        <div class="price-cart-modal shadow">
                                            <div class="cifrao-rounded">R$</div>
                                            <?php if($prod['promo'] === 'yes'): ?>
                                                <div class="price-rounded"><?=realNo($prod['promo_price'])?></div>
                                            <?php else: ?>
                                                <div class="price-rounded"><?=realNo($prod['price'])?></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="content-modal">
                                            <p class="p-desc-dark" style="margin-top: 25px;color: #555;"><?=$prod['description']?></p>
                                            <?php foreach($p_options as $option): ?>
                                                <?php if($prod['id'] === $option['id']): ?>
                                                    <?php foreach($option['options'] as $op): ?>
                                                        <h2 class="h2-modal"><?=$op['name_option']?></h2>
                                                        <?php foreach($op['options_categorie_item'] as $items): ?>
                                                            <div class="form-check">
                                                                <div>
                                                                    <input class="form-check-input check-options" type="checkbox" value="<?=$items['name_option_item']?>,<?=$items['price_option_item']?>" id="<?=$items['name_option_item']?>">
                                                                    <label class="form-check-label" for="<?=$items['name_option_item']?>">
                                                                        <?=$items['name_option_item']?>
                                                                    </label>
                                                                </div>
                                                                <div>
                                                                    <span class="price-option-dark"><?=realNo($items['price_option_item'])?></span>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                            <div>
                                                    <br/>
                                                <div class="qtp-cart">
                                                    <h2 class="h2-qtd-dark" style="font-size: 1.3rem;color: #333;">Quantidade</h2>
                                                    <div class="btn-group" style="flex:1;margin-left: 40px;" role="group" aria-label="Basic example">
                                                        <button type="button" class="btn btn-outline-secondary" onclick="cartMinus('<?=$prod['id']?>')">-</button>
                                                        <input type="number" value="1" class="input-cart-qt" id="indicator-cart<?=$prod['id']?>"/>
                                                        <button type="button" class="btn btn-outline-secondary" onclick="cartMore('<?=$prod['id']?>')">+</button>
                                                    </div>
                                                </div>
                                            </div><br/>
                                            <input type="hidden" value="<?=$prod['name_product']?>" id="name_product_modal<?=$prod['id']?>"/>
                                            <?php if($prod['promo'] === 'yes'): ?>
                                                <input type="hidden" value="<?=$prod['promo_price']?>" id="price-cart<?=$prod['id']?>"/>
                                            <?php else: ?>
                                                <input type="hidden" value="<?=$prod['price']?>" id="price-cart<?=$prod['id']?>"/>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?php
                                    $semana = ["Domingo" => "Domingo", "Segunda-feira" => "Segunda-feira", "Terça-feira" => "Terça-feira", "Quarta-feira" => "Quarta-feira", "Quinta-feira" => "Quinta-feira", "Sexta-feira" => "Sexta-feira", "Sábado" => "Sábado"];
                                    $hora = Date('H');
                                    $day = $prod['name_product'];
                                    $dia = ucfirst(strftime("%A", strtotime("d")));                   
                                    ?>
                                    <?php if($prod['shedule'] === 'true'): ?>
                                        <?php if($dia === $semana[$day]): ?>
                                        <div class="m-footer-dark" style="display:flex;padding:10px;border-top: 1px solid #dee2e6;" id="btn-day-cart<?=$prod['id']?>">
                                            <button type="button" id="btn-close-modal" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                                    style="display: flex;margin-right: 15px;" onclick="closeModal()"><span class="material-icons"
                                                                                                                        style="margin-right:5px;">keyboard_backspace</span> Voltar</button>
                                            <button type="button" class="btn btn-success" style="width:100%;" onclick="mountOrder('<?=$prod['id']?>')">Adicionar ao
                                                carrinho</button>
                                        </div>
                                        <?php else: ?>
                                        <div class="m-footer-dark" style="display:none;padding:10px;border-top: 1px solid #dee2e6;" id="btn-not-day-cart<?=$prod['id']?>">
                                            <button type="button" id="btn-close-modal" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                                    style="display: flex;justify-content:center;width: 100%;" onclick="closeModal()"><span class="material-icons"
                                                                                                                        style="margin-right:5px;">keyboard_backspace</span> Voltar</button>
                                        </div>
                                        <?php endif; ?>
                                        <?php else: ?>
                                            <div class="m-footer-dark" style="display:flex;padding:10px;border-top: 1px solid #dee2e6;" id="btn-day-cart<?=$prod['id']?>">
                                            <button type="button" id="btn-close-modal" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                                                    style="display: flex;margin-right: 15px;" onclick="closeModal()"><span class="material-icons"
                                                                                                                        style="margin-right:5px;">keyboard_backspace</span> Voltar</button>
                                            <button type="button" class="btn btn-success" style="width:100%;" onclick="mountOrder('<?=$prod['id']?>')">Adicionar ao
                                                carrinho</button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <!-- fim modal -->
                <?php endforeach; ?>
                </div>
                <?php endforeach; ?>
            </div>

            <div id="informacao" class="tabcontent">
                <div class="info-box">
                    <h2 class="h2-info"><?=getStore()->information['name_store']?></h2>
                    <p><span class="material-icons">location_on</span><?=getStore()->information['neighborhood']?>,
                        <?=getStore()->information['number']?> - <?=getStore()->information['city']?></p>
                    <a href="https://api.whatsapp.com/send?phone=5534988373408&text=Ol%C3%A1%2C%20preciso%20de%20ajuda%20!!"
                       target="_blank" class="phone"><span
                                class="material-icons">perm_phone_msg</span><?=getStore()->information['phone']?></a>
                    <h2 class="h2-info">Horário de Funcionamento</h2>
                    <div>
                        <ul style="display: flex;padding-left:0;margin-bottom: 0rem;">
                            <div>
                                <li class="our-day">Domingo:</li>
                            </div>
                            <div><span><?=getStore()->information['sunday_time']?></span></div>
                        </ul>
                        <ul style="display: flex;padding-left:0;margin-bottom: 0rem;">
                            <div>
                                <li class="our-day">Segunda:</li>
                            </div>
                            <div><span><?=getStore()->information['monday_time']?></span></div>
                        </ul>
                        <ul style="display: flex;padding-left:0;margin-bottom: 0rem;">
                            <div>
                                <li class="our-day">Terça:</li>
                            </div>
                            <div><span><?=getStore()->information['tuesday_time']?></span></div>
                        </ul>
                        <ul style="display: flex;padding-left:0;margin-bottom: 0rem;">
                            <div>
                                <li class="our-day">Quarta:</li>
                            </div>
                            <div><span><?=getStore()->information['wednesday_time']?></span></div>
                        </ul>
                        <ul style="display: flex;padding-left:0;margin-bottom: 0rem;">
                            <div>
                                <li class="our-day">Quinta:</li>
                            </div>
                            <div><span><?=getStore()->information['thursday_time']?></span></div>
                        </ul>
                        <ul style="display: flex;padding-left:0;margin-bottom: 0rem;">
                            <div>
                                <li class="our-day">Sexta:</li>
                            </div>
                            <div><span><?=getStore()->information['friday_time']?></span></div>
                        </ul>
                        <ul style="display: flex;padding-left:0;margin-bottom: 0rem;">
                            <div>
                                <li class="our-day">Sábado:</li>
                            </div>
                            <div><span><?=getStore()->information['saturday_time']?></span></div>
                        </ul>
                    </div>
                </div>
            </div>

            <div id="Tokyo" class="tabcontent">
                <h3>Tokyo</h3>
                <p>Tokyo is the capital of Japan.</p>
            </div>


            <a onclick="cartData()" class="btn btn-warning btn-float" style="display: none;"><span class="material-icons">shopping_bag</span></a>
    </main>
    </div>
    <!-- Modal cart -->

    <!-- First modal dialog -->
    <div class="modal fade" id="modalcart" aria-hidden="true" aria-labelledby="..." tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Minha Sacola</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="cart-item"></div>
                    <div class="line-cart"></div>
                    <div class="card-op-entrega shadow">
                        <h2>Opção de Entrega</h2>
                        <div class="card-address-session">
                            <div><span class="material-icons i-addrr">location_on</span></div>
                            <div>
                                <h3 class="h3-addrr" style="color: #333;font-size: 18px;" id="delivery-city">Cidade</h3>
                                <p class="p-addrr" id="delivery-address" style="font-size: 14px;margin-bottom:0px;">Endereço</p>
<!--                                <button class="btn-address" onclick="deleteAddress()"><span class="material-icons">delete</span> Deletar</button>-->
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="retirada-cart">
                            <label class="form-check-label" for="retirada-cart">
                                Retirada no local
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="entrega-cart">
                            <label class="form-check-label" for="entrega-cart">
                                Entrega
                            </label>
                        </div>
                        <div class="btn-show-address">
                            <button class="btn btn-primary btn-add-c-t" style="width: 100%;background-color: indigo;border:indigo;border-radius:8px;" data-bs-target="#modal2" data-bs-toggle="modal" data-bs-dismiss="modalcart" id="btn-confirm-address">Informar Endereço</button>
                        </div>
                    </div>
                    <div class="card-payment shadow">
                        <div class="col-12">
                            <label for="inputAddress2" class="form-label">Forma de Pagamento <span class="text-danger">*</span></label>
                            <select class="form-control"  onchange="formaPagamento(this.value)">
                                <option value="">Forma de Pagamento</option>
                                <option value="Dinheiro">Dinheiro</option>
                                <option value="Cartão de Crédito">Cartão de Crédito</option>
                                <option value="Cartão de Débito">Cartão de Débito</option>
                            </select>
                        </div>
                        <div class="card-troco" style="margin-top: 10px">
                            <div class="col-12" style="display: none;" id="troco">
                                <label class="form-label">Troco <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" placeholder="Digite o valor" id="troco-value" onkeyup="trocoLocal()">
                            </div>
                        </div>
                    </div>
                    <div class="card-whatsapp shadow">
                        <div class="col-12">
                            <label class="form-label">Nome <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Digite seu nome" id="client-name">
                        </div>
                        <div class="col-12" style="margin-top: 10px;">
                            <label class="form-label">Whatsapp <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" placeholder="Digite seu Whatsapp" onkeydown="clientSave()" id="client-phone">
                        </div>
                    </div>
                    <div class="card-total shadow">
                        <div class="total-item">
                            <p><b>Total do Pedido</b></p>
                            <span id="total-pedido-final">R$ 0,00</span>
                        </div>
                        <div class="total-item">
                            <p><b>Entrega</b></p>
                            <span id="total-entrega-final">R$ 0,00</span>
                        </div>
                        <hr style="margin-top: 5px;" />
                        <div class="total-item">
                            <p><b>Total</b></p>
                            <span id="total-final"><b>R$ 0,00</b></span>
                        </div>
                    </div>
                </div>
                <div class="m-footer-dark" style="display:flex;padding:10px;border-top: 1px solid #dee2e6;">
                    <button type="button" id="btn-close-modal" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            style="display: flex;margin-right: 15px;" onclick="closeModal()"><span class="material-icons"
                                                                                                   style="margin-right:5px;">keyboard_backspace</span> Voltar</button>
                    <button type="button" class="btn btn-success" style="width:100%;" onclick="checkout()">
                        Enviar Pedido
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16" style="margin-top: -8px;">
                            <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Second modal dialog -->
    <div class="modal fade" id="modal2" aria-hidden="true" aria-labelledby="..." tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Endereço para Entrega</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3">
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">CEP</label>
                        <input type="tel" class="form-control" placeholder="00000000" id="cep-address">
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">Rua, avenida, praça, travessa <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Digite aqui a rua" id="rua-address">
                    </div>
                    <div class="col-12">
                        <label for="inputAddress" class="form-label">Numero <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="numero-address" placeholder="Digite aqui o Numero">
                    </div>
                    <div class="col-12">
                        <label for="inputAddress2" class="form-label">Bairro <span class="text-danger">*</span></label>
                        <select class="form-control"  id="bairro-address" required>
                            <option value="">Escolha o Bairro</option>
                            <?php foreach($bairros as $b): ?>
                                <option value="<?=$b['nome_bairro']?>,<?=$b['taxa_entrega']?>"><?=$b['nome_bairro']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="inputAddress2" class="form-label">Estado <span class="text-danger">*</span></label>
                        <select class="form-control"  id="estado-address" required>
                            <option value="AC">Acre</option>
                            <option value="AL">Alagoas</option>
                            <option value="AP">Amapá</option>
                            <option value="AM">Amazonas</option>
                            <option value="BA">Bahia</option>
                            <option value="CE">Ceará</option>
                            <option value="DF">Distrito Federal</option>
                            <option value="ES">Espírito Santo</option>
                            <option value="GO">Goiás</option>
                            <option value="MA">Maranhão</option>
                            <option value="MT">Mato Grosso</option>
                            <option value="MS">Mato Grosso do Sul</option>
                            <option value="MG">Minas Gerais</option>
                            <option value="PA">Pará</option>
                            <option value="PB">Paraíba</option>
                            <option value="PR">Paraná</option>
                            <option value="PE">Pernambuco</option>
                            <option value="PI">Piauí</option>
                            <option value="RJ">Rio de Janeiro</option>
                            <option value="RN">Rio Grande do Norte</option>
                            <option value="RS">Rio Grande do Sul</option>
                            <option value="RO">Rondônia</option>
                            <option value="RR">Roraima</option>
                            <option value="SC">Santa Catarina</option>
                            <option value="SP">São Paulo</option>
                            <option value="SE">Sergipe</option>
                            <option value="TO">Tocantins</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="inputAddress2" class="form-label">Cidade <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="cidade-address" placeholder="Digite aqui o bairro">
                    </div>
                    <div class="col-md-12">
                        <label for="inputCity" class="form-label">Ponto de Referência</label>
                        <input type="text" class="form-control" id="ref-address" placeholder="Digite aqui...">
                    </div>
                </form>
            </div>
                <div class="m-footer-dark" style="display:flex;padding:10px;border-top: 1px solid #dee2e6;">
<!--                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
                    <button type="button" id="btn-close-modal-address" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            style="display: flex;margin-right: 15px;"><span class="material-icons"
                                                                                                   style="margin-right:5px;">keyboard_backspace</span> Voltar</button>
                    <button type="button" class="btn btn-primary btn-add-c-t" style="width:100%;background-color: indigo;border: indigo" onclick="confirmAdrress()">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Open first dialog -->

    <!-- Modal -->
    <div class="modal fade" id="modalproductadicionais" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-capitalize name-adi" id="exampleModalLabel">--</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding:0;">
                    <img src="<?=$prod['image']?>" class="img-modal-cart" id="img-cart<?=$prod['id']?>">
                    <div class="content-modal">
                        <?php foreach($p_options as $key => $option): ?>
                            <?php if($prod['id'] === $option['id']): ?>
                                <?php foreach($option['options'] as $op): ?>
                                    <h2 class="h2-modal"><?=$op['name_option']?></h2>
                                    <?php foreach($op['options_categorie_item'] as $items): ?>
                                        <div class="form-check">
                                            <div>
                                                <input class="form-check-input check-options-add-c" type="checkbox" value="<?=$items['name_option_item']?>,<?=$items['price_option_item']?>" id="<?=$items['name_option_item']?>">
                                                <label class="form-check-label" for="<?=$items['name_option_item']?>">
                                                    <?=$items['name_option_item']?>
                                                </label>
                                            </div>
                                            <div>
                                                <span class="price-option-dark"><?=realNo($items['price_option_item'])?></span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="m-footer-dark" style="display:flex;padding:10px;border-top: 1px solid #dee2e6;" id="">
                    <button type="button" id="btn-close-modal" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            style="display: flex;margin-right: 15px;" onclick="closeModal()"><span class="material-icons"
                                                                                                   style="margin-right:5px;">keyboard_backspace</span> Voltar</button>
                    <button type="button" class="btn btn-success" style="width:100%;" onclick="updateAditionais('<?=$key?>')">Atualizar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- fim modal -->

    <!-- fim modal cart -->
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
    <script>var company = <?= json_encode(getStore()->information['id_company']);?></script>
    <script>var phone_company = <?= json_encode(getStore()->information['phone']);?></script>
    <script src="<?=url('assets/js/cardapio/main.js')?>"></script>
</body>

</html>