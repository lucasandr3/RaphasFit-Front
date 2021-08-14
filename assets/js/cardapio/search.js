let sResult = document.querySelector("#search-div");
let sHide = document.querySelector("#search-hide");
let html = "";

function seachProducts(value, company) {
    $('#search-div').html('');
  if (value.length < 1) {
    sHide.style.display = "block";
  }  else if(value.length === 1){
      $('#search-div').html('');
      //sHide.style.display = "none"; 
  } else {
      $('#search-div').html('');
    //sHide.style.display = "none";

    $.ajax({
      type: "POST",
      url: "https://raphasfit.com.br/home/search",
      data: {company:company,value:value},
      dataType: "json",
      beforeSend: function () {
        
      },
      success: function (res) {
          console.log(res)
        html = "";
        $('#search-div').html('');
        for (const s in res.search) {
          html += `
          <div class="card-c shadow" onclick="verifyDay(${res.search[s].id}, ${res.search[s].category})" data-bs-toggle="modal" data-bs-target="#modalproduct4">
              <div class="row-c">
                  <div class="img-c">
                      ${
                        (!res.search[s].image === null) ? '<img src="${res.search[s].image}" class="img-card" alt="${res.search[s].name_product}"></img>':''
                      }
                  </div>
                  <div class="info-c">
                      <h5 class="card-title" style="font-weight:bold;color:#555;">${res.search[s].name_product}</h5>
                      <p class="card-text text-truncate"
                          style="color: #777;font-size: 0.9rem;width: 220px;">
                          ${res.search[s].description}</p>
                      <p class="card-text"><span
                              style="color: #d25850;font-weight: bold;letter-spacing: 1px;">${res.search[s].price}</span>
                      </p>
                  </div>
              </div>
          </div>
          `;
        }
        
        $('#search-div').html(html);
      },
      error: function (res) {

      }
    });
  }
}
