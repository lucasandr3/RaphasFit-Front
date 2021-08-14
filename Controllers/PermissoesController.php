<?php
namespace Controllers;

use \Core\Controller;
use \Models\Usuarios;
use \Models\Permissoes;

class PermissoesController extends Controller
{
	private $user;

    public function __construct()
    {
        $this->user = new Usuarios();

        if (!$this->user->verifyLogin()) {
            header("Location: ".BASE_URL."login");
            exit;
        }

        if (!$this->user->hasPermission('permissions_view')) {
            $this->loadView('error/500');
            exit;
        }    
    }
	
	public function index()
	{   
        $data = array('user' => $this->user);
        $data['name'] = $this->user->getName();
        $data['titulo'] = 'Permissões';
        $data['menu'] = 'permissao';
        $p = new Permissoes();
        $data['list'] = $p->getAllGroups();
       

        $this->loadTemplate('permissoes/permission', $data);
	}

    public function del($id_group)
    {
        $p = new Permissoes();

        $p->deleteGroup($id_group);

        header("Location: ".BASE_URL."permissoes");
        exit;
    }

    public function add()
    {
        $data = array('user' => $this->user);
        
        $p = new Permissoes();
        $data['permission_itens'] = $p->getAllItems();
        $data['name'] = $this->user->getName();
        $data['titulo'] = 'Nova Permissão';
        $data['menu'] = 'permissao';

        $this->loadTemplate('permissoes/permission_add', $data);
    }

    public function add_action()
    {
        $p = new Permissoes();

        if (!empty($_POST['nome_group']) && !empty($_POST['nome_group'])) {

            $nome_group = addslashes(trim($_POST['nome_group']));

            $id = $p->addGroup($nome_group);

            if (isset($_POST['items']) && count($_POST['items']) > 0) {
                $items = $_POST['items'];
                foreach ($items as $item) {
                    $p->linkItemToGroup($item, $id);
                }
            }
            
            header("Location: ".BASE_URL."permissoes");
            exit;

        } else {
            $_SESSION['formError'] = array('nome_group');
            header("Location: ".BASE_URL."permissoes/add");
            exit;
        }
    }

    public function edit($id_group)
    {
        if (!empty($id_group)) {
            
            $data = array('user' => $this->user);
            
            $p = new Permissoes();
            $data['permission_itens'] = $p->getAllItems();
            $data['permission_group_name'] = $p->getPermissionGroupName($id_group);
            $data['permission_group_slugs'] = $p->getPermissoes($id_group);
            $data['permission_id'] = $id_group;
            $data['name'] = $this->user->getName();
            $data['titulo'] = 'Edição de permissão';
            $data['menu'] = 'permissao';

            $this->loadTemplate('permissoes/permission_edit', $data);

        } else {
            header("Location: ".BASE_URL."permissoes");
            exit;
        }
    }

    public function edit_action($id_group)
    {
        $p = new Permissoes();
        if (!empty($id_group)) {

            if (!empty($_POST['nome_group']) && !empty($_POST['nome_group'])) {

                $nome_group = addslashes(trim($_POST['nome_group']));

                $p->editName($nome_group, $id_group);

                $p->clearLinks($id_group);

                if (isset($_POST['items']) && count($_POST['items']) > 0) {
                    $items = $_POST['items'];
                    foreach ($items as $item) {
                        $p->linkItemToGroup($item, $id_group);
                    }
                }

                header("Location: ".BASE_URL."permissoes");
                exit;

            } else {
                header("Location: ".BASE_URL."permissoes/edit/".$id_group);
                exit;
               } 
            } else {
                header("Location: ".BASE_URL."permissoes");
                exit;
            }
        }

        public function items()
        {
            $data = array('user' => $this->user);

            $p = new Permissoes();
            $data['list'] = $p->getAllItems();
            $data['name'] = $this->user->getName();
            $data['titulo'] = 'Item de permissões';
            $data['menu'] = 'permissao';

            $this->loadTemplate('permissoes/permission_items', $data);
        }

        public function items_add()
        {
            $p = new Permissoes();
            if (!empty($_POST['nome']) && !empty($_POST['nome'])) {
                
                $nome = addslashes(trim($_POST['nome']));
                $slug = addslashes(trim($_POST['slug']));

                $p->addPermissao($nome, $slug);
                header("Location: ".BASE_URL."permissoes/items");
                exit;
            }
        }

        public function items_edit($id_p_item)
        {
            $p = new Permissoes();
            if (!empty($_POST['nome']) && !empty($_POST['nome'])) {
                
                $nome = addslashes(trim($_POST['nome']));

                $p->editPermissao($id_p_item, $nome);
                header("Location: ".BASE_URL."permissoes/items");
                exit;
            }
        }
}