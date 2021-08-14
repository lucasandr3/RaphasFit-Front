let cart = [];
let address = {};
let pagamento = {};
let client = {};
let total = {};
let qtModal = 1;
document.querySelector('.input-cart-qt').value = qtModal;
//document.querySelector('#retirada-cart').checked = true;
// Define a Compania
sessionStorage.setItem('company'+company, company);
// document.querySelector('.btn-float').style.display = 'none';

if(localStorage.getItem('address'+company)) {
    address = JSON.parse(localStorage.getItem('address'+company));
    //document.querySelector('.card-address-session').style.display = 'flex';
    document.querySelector('#delivery-city').innerText = (address.cidade)?address.cidade:'Cidade';
    document.querySelector('#delivery-address').innerText = `${address.rua} - ${address.bairro.split(',')[0]}, ${address.numero}`;
    document.querySelector('#btn-confirm-address').innerText = 'Trocar Endereço';
    //document.querySelector('.btn-show-address').style.display = 'block';
   // document.querySelector('#entrega-cart').checked = true;
} else {
    let addressObjectBackup = {
        cep:'',rua:'',numero:'',estado:'',cidade:'',bairro:'',entrega:0,referencia:''
    }
    localStorage.setItem('address'+company, JSON.stringify(addressObjectBackup));
    //document.querySelector('#retirada-cart').checked = true;
}

if(sessionStorage.getItem('temp_cart'+company)) {
    cart = JSON.parse(sessionStorage.getItem('temp_cart'+company))

    if(JSON.stringify(cart) !== '[]') {
        verifyBag()
        document.querySelector('.btn-float').style.display = 'flex';
    }
    //document.querySelector('#retirada-cart').checked = true
}

if(localStorage.getItem('client-descomplica'+company)) {
    client = JSON.parse(localStorage.getItem('client-descomplica'+company));
    document.querySelector('#client-name').value = client.name;
    document.querySelector('#client-phone').value = client.phone;
}

function verifyBag() {
    cart = JSON.parse(sessionStorage.getItem('temp_cart'+company))
    let totalBag = 0;
    let totalAdBag = 0;
    let adicionais = [];

    for (let i = 0; i < cart.length; i++) {
        totalBag += cart[i].priceProduct * cart[i].quantityProduct;
        adicionais = cart[i].aditional;
        for (let ia = 0; ia < adicionais.length; ia++) {
            totalAdBag += parseInt(cart[i].aditional[ia].preco);
        }
    }
    document.querySelector('#total-bag-cart').innerText = ` - ${real(totalBag + totalAdBag)}`;
}

if(sessionStorage.getItem('pagamento'+company)) {
    let pp = JSON.parse(sessionStorage.getItem('pagamento'+company));
    let options_pay = document.querySelector('#pay-cart-sel').options;
  
    for (let p = 0; p < options_pay.length; p++) {

        if(options_pay[p].value === pp.pagamento) {
            options_pay[p].selected = true
            document.querySelector('#troco').style.display = 'none';
            document.querySelector('#troco-value').value = '';
        } 

        if(options_pay[p].value === 'Dinheiro') {
            options_pay[p].selected = true
            document.querySelector('#troco').style.display = 'block';
            document.querySelector('#troco-value').value = pp.troco;
        } 
    }
}

