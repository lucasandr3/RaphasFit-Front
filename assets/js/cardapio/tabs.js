let nav = document.getElementsByTagName("nav")[0];

let topNav = nav.offsetTop;

window.onscroll = function () {
    fixMenuTop();
}

function fixMenuTop() {
    if(window.pageYOffset >= topNav) {
        nav.classList.add("nav-p-fix")
        let linka = document.querySelectorAll('#categ-menu-a');
        var i=0;
        for (i=0;i<linka.length;i++) {
            linka[i].style.margin = 14+"px";
        }
    } else {
        nav.classList.remove("nav-p-fix")
    }
}


function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
  }

    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#rua-address").val("");
        $("#bairro").val("");
        $("#cidade-address").val("");
        $("#estado-address").val("");
        //$("#ibge").val("");
    }

    //Quando o campo cep perde o foco.
    $("#cep-address").blur(function() {

        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if (validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#rua-address").val("Carregando...");
                $("#bairro").val("Carregando...");
                $("#cidade-address").val("Carregando...");
                $("#estado-address").val("Carregando...");
                $("#ibge").val("Carregando...");

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#rua-address").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade-address").val(dados.localidade);
                        $("#estado-address").val(dados.uf);
                        $("#ibge").val(dados.ibge);
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        alert("CEP não encontrado.");
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    });
