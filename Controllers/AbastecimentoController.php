<?php
namespace Controllers;

use \Core\Controller;
use \Models\Produtos;
use \Models\Usuarios;
use \Models\Abastecimento;

class AbastecimentoController extends Controller
{
	private $user;

    public function __construct()
    {
        $this->user = new Usuarios();

        if (!$this->user->verifyLogin()) {
            header("Location: ".BASE_URL."login");
            exit;
		}

		if (!$this->user->hasPermission('fuel_view')) {
		$this->loadView('404/500');
        exit;
        } 
    }
	
	public function index()
	{
		$data = array('user' => $this->user); 
		$data['name'] = $this->user->getName();

		$data['titulo'] = 'Abastecimento';
        $data['menu'] = 'diesel';
        $data['submenu'] = 'subdes';

        $ab = new Abastecimento();
        $data['abastecimento'] = $ab->getAbastecimento();
        // $data['list'] = $d->getAll($_SESSION['uLogin']);
        // $data['tdes'] = $d->getTotal($_SESSION['uLogin']);

		$this->loadTemplate('abastecimento/abastecimento', $data);
	}

	public function add()
	{
		$d = new Despesas();
		if (isset($_POST['descricao']) && !empty($_POST['descricao'])) {
			
			$descricao = addslashes(trim($_POST['descricao']));
			$valor 	   = addslashes(trim($_POST['valor']));
			$data_d    = addslashes(trim($_POST['data_d']));
			$conta     = addslashes(trim($_POST['conta']));
			$id_cat    = addslashes(trim($_POST['id_cat']));
			$id_user   = addslashes(trim($_POST['id_user']));

			$d->addDespesa($descricao, $valor, $data_d, $conta, $id_cat, $id_user);
			header("Location: ".BASE_URL."despesas");
		}
	}

	public function recorrente()
	{
		$data = array('user' => $this->user); 
		$data['name'] = $this->user->getName();

		$data['titulo'] = 'Despesas Recorrentes';
        $data['menu'] = 'despesa';
        $data['submenu'] = 'desparc';

        $d = new Despesas();
        $data['cat_des'] = $d->getCat();
        $data['list_reco'] = $d->getAllReco($_SESSION['uLogin']);

		$this->loadTemplate('despesas/des_recorrente', $data);
	}

	public function addReco()
	{
		$d = new Despesas();
		if (isset($_POST['descricao']) && !empty($_POST['descricao'])) {
			
			$descricao = addslashes(trim($_POST['descricao']));
			$valor     = addslashes(trim($_POST['valor']));
			$ventrada  = addslashes(trim($_POST['ventrada']));
			$juro      = addslashes(trim($_POST['juro']));
			$qtd_parc  = addslashes(trim($_POST['qtd_parc']));
			$data_parc = addslashes(trim($_POST['data_parc']));
			$conta     = addslashes(trim($_POST['conta']));
			$id_cat    = addslashes(trim($_POST['id_cat']));
			$id_user   = addslashes(trim($_POST['id_user']));

			$d->addDesRecorrente($descricao, $valor, $ventrada, $juro, $qtd_parc, $data_parc, $conta, $id_cat, $id_user);
			header("Location: ".BASE_URL."despesas/recorrente");
		}
	}
}