function mountOrder(id) {
    let idProduct = id;
    let nameProduct = document.querySelector('#name_product_modal'+id).value;
    let priceProduct = document.querySelector('#price-cart'+id).value;
    let quantityProduct = parseInt(document.querySelector('#indicator-cart'+id).value);
    let imgProdcut = document.querySelector('#img-cart'+id).src;
    let inputsOptions = document.querySelectorAll('.check-options');
    let aditional = [];

    for (const op in inputsOptions) {
        if (inputsOptions[op].checked === true) {
            let options = inputsOptions[op].value.split(",");
            let adicionais = {op:options[2],item:options[0], preco:options[1]};
            aditional.push(adicionais);
            inputsOptions[op].checked = false;
        }
    }

    let productObject = {
        idProduct,
        nameProduct,
        priceProduct,
        quantityProduct,
        aditional,
        imgProdcut,
    };
    cart.push(productObject)
    sessionStorage.setItem('temp_cart'+company, JSON.stringify(cart))
    qtModal = 1;
    document.querySelector('.btn-float').style.display = 'flex'
    // document.querySelector('#btn-close-modal').click();
    // updateCart();
    verifyBag();
    aditional = [];
    let inputs = document.querySelectorAll('.check-options');
    for (let i = 0; i < inputs.length; i++) {
        if(inputs[i].checked === true) {
            inputs[i].checked = false
        }
        if(inputs[i].attributes.disabled) {
            inputs[i].removeAttribute('disabled')
        }
    }
    $('#modalproduct'+id).modal('hide')
}

function confirmAdrress() {
    let cep = document.querySelector('#cep-address').value;
    let rua = document.querySelector('#rua-address').value;
    let numero = document.querySelector('#numero-address').value;
    let estado = document.querySelector('#estado-address').value;
    let cidade = document.querySelector('#cidade-address').value;
    let bairro = document.querySelector('#bairro-address').value;
    let referencia = document.querySelector('#ref-address').value;
    let entrega = parseInt(bairro.split(',')[1]);

    if(rua === '') {
        Swal.fire({
            position: "center",
            type: "warning",
            title: "Você precisa informar a Rua",
            showConfirmButton: true,
        });
    }

    if(numero === '') {
        Swal.fire({
            position: "center",
            type: "warning",
            title: "Você precisa informar o Número",
            showConfirmButton: true,
        });
    }

    if(estado === '') {
        Swal.fire({
            position: "center",
            type: "warning",
            title: "Você precisa informar o estado",
            showConfirmButton: true,
        });
    }

    if(cidade === '') {
        Swal.fire({
            position: "center",
            type: "warning",
            title: "Você precisa informar a Cidade",
            showConfirmButton: true,
        });
    }

    if(bairro === '') {
        Swal.fire({
            position: "center",
            type: "warning",
            title: "Você precisa informar a Bairro",
            showConfirmButton: true,
        });
    } else {
        let addressObject = {
            cep,rua,numero,estado,cidade,bairro,entrega,referencia
        }
        let addressObjectBackup = {
            cep:'',rua:'',numero:'',estado:'',cidade:'',bairro:'',entrega:0,referencia:''
        }
        //address.push(addressObject)
        localStorage.setItem('address'+company, JSON.stringify(addressObject))
        localStorage.setItem('address-backup'+company, JSON.stringify(addressObjectBackup))
        localStorage.setItem('delivery'+company, 'entrega');
        document.querySelector('#btn-close-modal-address').click();
        document.querySelector('#delivery-city').innerText = cidade;
        document.querySelector('#delivery-address').innerText = `${rua} - ${bairro.split(',')[0]}, ${numero}`;
        document.querySelector('#btn-confirm-address').innerText = 'Trocar Endereço';
        document.querySelector('.card-address-session').style.display = 'flex';
    }

    updateCart();
}

function deleteAddress() {
    localStorage.removeItem('address');
    localStorage.removeItem('address-backup');
    document.querySelector('.card-address-session').style.display = 'none';
    document.querySelector('#btn-confirm-address').innerText = 'Informar Endereço';
    document.querySelector('#entrega-cart').checked = false
    document.querySelector('#retirada-cart').checked = true
    updateCart()
}

function cartMinus(id) {
    let cartIndicator = document.querySelector('#indicator-cart'+id);
    if(qtModal > 1) {
        qtModal--;
    }
    cartIndicator.value = qtModal;
}

function cartMore(id) {
    let cartIndicator = document.querySelector('#indicator-cart'+id);
    qtModal++;
    cartIndicator.value = qtModal;
}

