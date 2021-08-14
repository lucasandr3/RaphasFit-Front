<?php

require __DIR__ . '/../../../vendor/autoload.php';

use Gerencianet\Exception\GerencianetException;
use Gerencianet\Gerencianet;

$file = file_get_contents(__DIR__ . '/../../config.json');
$options = json_decode($file, true);

$params = [
    'e2eId' => '',
    'id'    => ''
];

$body = [
    'valor' => '0.01'
];

try {
    $api = Gerencianet::getInstance($options);
    $pix = $api->pixDevolution($params, $body);

    echo '<pre>' . json_encode($pix, JSON_PRETTY_PRINT) . '</pre>';
} catch (GerencianetException $e) {
    print_r($e->code);
    print_r($e->error);
    print_r($e->errorDescription);

    throw new Error($e->error);
} catch (Exception $e) {
    throw new Error($e->getMessage());
}
