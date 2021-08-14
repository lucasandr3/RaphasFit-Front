<?php
namespace Controllers;

use \Core\Controller;
use \Models\Usuarios;
use \Models\Frota;
use \Models\Access;

class FrotaController extends Controller
{

    private $user;

    public function __construct()
    {
        $this->user = new Usuarios();

        if (!$this->user->verifyLogin()) {
            header("Location: ".BASE_URL."login");
            exit;
		}

		if (!$this->user->hasPermission('fleets_view')) {
		$this->loadView('404/500');
        exit;
        } 
    }

    public function index()
    {
    	$data = array('user' => $this->user);
        $data['name'] = $this->user->getName();
        
        $data['titulo'] = 'Frota';
		$data['menu'] = 'frota';
    	$f = new Frota();
        $data['fleet'] = $f->getAll();

    	$this->loadTemplate('frota/frota', $data);
    }

    public function add_action()
    {
        $f = new Frota();
        if(isset($_POST['fleet']) && !empty($_POST['fleet'])) {
            
            $fleet       = addslashes(trim($_POST['fleet']));
            $placa       = addslashes(trim($_POST['plaque']));
            $modelo      = addslashes(trim($_POST['model']));
            $equipamento = addslashes(trim($_POST['equipment']));
            $marca       = addslashes(trim($_POST['mark']));
            $status      = addslashes(trim($_POST['status']));

            if (isset($_POST['id_user']) && !empty($_POST['id_user'])) {
                $user   = addslashes(trim($_POST['id_user']));
                $action = 'Cadastrou frota '.$fleet;
                $access = new Access();
                $access->saveActionFleet($user, $action);
            }

            $f->saveFleet($fleet, $placa, $modelo, $equipamento, $marca, $status);
            header('Location: '.BASE_URL.'frota');
            exit;
        }
    }

    public function edit($id)
    {
        $data['titulo'] = 'Editar frota';

        $f = new Frota();
        $data = array('user' => $this->user);
        $data['name'] = $this->user->getName();
        $data['fleet'] = $f->getFleetId($id);

        $this->loadTemplate('frota/frota_edit', $data);
    }

    public function edit_action()
    {
        $f = new Frota();
        if(isset($_POST['fleet']) && !empty($_POST['fleet'])) {
            
            $fleet     = addslashes(trim($_POST['fleet']));
            $plaque    = addslashes(trim($_POST['plaque']));
            $model     = addslashes(trim($_POST['model']));
            $equipment = addslashes(trim($_POST['equipment']));
            $mark      = addslashes(trim($_POST['mark']));
            $status    = addslashes(trim($_POST['status']));
            $id        = addslashes(trim($_POST['id']));

            if (isset($_POST['id_user']) && !empty($_POST['id_user'])) {
                $user   = addslashes(trim($_POST['id_user']));
                $action = 'Editou frota '.$fleet;
                $access = new Access();
                $access->editActionFleet($user, $action);
            }

            $f->editFleet($fleet, $plaque, $model, $equipment, $mark, $status, $id);
            header('Location: '.BASE_URL.'frota');
            exit;
        }
    }

    public function inativar($fleet)
    {
        $user = $this->user->getName();
        $id_user = $user['id_user'];
        $action = 'Inativou a frota '.$fleet;
        $access = new Access();
        $access->saveActionFleetInactive($id_user, $action);
        

        $f = new Frota();
        $f->toggleStatus($fleet);
        header('Location: '.BASE_URL.'frota');
        exit;
    }

    public function ativar($fleet)
    { 
        $user = $this->user->getName();
        $id_user = $user['id_user'];
        $action = 'Ativou a frota '.$fleet;
        $access = new Access();
        $access->saveActionFleetActive($id_user, $action);
        

        $f = new Frota();
        $f->toggleStatusActive($fleet);
        header('Location: '.BASE_URL.'frota');
        exit;
    }

    public function inativas()
    {
        $data = array('user' => $this->user);
    	$data['name'] = $this->user->getName();
    	$f = new Frota();
        $data['fleet'] = $f->getAllFleetInativas();
        // $u = new Usuarios();
        // $data['dark'] = $u->getMode();
    	$this->loadTemplate('frota/frota_inativa', $data);
    }

    public function conjuntos()
    {
    	$data = array('user' => $this->user);
        $data['name'] = $this->user->getName();
        
        $data['titulo'] = 'Conjuntos';
		$data['menu'] = 'conjuntos';
    	$f = new Frota();
        $data['joints'] = $f->getAllJoints();

    	$this->loadTemplate('frota/conjunto', $data);
    }

    public function edit_conjunto($id)
    {
        $data['titulo'] = 'Editar Conjunto';

        $f = new Frota();
        $data = array('user' => $this->user);
        $data['name'] = $this->user->getName();
        $data['joints'] = $f->getAllJoints();
        $data['joint'] = $f->getJointId($id);

        $this->loadTemplate('frota/joint_edit', $data);
    }

    public function edit_joint_action()
    {
        $f = new Frota();
        if(isset($_POST['numero']) && !empty($_POST['numero'])) {
            
            $numero  = addslashes(trim($_POST['numero']));
            $placa   = addslashes(trim($_POST['placa']));
            $tipo    = addslashes(trim($_POST['tipo']));
            $vinculo = addslashes(trim($_POST['vinculo']));
            $status  = addslashes(trim($_POST['status']));
            $id      = addslashes(trim($_POST['id']));

            if (isset($_POST['id_user']) && !empty($_POST['id_user'])) {
                $user   = addslashes(trim($_POST['id_user']));
                $action = 'Editou o conjunto '.$numero;
                $access = new Access();
                $access->editActionFleet($user, $action);
            }

            $f->editJoint($numero, $placa, $tipo, $vinculo, $status, $id);
            header('Location: '.BASE_URL.'frota/conjuntos');
            exit;
        }
    }

}