function closeModal() {
    qtModal = 1;
    let inputs = document.querySelectorAll('.check-options');
    for (let i = 0; i < inputs.length; i++) {
        if(inputs[i].checked === true) {
            inputs[i].checked = false
        }
        if(inputs[i].attributes.disabled) {
            inputs[i].removeAttribute('disabled')
        }
    }
}

function cartData() {
    $('#modalcart').modal('show')
    let enderecoCartVerify = localStorage.getItem('address'+company);
    
   
    if(enderecoCartVerify) {
        document.querySelector('#entrega-cart').checked = true
        document.querySelector('#retirada-cart').checked = false
    } else {
        document.querySelector('#entrega-cart').checked = false
        document.querySelector('#retirada-cart').checked = true
    }
    let cartItem = ''
    for (const i in cart) {
        let totalca = 0;
        for (let pa = 0; pa < cart[i].aditional.length; pa++) {
            totalca += parseInt(cart[i].aditional[pa].preco);  
        }
        cartItem += `
        <div class="cart-item shadow" style="justify-content:start;">
            <div>
                <img src="${cart[i].imgProdcut}" class="img-cart" alt="">
            </div>
            <div class="cart-item--info" style="margin-left: 10px;">
                <span class="n-c-item" style="font-weight: bold;color: #333;">${cart[i].nameProduct}</span>
                <span class="p-c-item" style="font-size: 15px;font-weight: bold;color: #555;">
                    ${totalca === 0 ?real(cart[i].priceProduct * cart[i].quantityProduct):real(cart[i].priceProduct * cart[i].quantityProduct + totalca)+' <small>(com os adicionais)</small>'} 
                </span>
            </div>
        </div>
        <div class="cart-item shadow" style="display:block;margin-top: -25px;border-top-left-radius: 0;border-top-right-radius: 0;">
            <div>
                ${cart[i].aditional.length > 0 ?'<p style="margin: 10px;">Adicionais:</p>':''}
                ${cart[i].aditional.map((ad, index) => `
                    <li style="list-style: none;margin: 10px 15px;">
                        <span style="display:flex;justify-content: space-between;">
                            <div><span class="material-icons" style="margin-right: 5px;">done</span></div>
                            <div style="display: flex;justify-content: space-between;flex: 1;">
                            <div style="width:160px;"><span>${ad.item}</span></div>
                            <div><span>${real(parseInt(ad.preco))}</span><button class="btn-del-ad" onclick="delAd(${i},${index})">x</button></div>
                            </div>
                            
                        </span>
                    </li>
                `).join('\n')}
                <div style="display: flex;justify-content: space-between;align-items: center;margin: 15px 10px;">
                    <span class="p-c-item">Quantidade</span>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-outline-success btn-dark-c-minus" onclick="cartMinusCart(${cart[i].idProduct},${i})" style="background-color: #00968817;border:#00968817;border-radius: 8px;color: green;">-</button>
                        <input type="text" value="1" class="input-cart-qt-final${cart[i].idProduct}" style="width: 35px;border:none;text-align: center;">
                        <button type="button" class="btn btn-success btn-dark-c-more" onclick="cartMoreCart(${cart[i].idProduct},${i})" style="background-color: #22bb9c;border:#22bb9c;border-radius: 8px;">+</button>
                    </div>
                </div>
            </div>
        </div>
        `;
        document.querySelector('#cart-item').innerHTML = cartItem;
    }
    sessionStorage.setItem('temp_cart'+company, JSON.stringify(cart))
    updateCart();
}

function delAd(indexcart, indexad) {
    cart[indexcart].aditional.splice(indexad, 1)
    sessionStorage.setItem('temp_cart'+company, JSON.stringify(cart));
    cartData()
    updateCart()
}

//<span class="p-c-item" onclick="OpenAdicionais(${cart[i].idProduct}, ${i})">Adicionais <span class="material-icons">touch_app</span></span>

