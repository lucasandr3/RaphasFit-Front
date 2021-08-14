const intro = introJs();

intro.setOptions({
    steps: [
        {
            intro: 'Bem Vindo ao DescomplicaZap, vou te mostrar como e fácil fazer um pedido!'
        },
        {
            element: '.step-one',
            intro: 'Aqui você navega pelas categorias',
            disableInteraction: true,
        },
        {
          element: '#step-two',
          intro: 'Aqui você clica no produto',
          position: 'bottom'
        },
        {
          element: '#step-three',
          intro: 'Aqui você escolhes adicionais se o produto tiver e a quantidade',
        },
        {
          element: '#step-four',
          intro: 'Agora você clica em adicionar carrinho',
        },
    ],
    showProgress: true,
    showBullets: false,
});

intro.setOption("nextLabel", " Próximo ");
intro.setOption("prevLabel", " Voltar ");
intro.setOption("doneLabel", " Fim ");

function helpOrder() {
  intro.start();
}

const intro2 = introJs();

intro2.setOptions({
    steps: [
        {
            element: '#step-five',
            intro: 'Aqui você navega pelas categorias',
            disableInteraction: true,
        },
    ],
    showProgress: true,
    showBullets: false,
    showStepNumbers: true
});

intro2.setOption("nextLabel", " Próximo ");
intro2.setOption("prevLabel", " Voltar ");
intro2.setOption("doneLabel", " Fim ");

function helpCart() {
  intro2.start();
}



