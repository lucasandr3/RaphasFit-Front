<?php
namespace Controllers;

use \Core\Controller;
use \Models\Produtos;
use \Models\Usuarios;
use \Models\Espera;

class EsperaController extends Controller
{
	private $user;

    public function __construct()
    {
        $this->user = new Usuarios();

        if (!$this->user->verifyLogin()) {
            header("Location: ".BASE_URL."login");
            exit;
		}

		if (!$this->user->hasPermission('waiting_view')) {
		$this->loadView('404/500');
        exit;
        } 
    }
	
	public function index()
	{
		$data = array('user' => $this->user); 
		$data['name'] = $this->user->getName();

		$data['titulo'] = 'Pátio de espera';
        $data['menu'] = 'espera';
        $data['submenu'] = 'subrec';

        $e = new Espera();
        $data['list'] = $e->getAll();

		$this->loadTemplate('espera/espera', $data);
	}

	public function add()
	{
		$r = new Receitas();
		if (isset($_POST['descricao']) && !empty($_POST['descricao'])) {
			
			$descricao = addslashes(trim($_POST['descricao']));
			$valor 	   = addslashes(trim($_POST['valor']));
			$data_d    = addslashes(trim($_POST['data_d']));
			$conta     = addslashes(trim($_POST['conta']));
			$id_cat    = addslashes(trim($_POST['id_cat']));
			$id_user   = addslashes(trim($_POST['id_user']));

			$r->addReceita($descricao, $valor, $data_d, $conta, $id_cat, $id_user);
			header("Location: ".BASE_URL."receitas");
		}
	}

	public function recorrente()
	{
		$data = array('user' => $this->user); 
		$data['name'] = $this->user->getName();

		$data['titulo'] = 'Receitas Recorrentes';
        $data['menu'] = 'receita';
        $data['submenu'] = 'recparc';

		$r = new Receitas();
		$data['cat_des'] = $r->getCatDes();
        $data['list_reco'] = $r->getAllReco($_SESSION['uLogin']);

		$this->loadTemplate('receitas/rec_recorrente', $data);
	}

	public function addReco()
	{
		$r = new Receitas();
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

			$r->addRecRecorrente($descricao, $valor, $ventrada, $juro, $qtd_parc, $data_parc, $conta, $id_cat, $id_user);
			header("Location: ".BASE_URL."receitas/recorrente");
		}
	}
} 