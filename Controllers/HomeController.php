<?php
namespace Controllers;

use \Core\Controller;
use \Models\Usuarios;
use \Models\Cardapio;

class HomeController extends Controller {

	public function index()
    {
        $cardapio = new Cardapio();

        if($cardapio = $cardapio->isExists(slug('raphas-fit'))) {
            
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
        dde('aqui');
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
            $tip = $_POST['tip'];
            $payment = $_POST['payment'];
            $date_order = $_POST['formated_our'];

            if ($c->newPedido($companie, $namecompany, $order_object, $order_address, $client_order, $observacao, $total_order, $subtotal_order, $delivery, $tip, $payment, $date_order)) {

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
    
    public function shedule_menu()
	{
		$c = new Cardapio();
		$menu = $c->getMenuShedule('adf122c2-24bb-46b4-bd4d-3e5613177d2a','1,2,3');
		$cardapio1 = [];
		$cardapio2 = [];
		$cardapio3 = [];

		//monta cardapio 1
		$produtosFiltrados1 = array_filter($menu, function($menu) {
			return $menu['tag_shedule'] === '1';
		});

		foreach ($produtosFiltrados1 as $value) {
			$cardapio1[] = $value;
		}
		
		//monta cardapio 2
		$produtosFiltrados2 = array_filter($menu, function($menu) {
			return $menu['tag_shedule'] === '2';
		});

		foreach ($produtosFiltrados2 as $value) {
			$cardapio2[] = $value;
		}

		//monta cardapio 3
		$produtosFiltrados3 = array_filter($menu, function($menu) {
			return $menu['tag_shedule'] === '3';
		});

		foreach ($produtosFiltrados3 as $value) {
			$cardapio3[] = $value;
		}


		if($cardapio1[0]['status'] === 'PACTIVE') {	
			if($c->changeProductsShedule('adf122c2-24bb-46b4-bd4d-3e5613177d2a', $cardapio1, $cardapio2)) {
				
				$response['code'] = 200;
				$response['status'] = '
					<div>
						<p>1º Cardápio Desativado</p>
						<p>2º Cardápio Ativado</p>
					</div>
				'; 
			} else {
				$response['code'] = 200;
				$response['status'] = 'Houve Erro na troca de cardápio';
			}
		} else if($cardapio2[0]['status'] === 'PACTIVE') {
			if($c->changeProductsShedule('adf122c2-24bb-46b4-bd4d-3e5613177d2a', $cardapio2, $cardapio3)) {
				$response['code'] = 200;
				$response['status'] = '
					<div>
						<p>2º Cardápio Desativado</p>
						<p>3º Cardápio Ativado</p>
					</div>
				'; 
				echo json_encode($response);
				exit;
			} else {
				$response['code'] = 200;
				$response['status'] = 'Houve Erro na troca de cardápio';
				echo json_encode($response);
				exit;
			}
		} else if($cardapio3[0]['status'] === 'PACTIVE') {
			if($c->changeProductsShedule('adf122c2-24bb-46b4-bd4d-3e5613177d2a', $cardapio3, $cardapio1)) {
				$response['code'] = 200;
				$response['status'] = '
					<div>
						<p>3º Cardápio Desativado</p>
						<p>1º Cardápio Ativado</p>
					</div>
				'; 
				echo json_encode($response);
				exit;
			} else {
				$response['code'] = 200;
				$response['status'] = 'Houve Erro na troca de cardápio';
				echo json_encode($response);
				exit;
			}
		}

	}
	
    public function finalizar_pedido($id_pedido)
    {
        $c = new Cardapio();
        
        if($c->finalizaPedido($id_pedido)) {
            header("Location: ".BASE_URL);
            exit;
        } 
    }
}