function formaPagamento(value) {

    if(value === 'Pix') {
        navigator.clipboard.writeText('34988454606');
         document.querySelector('.pix-area').style.display = 'block';
        document.querySelector('#troco').style.display = 'none';
        document.querySelector('#troco-value').value = ''
        pagamento = {pagamento:value, troco: ''}
        sessionStorage.setItem('pagamento'+company, JSON.stringify(pagamento))
    }

    if(value === 'Dinheiro') {
        document.querySelector('#troco').style.display = 'block';
        document.querySelector('#troco-value').value = ''
        pagamento = {pagamento:value, troco: ''};
        sessionStorage.setItem('pagamento'+company, JSON.stringify(pagamento))
    } else {
        document.querySelector('#troco').style.display = 'none';
        document.querySelector('#troco-value').value = ''
        pagamento = {pagamento:value, troco: ''}
        sessionStorage.setItem('pagamento'+company, JSON.stringify(pagamento))
    }
}

function trocoLocal() {
    let pp = {};
    let fpagamento = JSON.parse(sessionStorage.getItem('pagamento'+company));
    let troco = document.querySelector('#troco-value').value
    let pagt = fpagamento.pagamento;
    pp = {pagamento:pagt, troco}
    sessionStorage.setItem('pagamento', JSON.stringify(pp))
    sessionStorage.setItem('pagamento'+company, JSON.stringify(pp))
}

function clientSave() {
    let clientName = document.querySelector('#client-name').value;
    let clientPhone = document.querySelector('#client-phone').value;
    client = {name: clientName, phone: clientPhone}
    localStorage.setItem('client-descomplica'+company, JSON.stringify(client));
}

function ObsSave(value) {
    sessionStorage.setItem('obs-descomplica'+company, value);
}

document.querySelector('#retirada-cart').addEventListener('click', () => {
    document.querySelector('#entrega-cart').checked = false
    document.querySelector('.btn-show-address').style.display = 'none';
    document.querySelector('.card-address-session').style.display = 'none';
    localStorage.setItem('address-backup'+company, localStorage.getItem('address'+company));
    let add = JSON.parse(localStorage.getItem('address'+company));
    add = {
        bairro: add.bairro,
        cep: add.cep,
        cidade: add.cidade,
        entrega: 0,
        estado: add.estado,
        numero: add.numero,
        referencia: add.referencia,
        rua: add.rua,
    }
    localStorage.setItem('address'+company, JSON.stringify(add))
    localStorage.setItem('delivery'+company, 'retirada');
    updateCart()
})

document.querySelector('#entrega-cart').addEventListener('click', () => {
    document.querySelector('#retirada-cart').checked = false
    document.querySelector('.btn-show-address').style.display = 'block';
    document.querySelector('.card-address-session').style.display = 'flex';
    let end = JSON.parse(localStorage.getItem('address-backup'+company))

    if(localStorage.getItem('address'+company)) {
        document.querySelector('.card-address-session').style.display = 'flex';
        //document.querySelector('.card-address-session').style.display = 'flex';
        //document.querySelector('#delivery-city').innerText = (end.cidade)?end.cidade:'';
        //document.querySelector('#delivery-address').innerText = `${end.rua} - ${end.bairro.split(',')[0]}, ${end.numero}`;
    }
    localStorage.setItem('delivery'+company, 'entrega');
updateCart()
});

function cartMinusCart(id, index) {

    if(cart[index].quantityProduct > 1) {
        cart[index].quantityProduct--;
    } else {
        cart.splice(index, 1);
        sessionStorage.removeItem('temp_cart')
    }

    if(cart.length === 0) {
        sessionStorage.removeItem('temp_cart')
        document.querySelector('.btn-float').style.display = 'none'
        $('#modalcart').modal('hide')
    }

    updateCart();
    cartData();
    // cart[index].quantityProduct--;
    // updateCart();
    // let cartIndicator = document.querySelector('#indicator-cart'+id);
    // if(qtModal > 1) {
    //     qtModal--;
    // }
    // cartIndicator.value = qtModal;
}

function cartMoreCart(id, index) {
    cart[index].quantityProduct++;
    updateCart();
    cartData();
    // let cartIndicator = document.querySelector('#indicator-cart'+id);
    // qtModal++;
    // cartIndicator.value = qtModal;
}

