<?php
namespace Controllers;

use \Core\Controller;
use \Models\Usuarios;
use \Models\Colaboradores;

class ContatoController extends Controller
{
    private $user;

    public function __construct() 
    {
        // $this->user = new Usuarios();

        // if (!$this->user->verifyLogin()) {
        //     header("Location: ".BASE_URL."login");
        //     exit;
		// }

		// if (!$this->user->hasPermission('users_view')) {
		// $this->loadView('404/500');
        // exit;
        // } 
    }

    public function index()
    {
        $data = array();
        // $data['name'] = $this->user->getName();

        $data['titulo'] = 'Descomplica Zap';
        $data['menu'] = 'contato';
        // $data['submenu'] = 'colabver';

        // $c = new Colaboradores();
        // $data['list'] = $c->getAll();

        $this->loadView('contato/index', $data);
    }

    public function registro($id_colab)
    {
        $data = array('user' => $this->user);
        $data['name'] = $this->user->getName();

        $data['titulo'] = 'Registro';
        $data['menu'] = 'colab';
        $data['submenu'] = 'colabreg';

        $c = new Colaboradores();
        $data['colaborador'] = $c->getColabReg($id_colab);

        $this->loadTemplate('colaboradores/registro', $data);
    }

    public function add()
    {
        $data = array('user' => $this->user);
        $data['name'] = $this->user->getName();

        $data['titulo'] = 'Novo Colaborador';
        $data['menu'] = 'colab';
        $data['submenu'] = 'colabver';

        $c = new Colaboradores();
        $data['group'] = $c->getCargos();

        $this->loadTemplate('colaboradores/colaboradores_add', $data);
    }

    public function add_action()
    {
        // echo "<pre>";
        // print_r($_POST);
        // exit;
        $c = new Colaboradores();
        if(isset($_POST['nome_user']) && !empty($_POST['nome_user'])) {
            
            $nome_user  = addslashes(trim($_POST['nome_user']));
            $email_user = addslashes(trim($_POST['email_user']));
            $permissao  = addslashes(trim($_POST['id_permissao']));
            $status     = addslashes(trim($_POST['status']));
            $senha      = addslashes(trim($_POST['senha']));

            $c->registerColaborador($nome_user, $email_user, $permissao, $status, $senha);
            header('Location: '.BASE_URL.'colaboradores');
            exit;
        }
    }

    public function edit($id_user)
    {
        $c = new Colaboradores();
        $data = array('user' => $this->user);
        $data['name'] = $this->user->getName();
        $data['titulo'] = 'Edição  de colaborador';
        $data['menu'] = 'colab';

        // $data['submenu'] = 'colabver';
        $data['userid'] = $c->getUserId($id_user);
        $data['group'] = $c->getCargos();

        $this->loadTemplate('colaboradores/colaboradores_edit', $data);
    }

    public function edit_action()
    {
        // echo "<pre>";
        // print_r($_POST);
        // exit;
        $c = new Colaboradores();
        if(isset($_POST['nome_user']) && !empty($_POST['nome_user'])) {

            $nome_user  = addslashes(trim($_POST['nome_user']));
            $email_user = addslashes(trim($_POST['email_user']));
            $permissao  = addslashes(trim($_POST['id_permissao']));
            $status     = addslashes(trim($_POST['status']));
            $senha      = addslashes(trim($_POST['senha']));
            $id_user    = addslashes(trim($_POST['id_user']));

            $c->editColab($nome_user, $email_user, $permissao, $status, $senha, $id_user);
            header('Location: '.BASE_URL.'colaboradores');
            exit;
        }
    }

    public function inativos()
    {
        $data = array('user' => $this->user);
        $data['name'] = $this->user->getName();

        $data['titulo'] = 'Colaboradores Inativos';
        $data['menu'] = 'colab';
        $data['submenu'] = 'colabver';
        
    	$c = new Colaboradores();
        $data['list'] = $c->getAllInactive();

    	$this->loadTemplate('colaboradores/colaboradores_inativos', $data);
    }

    public function desligar($nome_user)
    {
        $c = new Colaboradores();
        $c->toggleStatusInactive($nome_user);
        header('Location: '.BASE_URL.'colaboradores');
        exit;
    }

    public function religar($nome_user)
    {
        $c = new Colaboradores();
        $c->toggleStatusActive($nome_user);
        header('Location: '.BASE_URL.'colaboradores');
        exit;
    }
}    