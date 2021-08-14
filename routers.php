<?php
global $routes;
$routes = array();

/*
*   Rotas do APP 
*/

// rota site
$routes['/'] = '/home';
$routes['/pedido/entregue/{id}'] = '/home/finalizar_pedido/:id';

$routes['/contato'] = '/contato';

$routes['/register/stepone'] = '/company';
$routes['/record'] = '/company/add_action';
$routes['/record/payment'] = '/payment';

// rota cardapio
$routes['/store/status/{company}'] = '/cardapio/storeOpen';
$routes['/search'] = '/cardapio/search';
$routes['/layout'] = '/cardapio/change_layout';
$routes['/new/order'] = '/cardapio/newOrder';
$routes['/meupedido/{id}'] = '/cardapio/my_order/:id';
$routes['/{slug}/cart'] = '/cardapio/cart/:slug';
$routes['/{slug}'] = '/cardapio/index/:slug';
/*
*  Fim das rotas do app
*/


