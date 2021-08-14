<?php
namespace Controllers;

use \Core\Controller;
use \Models\Produtos;
use \Models\Usuarios;
use \Models\Motoristas;
use \Models\Access;

class MotoristasController extends Controller
{
	private $user;

    public function __construct()
    {
        $this->user = new Usuarios();

        if (!$this->user->verifyLogin()) {
            header("Location: ".BASE_URL."login");
            exit;
		}

		if (!$this->user->hasPermission('drivers_view')) {
		$this->loadView('404/500');
        exit;
        } 
    }

    public function index()
    {
    	$data = array('user' => $this->user);
        $data['name'] = $this->user->getName();
        
        $data['titulo'] = 'Motoristas';
		$data['menu'] = 'driver';
    	$m = new Motoristas();
        $data['drivers'] = $m->getAll();
       // $data['peds_prods'] = $p->getAllPedidosProds();


    	$this->loadTemplate('motoristas/motoristas', $data);
    }

    public function add()
    {
        $m = new Motoristas();
        $data = array('user' => $this->user);
        $data['name'] = $this->user->getName();
        $data['cat']  = $p->getCategorias();
        $u = new Usuarios();
        $data['dark'] = $u->getMode();
        $this->loadTemplate('produtos/produto_add', $data);
    }

    public function add_action()
    {
        $m = new Motoristas();
        if(isset($_POST['code_driver']) && !empty($_POST['code_driver'])) {
            
            $code        = addslashes(trim($_POST['code_driver']));
            $name    = addslashes(trim($_POST['name_driver']));
            $password       = addslashes(trim($_POST['password']));
            $function = addslashes(trim($_POST['function']));
            $status = addslashes(trim($_POST['status']));

            if (isset($_POST['id_user']) && !empty($_POST['id_user'])) {
                $user   = addslashes(trim($_POST['id_user']));
                $action = 'Cadastrou motorista '.$name;
                $access = new Access();
                $access->saveActionDriver($user, $action);
            }

            $m->saveDriver($code, $name, $password, $function, $status);
            header('Location: '.BASE_URL.'motoristas');
            exit;
        }
    }

    public function edit($id)
    {
        $m = new Motoristas();
        $data = array('user' => $this->user);
        $data['name'] = $this->user->getName();
        $data['driver'] = $m->getDriverId($id);

        $this->loadTemplate('motoristas/motorista_edit', $data);
    }

    public function edit_action()
    {
        $m = new Motoristas();
        if(isset($_POST['code_driver']) && !empty($_POST['code_driver'])) {
            
            $code     = addslashes(trim($_POST['code_driver']));
            $name     = addslashes(trim($_POST['name_driver']));
            $function = addslashes(trim($_POST['function']));
            $password = addslashes(trim($_POST['password']));
            $status   = addslashes(trim($_POST['status']));
            $id       = addslashes(trim($_POST['id']));

            if (isset($_POST['id_user']) && !empty($_POST['id_user'])) {
                $user   = addslashes(trim($_POST['id_user']));
                $action = 'Editou motorista '.$name;
                $access = new Access();
                $access->editActionDriver($user, $action);
            }

            $m->editDriver($code, $name, $function, $password, $status, $id);
            header('Location: '.BASE_URL.'motoristas');
            exit;
        }
    }

    public function desligar($name)
    {        
        $user = $this->user->getName();
        $id_user = $user['id_user'];
        $action = 'Desligou o motorista '.$name;
        $access = new Access();
        $access->saveActionDriverInactive($id_user, $action);
        

        $m = new Motoristas();
        $m->toggleStatus($name);
        header('Location: '.BASE_URL.'motoristas');
        exit;
    }

    public function religar($name)
    {
        $user = $this->user->getName();
        $id_user = $user['id_user'];
        $action = 'Religou o motorista '.$name;
        $access = new Access();
        $access->saveActionDriverActive($id_user, $action);
        

        $m = new Motoristas();
        $m->toggleStatusActive($name);
        header('Location: '.BASE_URL.'motoristas');
        exit;
    }

    public function inativos()
    {
        $data = array('user' => $this->user);
    	$data['name'] = $this->user->getName();
    	$m = new Motoristas();
        $data['drivers'] = $m->getAllDriversInativos();
        // $u = new Usuarios();
        // $data['dark'] = $u->getMode();
    	$this->loadTemplate('motoristas/motoristas_inativos', $data);
    }

    public function all_pedidos()
    {
        $p = new Pedidos();
        $data = $p->getAllPedidos();
        echo json_encode($data);
    }

    public function new_order()
    {
        if(isset($_POST['dados']) && !empty($_POST['dados'])) {
            $lista   = $_POST['dados'];
            $vendor  = $_POST['vendor'];
            $cliente = $_POST['cliente'];
            $nota    = $_POST['nota'];
            $pag     = $_POST['pag'];
            $total   = $_POST['total'];
        }
        $p = new Pedidos();
        $p->novoPedido($lista, $vendor, $cliente, $nota, $pag, $total);
		$resposta['code'] = 0;
		echo json_encode($resposta);
        exit;
    }

    public function prods_pedido()
    {
        if (isset($_POST['id_prod']) && !empty($_POST['id_prod'])) {
            
            $id_produto = array($_POST['id_prod']);
        }
        $p = new Pedidos();
        $data = $p->getNameId($id_produto);
        echo json_encode($data);
    }

    public function lista($id_pedido)
    {
        $data = array('user' => $this->user);
        $data['name'] = $this->user->getName();
        $data['titulo'] = 'Lista de Produtos';
        $p = new Pedidos();
        $data['peds_prods'] = $p->getAllPedidosProds($id_pedido);
        $u = new Usuarios();
        $data['dark'] = $u->getMode();

        $this->loadTemplate('pedidos/lista_prods', $data);
    }

    public function editorder($id_pedido)
    {
        $data = array('user' => $this->user);
        $data['name'] = $this->user->getName();
        $data['titulo'] = 'Editar Pedido';
        $data['id_order'] = $id_pedido;
        $p = new Pedidos();
        $data['peds_prods'] = $p->getAllPedidosProds($id_pedido);
        $u = new Usuarios();
        $data['dark'] = $u->getMode();

        $this->loadTemplate('pedidos/edit_order', $data);
    }

    public function orderjson($id_pedido)
    {
        $p = new Pedidos();
        $order = $p->getAllPedidosProds($id_pedido);
        echo json_encode($order);
        exit;
        
    }

    public function imprimir($id_pedido)
    {
        $data = array();
        $p = new Pedidos();
        $data['peds_prods'] = $p->getAllPedidosProds($id_pedido);

        ob_start();
        $this->loadView('pedidos/pdf', $data);
        $html = ob_get_contents();
        ob_end_clean();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    // public function imprimir($id_pedido)
    // {
    //     $data = array();

    //     if (!$this->user->verifyLogin()) {
    //         header("Location: ".BASE_URL."login");
    //         exit;
    //     }

    // 	$data = array('user' => $this->user);
    //     $data['name'] = $this->user->getName();
        
    //     $data['titulo'] = 'Pedidos';
    //     $data['menu'] = 'pedido';
        
    //     $p = new Pedidos();
    //     $data['peds_prods'] = $p->getAllPedidosProds($id_pedido);

    //     $this->loadTemplate('pedidos/pdf', $data);
   
    // }
}