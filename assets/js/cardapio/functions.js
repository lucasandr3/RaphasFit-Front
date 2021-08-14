function real(numero) {
    return (numero).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
}

/**
 * Função verifica dia da semana
 */
function verifyDay(id,category) {
    console.log('modal do produto'+id)
    $('#modalproduct'+id).modal('show')
    $('#search-div').html('');
    // var semana = ["Domingo", "Segunda Feira", "Terça Feira", "Quarta Feira", "Quinta Feira", "Sexta Feira", "Sábado"];
    // var d = new Date();

    // let divsc = document.querySelector("#btn-day-cart"+id);
    // let divNot = document.querySelector("#btn-not-day-cart"+id);
    // let horavisible = d.getHours();

    // if(
    //     category === semana[d.getDay()] &&
    //     horavisible < 20
    // ) {
    //     console.log('ifual')
    //     divsc.style.display = "flex";
    //     divNot.style.display = "none";
    // } else {
    //     divsc.style.display = "none";
    //     divNot.style.display = "flex";
    //     console.log('nao e igual')
    // }
}
/**
 *  FIM DA FUNÇÂO
 * */
 
function changeLayout(layout) {
    
    $.ajax({
      type: "POST",
      url: "https://raphasfit.com.br/layout",
      data: {id:company,layout},
      dataType: "json",
      beforeSend: function () {
        
      },
      success: function (res) {
          if(res.code === 0) {
              window.location.reload();
          }
      },
      error: function (res) {

      }
    });
}

function countAdicionais(option, limit) {  
    let op = option.replace(/\s/g, '')
    console.log(op)
    var n = $(".form-check-limit"+op+":checked").length;                       
                        
    if (n == limit)                                              
    {                                                        
       $('.des'+op+':not(:checked)').prop('disabled', true);  
    }                                                        
    else                                                     
    {                                                        
       $('.des'+op+':not(:checked)').prop('disabled', false); 
    }                                                        
}

function count(option, limit) {
    $(".des"+option).click(countAdicionais(option,limit));
}  

// $(document).on('click', '.form-check-limit', function() {

//     var countShared = $('.form-check-limit:checked').length;
//     var limit = document.querySelector('[data-limit]').dataset.limit;
// console.log(limit)    
//         if(countShared > limit) {
//         Swal.fire({
//             position: "center",
//             type: "info",
//             title: `Você escolher somente ${limit} ${limit > 1 ? 'opções':'opção'}`,
//             showConfirmButton: true,
//         });
//         $(this).prop('checked',false);
//     }
            

    
// });