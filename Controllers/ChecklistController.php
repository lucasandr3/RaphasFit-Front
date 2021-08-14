<?php
namespace Controllers;

use \Core\Controller;
use \Models\Checklist;
use \Models\Usuarios;

class ChecklistController extends Controller
{
	private $user;

    public function __construct()
    {
        $this->user = new Usuarios();

        if (!$this->user->verifyLogin()) {
            header("Location: ".BASE_URL."login");
            exit;
		}

		if (!$this->user->hasPermission('checklist_view')) {
		$this->loadView('404/500');
        exit;
        } 
    }

    public function index()
    {
    	$data = array('user' => $this->user);
        $data['name'] = $this->user->getName();

        $data['titulo'] = 'Checklist';
        $data['menu'] = 'check';

    	$ch = new Checklist();
        $data['checklist'] = $ch->getAll();

    	$this->loadTemplate('checklist/checklist', $data);
    }

    public function detalhes($id)
    {
        $data = array('user' => $this->user);
        $data['name'] = $this->user->getName();

        $data['titulo'] = 'Checklist';
        $data['menu'] = 'check';

    	$ch = new Checklist();
        $data['checklist'] = $ch->getCheckId($id);

        $this->loadTemplate('checklist/detalhes', $data);
    }

    public function imprimir($id)
    {
        $data = array();
        $ch = new Checklist();
        $data['checklist'] = $ch->getCheckId($id);

        ob_start();
        $this->loadView('checklist/imprimir', $data);
        $html = ob_get_contents();
        ob_end_clean();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }

    public function pdf($id)
    {
        $data = array();
        $ch = new Checklist();
        $data['checklist'] = $ch->getCheckId($id);

        ob_start();
        $this->loadView('checklist/imprimir', $data);
        $html = ob_get_contents();
        ob_end_clean();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        $mpdf->Output('checklist.pdf', 'D');
    }

    public function manutencao()
    {
    	$data = array('user' => $this->user);
        $data['name'] = $this->user->getName();

        $data['titulo'] = 'Manutenção';
        $data['menu'] = 'man';

    	$ch = new Checklist();
        $data['manutencao'] = $ch->getAllMan();

    	$this->loadTemplate('checklist/manutencao', $data);
    }

    public function manu_detalhes($id)
    {
        $data = array('user' => $this->user);
        $data['name'] = $this->user->getName();

        $data['titulo'] = 'Manutenção';
        $data['menu'] = 'man';

    	$ch = new Checklist();
        $data['manutencao'] = $ch->getManuId($id);

        $this->loadTemplate('checklist/manu_detalhes', $data);
    }

    public function add()
    {
        $p = new Produtos();
        $data = array('user' => $this->user);
        $data['name'] = $this->user->getName();
        $data['titulo'] = 'Novo Produto';
        $data['menu'] = 'produto';
        $data['cat']  = $p->getCategorias();
        $u = new Usuarios();
        $data['dark'] = $u->getMode();
        $this->loadTemplate('produtos/produto_add', $data);
    }

    public function add_action()
    {
        $p = new Produtos();
        if(isset($_POST['name']) && !empty($_POST['name'])) {
            
            $codigo      = addslashes(trim($_POST['codigo']));
            $cod_final   = addslashes(trim($_POST['cod_final']));	
            $initials    = addslashes(trim($_POST['initials']));
            $name        = addslashes(trim($_POST['name']));
            $category    = addslashes(trim($_POST['category']));
            $price       = addslashes(trim($_POST['price']));
            $description = addslashes(trim($_POST['description']));

            if (isset($_FILES['arquivo']) && !empty($_FILES['arquivo']['tmp_name'])) {

                $permitidos = array('image/jpeg', 'image/jpg', 'image/png');

                if (in_array($_FILES['arquivo']['type'], $permitidos)) {

                    $cat_nome = $_POST['category'];
                    
                    $nome = 'images/'.$cat_nome.'/'.md5(time().rand(0,999)).'.jpg';
                    move_uploaded_file($_FILES['arquivo']['tmp_name'], 'app/'.$nome);

                    //$url = 'http://localhost/catalogo/images/'.$cat_nome['id_cat'].'/'.$nome;
                    
                    $p->saveProduct($codigo, $cod_final, $initials, $name, $category, $price, $description, $nome);
                    header('Location: '.BASE_URL.'produto');
                    exit;
                }
            }
        }
    }

    public function edit($id_prod)
    {
        $p = new Produtos();
        $data = array('user' => $this->user);
        $data['name'] = $this->user->getName();
        $data['titulo'] = 'Edição de Produto';
        $data['menu'] = 'produto';
        $data['prod'] = $p->getProdId($id_prod);
        $data['cat']  = $p->getCategorias();

        $this->loadTemplate('produtos/produto_edit', $data);
    }

    public function edit_action()
    {
        $p = new Produtos();
        if(isset($_POST['name']) && !empty($_POST['name'])) {
            
            $codigo      = addslashes(trim($_POST['codigo']));
            $cod_final   = addslashes(trim($_POST['cod_final']));	
            $initials    = addslashes(trim($_POST['initials']));
            $name        = addslashes(trim($_POST['name']));
            $category    = addslashes(trim($_POST['category']));
            $price       = addslashes(trim($_POST['price']));
            $description = addslashes(trim($_POST['description']));
            $id_prod     = addslashes(trim($_POST['id_prod']));

            if (isset($_FILES['arquivo']) && !empty($_FILES['arquivo']['tmp_name'])) {
  
                $permitidos = array('image/jpeg', 'image/jpg', 'image/png');

                if (in_array($_FILES['arquivo']['type'], $permitidos)) {

                    $cat_nome = $_POST['category'];
                    
                    $nome = 'images/'.$cat_nome.'/'.md5(time().rand(0,999)).'.jpg';
                    move_uploaded_file($_FILES['arquivo']['tmp_name'], 'app/'.$nome);

                    //$url = 'http://localhost/catalogo/images/'.$cat_nome['id_cat'].'/'.$nome;
                }
            }

            $p->editProduct($codigo, $cod_final, $initials, $name, $category, $price, $description, $nome, $id_prod);
            header('Location: '.BASE_URL.'produto');
            exit;
        }
    }

    public function indisponivel($id_prod)
    {
        $p = new Produtos();
        $p->toggleStatus($id_prod);
        header('Location: '.BASE_URL.'produto');
        exit;
    }

    public function inativos()
    {
        $data = array('user' => $this->user);
        $data['name'] = $this->user->getName();

        $data['titulo'] = 'Produtos Inativos';
        $data['menu'] = 'produto';

    	$p = new Produtos();
        $data['list_status'] = $p->getAllProductsInativo();

    	$this->loadTemplate('produtos/produtos_inativos', $data);
    }

    public function mantencaodata()
	{
		$ch = new Checklist();

		if ($manutencao = $ch->getAllManutencao()) {
			$resposta['code'] = 0;
			$resposta['manutencao'] = $manutencao;
			echo json_encode($resposta);
			exit;
		} else {
			$resposta['code'] = 1;
			$resposta['manutencao'] = 'Não existe Manutenção para este dia.';
			echo json_encode($resposta);
			exit;
		}	
	}
}