function updateCart() {

    let t = 0;
    let to = 0;
    let en = 0;
    let ttt = 0;
    let total_adicionais = 0;
    for (const ct in cart) {
        t += parseInt(cart[ct].quantityProduct) * parseFloat(cart[ct].priceProduct);
        let endereco = JSON.parse(localStorage.getItem('address'+company));

        if(localStorage.getItem('delivery'+company) === 'entrega') {
            if(cart[ct].nameProduct === 'Combo Detox') {
                en = 10;
            } else if(cart[ct].nameProduct === 'Kit Detox') {
                en = 10;
            } else {

                if(parseFloat(endereco.bairro.split(',')[1])) {
                    en = parseFloat(endereco.bairro.split(',')[1]);
                } else {
                    en = 0;
                }
            }
        }
        
        console.log(en)
        for (const ad in cart[ct].aditional) {
            total_adicionais += parseInt(cart[ct].aditional[ad].preco);
        }
        to = t + en + total_adicionais;
        ttt = t + total_adicionais;
        total = {total_pedido:ttt, entrega:en, total_final: to}

        document.querySelector('.input-cart-qt-final'+cart[ct].idProduct).value = cart[ct].quantityProduct;
        document.querySelector('#total-pedido-final').innerText = real(t + total_adicionais);
        document.querySelector('#total-entrega-final').innerText = real(total.entrega);
        document.querySelector('#total-final').innerText = real(total.total_final);
        sessionStorage.setItem('total_cart'+company, JSON.stringify(total));
    }
    
    if(localStorage.getItem('delivery'+company) === 'entrega') {
        document.querySelector('#entrega-cart').checked = true;
        document.querySelector('#retirada-cart').checked = false;
        document.querySelector('.card-address-session').style.display = 'flex';
        document.querySelector('.btn-show-address').style.display = 'block';
    } else {
        document.querySelector('#retirada-cart').checked = true;
        document.querySelector('#entrega-cart').checked = false;
    }
}
let cartIndex = 0;
function OpenAdicionais(id, index) {
    sessionStorage.setItem('cart-index', index);
    sessionStorage.setItem('cart-id', id);
     $('#modalcart').modal('hide')
     $('#modalproductadicionais'+id).modal('show')

     let inputs = document.querySelectorAll('.check-options-add-c');

     for (let c = 0; c < cart[index].aditional.length; c++) {
        for (let i = 0; i < inputs.length; i++) {
            if(inputs[i].value.split(',')[0] === cart[index].aditional[c].item) {
                inputs[i].checked = true;
            }
        }
    }


    
    // cartIndex = index;
    // if(cart[index].aditional.length > 0) {
    //     document.querySelector('.name-adi').innerText = cart[index].nameProduct;
    //     let inputs = document.querySelectorAll('.check-options-add-c');

    //     for (let c = 0; c < cart[index].aditional.length; c++) {
    //         for (let i = 0; i < inputs.length; i++) {
    //             if(inputs[i].value.split(',')[0] === cart[index].aditional[c].item) {
    //                 inputs[i].checked = true;
    //             }
    //         }
    //     }
    
    // } else {
    //     Swal.fire({
    //         position: "center",
    //         type: "warning",
    //         title: "Este produto não tem adicionais",
    //         showConfirmButton: true,
    //     });
    // }
}

function closeModalAdicionais(id) {
    window.location.reload()
    $('#modalproductadicionais'+id).modal('hide')
    $('#modalcart').modal('show')
}

function updateAditionais() {
    let inputsOptions = document.querySelectorAll('.check-options');
    let index = sessionStorage.getItem('cart-index');
    let id =  sessionStorage.getItem('cart-id');
    let adicionais = cart[index].aditional;
    let adi = [];

    for (const op in inputsOptions) {
        if (inputsOptions[op].checked === true) {
            let options = inputsOptions[op].value.split(",");
            adi = {item:options[0], preco:options[1]};
            cart[index].aditional = [];
            adicionais.push(adi)
            cart[index].aditional = adicionais
        }
    }

    for (const opf in inputsOptions) {
        if (inputsOptions[opf].checked === true) {
            inputsOptions[opf].checked = false;
            sessionStorage.setItem('temp_cart'+company, JSON.stringify(cart));
            $('#modalproductadicionais'+id).modal('hide')
            cartData();
        }
    }
}

