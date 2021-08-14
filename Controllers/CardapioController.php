<?php
namespace Controllers;

use \Core\Controller;
use \Models\Cardapio;
use \Models\Usuarios;

class CardapioController extends Controller
{
    public function index($slug)
    {

        $cardapio = new Cardapio();

        if($cardapio = $cardapio->isExists(slug($slug))) {
            
            if(getStore()->category_company === "food") {

                $c = new Cardapio();

                $data = array();
                $data['categories'] = $c->getCategories(getStore()->information['id_company']);
                $data['p_options'] = $c->getProductOptions(getStore()->information['id_company']);
                $data['menu'] = $c->getMenu(getStore()->information['id_company']);
                $data['config'] = $c->getConfig(getStore()->information['id_company']);
                $data['bairros'] = $c->getBairros(getStore()->information['id_company']);
                $data['ultimo_pedido'] = $c->getUltimoPedido();

                $this->loadView('cardapio/food', $data);

            } else if(getStore()->category_company === "roupas") {

                $c = new Cardapio();

                $data = array();
                $data['categories'] = $c->getCategories(getStore()->information['id_company']);
                $data['p_options'] = $c->getProductOptions(getStore()->information['id_company']);
                $data['menu'] = $c->getMenu(getStore()->information['id_company']);
                $data['config'] = $c->getConfig(getStore()->information['id_company']);
                $data['bairros'] = $c->getBairros(getStore()->information['id_company']);

                $this->loadView('cardapio/roupas', $data);

            } else if(getStore()->category_company === "grocery") {

                $c = new Cardapio();

                $data = array();
                $data['categories'] = $c->getCategories(getStore()->information['id_company']);
                $data['p_options'] = $c->getProductOptions(getStore()->information['id_company']);
                $data['menu'] = $c->getMenu(getStore()->information['id_company']);
                $data['config'] = $c->getConfig(getStore()->information['id_company']);
                $data['bairros'] = $c->getBairros(getStore()->information['id_company']);

                $this->loadView('cardapio/grocery', $data);
                
            } else if(getStore()->category_company === "modelo") {

                $c = new Cardapio();

                $data = array();
                $data['categories'] = $c->getCategories(getStore()->information['id_company']);
                $data['p_options'] = $c->getProductOptions(getStore()->information['id_company']);
                $data['menu'] = $c->getMenu(getStore()->information['id_company']);
               
                $data['config'] = $c->getConfig(getStore()->information['id_company']);
                $data['bairros'] = $c->getBairros(getStore()->information['id_company']);

                $this->loadView('cardapio/modelo', $data);
            }

        } else {

            $data = array();

		    $data['titulo'] = 'Descomplica Zap';
		    $data['menu'] = 'home';


            $this->loadTemplate('home/home', $data);
        }
    }

    public function search()
    { 

        // if(isset($_POST['slug'])) {
        //     $s = filter_input(INPUT_POST, 'slug', FILTER_SANITIZE_SPECIAL_CHARS);
        //     $cardapio = new Cardapio();
        //     if($cardapio = $cardapio->isExists(slug($s))) {

                $c = new Cardapio();
            
                $company = filter_input(INPUT_POST, 'company');
                $v = filter_input(INPUT_POST, 'value', FILTER_SANITIZE_SPECIAL_CHARS);
    
                $c = new Cardapio();
                $data['search'] = $c->SearchProducts($company,$v);
                // echo "<pre>";
                // print_r($data['search']);
                // exit;
                echo json_encode($data);
    
    
    
        //     } else {
        //         echo "nao existe";
        //     }

        // }            
    }

//    public function cart($slug)
//    {
//        $data = array();
//
//
//        $this->loadView('cardapio/cart', $data);
//    }
//
    public function newOrder()
    {
        $c = new Cardapio();
        if (isset($_POST['companie']) && !empty($_POST['companie'])) {

            $companie = $_POST['companie'];
            $namecompany = $_POST['company_object'];
            $order_object = $_POST['order_object'];
            $order_address = $_POST['order_address'];
            $client_order = $_POST['client_object'];
            $observacao = $_POST['observacao'];
            $total_order = $_POST['total_order'];
            $subtotal_order = $_POST['subtotal_order'];
            $delivery = $_POST['delivery'];
            $time_delivery = $_POST['time_delivery'];
            $tip = $_POST['tip'];
            $payment = $_POST['payment'];
            $date_order = $_POST['formated_our'];

            if ($c->newPedido($companie, $namecompany, $order_object, $order_address, $client_order, $observacao, $total_order, $subtotal_order,$time_delivery, $delivery, $tip, $payment, $date_order)) {

                // notifyOrder($_SESSION['order_notify']);
                notifyOrder();
                $resposta['code'] = 0;
                $resposta['pedido'] = $_SESSION['pedido_client_new'];
                $resposta['msg'] = 'Pedido recebido com sucesso.';
                echo json_encode($resposta);

            } else {

                $resposta['code'] = 1;
                $resposta['msg'] = 'OOps.. erro ao enviar pedido.';
                echo json_encode($resposta);
            }

        }
    }

    public function storeOpen()
    {
        print_r($_POST);
        exit;
    }
    
    public function change_layout()
    {
        $c = new Cardapio();
        
        $company = $_POST['id'];
        $layout = $_POST['layout'];
        
        if($c->changeLayout($company, $layout)) {
            $resposta['code'] = 0;
            $resposta['msg'] = 'Layout alterado com sucesso.';
            echo json_encode($resposta);
        } else {
            $resposta['code'] = 1;
            $resposta['msg'] = 'Erro ao alterar layout.';
            echo json_encode($resposta);
        }
    }
    
    public function my_order($id)
    {
        $cardapio = new Cardapio();

        if($order = $cardapio->getOrder($id)) {
            
            $data = array();

            $data['title'] = '#'.$order->id;
                
            $data['order'] = $order;

            $this->loadView('cardapio/track', $data);

        } else {
            dd('nao existe');
        }
    }
}