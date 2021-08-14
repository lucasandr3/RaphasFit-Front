<?php
$minify = filter_input(INPUT_GET, "minify", FILTER_VALIDATE_BOOLEAN);

if($_SERVER["SERVER_NAME"] == "localhost" || $minify) {

    /* CSS MINIFY*/
    $minCSS = new \MatthiasMullie\Minify\CSS();
    $minCSS->add(dirname(__DIR__, 1)."/assets/css/bootstrap.min.css");
    $minCSS->add(dirname(__DIR__, 1)."/assets/css/cardapio.css");
//    $minCSS->add(dirname(__DIR__, 1)."/assets/css/select2.min.css");

    $minCSS->minify(dirname(__DIR__, 1)."/assets/css/main.css");
    /* FIM CSS MINIFY*/

    /* JS MINIFY*/
    $minJS = new \MatthiasMullie\Minify\JS();
    $minJS->add(dirname(__DIR__, 1)."/assets/js/cardapio/app.js");
    $minJS->add(dirname(__DIR__, 1)."/assets/js/cardapio/jquery.min.js");
    $minJS->add(dirname(__DIR__, 1)."/assets/js/cardapio/bootstrap.bundle.min.js");
    $minJS->add(dirname(__DIR__, 1)."/assets/js/cardapio/sweetalert2.all.js");
    $minJS->add(dirname(__DIR__, 1)."/assets/js/cardapio/functions.js");
    $minJS->add(dirname(__DIR__, 1)."/assets/js/cardapio/tabs.js");
    $minJS->add(dirname(__DIR__, 1)."/assets/js/cardapio/search.js");
    $minJS->add(dirname(__DIR__, 1)."/assets/js/cardapio/cart.js");

    $minJS->minify(dirname(__DIR__, 1)."/assets/js/cardapio/main.js");
    /* FIM JS MINIFY*/
}