function horarioEnrtega(horario) {
    if(horario === '') {
        Swal.fire({
            position: "center",
            type: "info",
            title: "Preencha o horário de entrega",
            showConfirmButton: true,
        });
        return
    } else {
        sessionStorage.setItem('entrega-horario'+company, horario);
    }
}

function checkout() {
    //updateCart()
    let total_cart = JSON.parse(sessionStorage.getItem('total_cart'+company));
    let paymentobj = JSON.parse(sessionStorage.getItem('pagamento'+company));
    
    // informações de pagamento
    let payment = '';
    if(paymentobj === null) {
        Swal.fire({
            position: "center",
            type: "info",
            title: "Preencha a informação de pagamento",
            showConfirmButton: true,
        });
        return
    } else {
        payment = paymentobj.pagamento;        
    }
    

    let ttip = paymentobj.troco;
    let tip = 0;
    if(ttip !== '') {
         tip = paymentobj.troco;
    }
    
    let delivery = total_cart.entrega;
    let subtotal_order = total_cart.total_pedido;
    let total_order = total_cart.total_final;
    let order_address = '';
    let order_object = sessionStorage.getItem('temp_cart'+company);
    let companie = company;
    let company_object = JSON.stringify(object_company);
    let date_order = new Date();
    let observacao = sessionStorage.getItem('obs-descomplica'+company);
    let time_delivery = sessionStorage.getItem('entrega-horario'+company);
    
    let year = date_order.getFullYear();
    let month = date_order.getMonth() + 1;
    let day = date_order.getDate();

    month = month < 10 ? '0'+month : month;
    day = day < 10 ? '0'+day : day;
    let dia = `${day}/${month}/${year}`;

    let hora = date_order.getHours();
    let min = date_order.getMinutes();
    let sec = date_order.getSeconds();

    hora = hora < 10 ? '0'+hora : hora;
    min = min < 10 ? '0'+min : min;
    sec = sec < 10 ? '0'+sec : sec;

    let hor = `${hora}:${min}:${sec}`;

    let formated_our = `${dia},${hor}`;
    
    client_name = document.querySelector('#client-name').value;
    
    let client_object = {};
    
    if(document.querySelector('#client-name').value === '') {
        Swal.fire({
            position: "center",
            type: "info",
            title: "Preencha seu Nome.",
            showConfirmButton: true,
        });
        return
    } else {
        client_object = localStorage.getItem('client-descomplica'+company);
    }
    

    if(localStorage.getItem('delivery'+company) === 'entrega') {
        order_address = localStorage.getItem('address'+company);
    } else {
        order_address = JSON.stringify({retirada:'Retirada'});
    }
    
    let retcart = document.querySelector('#retirada-cart').checked;
    let entcart = document.querySelector('#entrega-cart').checked;
    
    if(entcart === false && retcart === false) {
        Swal.fire({
            position: "center",
            type: "info",
            title: "Informe o tipo da entrega.",
            showConfirmButton: true,
        });
        return
    } else if(retcart === true && entcart === false){
        // alguma ação
    } else if(entcart === true && retcart === false) {
        // alguma ação
    }
    
    let endereco_verify_entrega = JSON.parse(localStorage.getItem('address'+company));

    if(Object.keys(order_address).length > 23) {
        if(endereco_verify_entrega.rua === '' && endereco_verify_entrega.bairro === '') {
            Swal.fire({
                position: "center",
                type: "info",
                title: "Preencha o endereço da entrega.",
                showConfirmButton: true,
            });
            return
        }
    }

    $.ajax({
        type: "POST",
        url:   'http://localhost/fit/new/order',
        data: {
            companie,
            company_object,
            order_object,
            order_address,
            client_object,
            observacao,
            total_order,
            subtotal_order,
            delivery,
            time_delivery,
            tip,
            payment,
            formated_our,
        },
        dataType: "json",
        beforeSend: function() {

            document.querySelector('.b-check').style.display = 'none';
            document.querySelector('.bl-check').style.display = 'block';
        },
        success: function(res) { 
            if(res.code === 0) {
                //let p1 = `55`;
                // let paux = phone_company.split(' ')[1].split('-')[0]+phone_company.split(' ')[1].split('-')[1];
                // console.log(paux);
                // return;
                // let phone = p1+paux;
                // let phone = phone_company;
                // let ender = JSON.parse(localStorage.getItem('address'+company));
                // let msg = '';
                
                // msg += `📝 Pedido: \n\n`;
                // msg += '✅ Novo Pedido \n';
                // msg += '👤 Cliente: '+client_name+' \n\n';
                
                // for(let c = 0; c < cart.length; c++) {
                //     msg += `Produto: ${cart[c].nameProduct} - ${parseFloat(cart[c].priceProduct).toLocaleString("pt-BR", { style: "currency", currency: "BRL" })} \n`;
                //     msg += `Quantidade: ${cart[c].quantityProduct} \n\n`;
                //     for (let ca = 0; ca < cart[c].aditional.length; ca++) {
                //         msg += `${cart[c].aditional[ca].op}\n`;
                //         msg += `${cart[c].aditional[ca].item} - ${parseFloat(cart[c].aditional[ca].preco).toLocaleString("pt-BR", { style: "currency", currency: "BRL" })}\n\n`;
                //     }
                // }
                
                // if(observacao) {
                //     msg += `Observação: \n`;
                //     msg += observacao +'\n\n';
                // } 
                
                // if(payment === 'Dinheiro') {
                //     msg += '💳 Forma de pagamento: \n';
                //     msg += payment+'\n';
                //     msg += '💳 Troco: '+parseFloat(tip).toLocaleString("pt-BR", { style: "currency", currency: "BRL" })+'\n';
                // } else {
                //     msg += '💳 Forma de pagamento: '+payment+'\n';
                // }
                
                // if(ender.rua) {
                    
                //     msg += '📍 ️Endereço: '+(ender.rua)+' - '+ender.bairro.split(',')[0]+', '+ender.numero+'\n\n';
                //     msg += '📍 Referência: '+(ender.ref === '')?'':ender.ref+'\n\n';
                    
                // } else {
                    
                //     msg += '📍 Retirada no Local \n\n';
                // }
                
                
                
                // msg += '💳 Subtotal: '+subtotal_order.toLocaleString("pt-BR", { style: "currency", currency: "BRL" })+'\n';
                // msg += '💳 Taxa de Entrega: '+delivery.toLocaleString("pt-BR", { style: "currency", currency: "BRL" })+'\n';
                // msg += '💳 Total Pedido: '+total_order.toLocaleString("pt-BR", { style: "currency", currency: "BRL" })+'\n\n';

                // msg += `📝 Acompanhe seu Pedido: \n`;
                let url = `https://raphasfit.com.br/meupedido/${res.pedido}`;

                //msg = window.encodeURIComponent(msg)
                //let url = `https://wa.me/${phone}?text=${msg}`;
                sessionStorage.removeItem('temp_cart'+company);
                window.location.href = url;

            } else {
                Swal.fire({
                    position: "center",
                    type: "error",
                    title: "Oops, Algo deu errado, tente novamente",
                    showConfirmButton: true,
                });

                document.querySelector('.b-check').style.display = 'block';
                document.querySelector('.bl-check').style.display = 'none';
            }
        }
    });


    // cart = [];
    //   localStorage.setItem('auth', true);
    //   sessionStorage.setItem('temp_cart', '[]');
    //   //var btnorder = document.querySelector('.btn-order-end');
    //   window.location.href = 'obrigado.html';
}