<?php
namespace Controllers;

use \Core\Controller;
use \Models\Access;
use \Models\Usuarios;
use \Models\Company;

use Ramsey\Uuid\Uuid;

class CompanyController extends Controller
{


    public function __construct()
    {
        // $this->user = new Usuarios();

        // if (!$this->user->verifyLogin()) {
        //     header("Location: ".BASE_URL."login");
        //     exit;
		// }

		// if (!$this->user->hasPermission('access_view')) {
		// $this->loadView('404/500');
        // exit;
        // } 
    }

    public function index()
    {
        $data = array('user' => 'lucas');
        // $data['name'] = $this->user->getName();

        $data['titulo'] = 'Registro - DescomplicaZap';
        // $data['menu'] = 'access';
        
        // $ac = new Access();
        // $data['list'] = $ac->getAll();

        // $col = new Colaboradores();
        // $data['users'] = $col->getAllAccess();

        $this->loadView('new/index', $data);
    }

    public function useraccess($user)
    {
        $ac = new Access();
        $users = $ac->getUserAccess($user);

        echo json_encode($users);
    }

    public function add()
    {
        $data = array('user' => $this->user);
        $data['name'] = $this->user->getName();
   
        $u = new Usuarios();
        $data['dark'] = $u->getMode();

        $this->loadTemplate('clientes/clientes_add', $data);
    }

    public function add_action()
    {
        $uuid = Uuid::uuid4();
        $c = new Company();
        if(isset($_POST['name_company']) && !empty($_POST['name_company'])) {
            
            $name_company = filter_input(INPUT_POST, 'name_company', FILTER_SANITIZE_SPECIAL_CHARS);
            $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
            $zipcode = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_SPECIAL_CHARS);
            $street = filter_input(INPUT_POST, 'street', FILTER_SANITIZE_SPECIAL_CHARS);
            $number = filter_input(INPUT_POST, 'number', FILTER_SANITIZE_SPECIAL_CHARS);
            $neighborhood = filter_input(INPUT_POST, 'neighborhood', FILTER_SANITIZE_SPECIAL_CHARS);
            $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_SPECIAL_CHARS);
            $state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_SPECIAL_CHARS);
            $category_name = filter_input(INPUT_POST, 'category_name', FILTER_SANITIZE_SPECIAL_CHARS);
            $email_user = filter_input(INPUT_POST, 'email_user', FILTER_VALIDATE_EMAIL);
            $senha = filter_input(INPUT_POST, 'senha');
    
            $slug = slugify($name_company);
            $id = $uuid->toString($name_company.$phone);

            $c->saveCompany($name_company, $phone, $zipcode, $street, $number, $neighborhood,
            $city, $state, $category_name, $email_user, $senha, $slug, $id);
            header("Location: " .BASE_URL."/portal");
            exit;
        }
    }

    public function edit($id_cliente)
    {
        $c = new Clientes();
        $data = array('user' => $this->user);
        $data['name'] = $this->user->getName();
        $data['titulo'] = 'Edição de Cliente';
        $data['menu'] = 'cliente';
        $data['cliente'] = $c->getClienteId($id_cliente);
        $this->loadTemplate('clientes/clientes_edit', $data);
    }

    public function edit_action()
    {
        $c = new Clientes();
        if(isset($_POST['nome_cliente']) && !empty($_POST['nome_cliente'])) {

            $nome_cliente = addslashes(trim($_POST['nome_cliente']));
            $doc          = addslashes(trim($_POST['doc']));
            $cep          = addslashes(trim($_POST['cep']));
            $endereco     = addslashes(trim($_POST['endereco']));
            $numero       = addslashes(trim($_POST['numero']));
            $bairro       = addslashes(trim($_POST['bairro']));
            $complemento  = addslashes(trim($_POST['complemento']));
            $cidade       = addslashes(trim($_POST['cidade']));
            $estado       = addslashes(trim($_POST['estado']));
            $email        = addslashes(trim($_POST['email']));
            $tel          = addslashes(trim($_POST['tel']));
            $status       = addslashes(trim($_POST['status']));
            $score        = addslashes(trim($_POST['score']));
            $id_cliente   = addslashes(trim($_POST['id_cliente']));

            $c->editCliente($nome_cliente, $doc, $cep, $endereco, $numero, $bairro,
            $complemento, $cidade, $estado, $email, $tel, $status, $score, $id_cliente);
            header('Location: '.BASE_URL.'clientes');
            exit;
        }
    }

    public function inativos()
    {
        $data = array('user' => $this->user);
        $data['name'] = $this->user->getName();

        $data['titulo'] = 'Clientes Inativos';
        $data['menu'] = 'cliente';
        
    	$c = new Clientes();
        $data['list'] = $c->getAll();

    	$this->loadTemplate('clientes/clientes_inativos', $data);
    }

    public function ver($id_cliente)
    {
        $c = new Clientes();
        $data = array('user' => $this->user);
        $data['name'] = $this->user->getName();
        $data['titulo'] = 'Perfil Cliente';
        $data['menu'] = 'cliente';
        $data['cliente'] = $c->getClienteId($id_cliente);
        $this->loadTemplate('clientes/clientesPerfil', $data);
    }

    public function indisponivel($id_cliente)
    {
        $c = new Clientes();
        $c->toggleStatus($id_cliente);
        header('Location: '.BASE_URL.'clientes');
        exit;
    }
}    