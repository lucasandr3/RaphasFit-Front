<?php
namespace Controllers;

use \Core\Controller;
use \Models\Usuarios;
use \Models\Viagens;
use \Models\Frente;
use \Models\Access;

class ViagensController extends Controller
{

    private $user;

    public function __construct()
    {
        $this->user = new Usuarios();

        if (!$this->user->verifyLogin()) {
            header("Location: ".BASE_URL."login");
            exit;
		}

		if (!$this->user->hasPermission('fronts_view')) {
		$this->loadView('404/500');
        exit;
        } 
    }

    public function index()
    {
    	$data = array('user' => $this->user);
        $data['name'] = $this->user->getName();
        
        $data['titulo'] = 'Viagens';
		$data['menu'] = 'viagen';
    	$v = new Viagens();
        $data['travels'] = $v->getAll();

    	$this->loadTemplate('viagens/viagens', $data);
    }

    public function add_action()
    {
        $f = new Frente();
        if(isset($_POST['front']) && !empty($_POST['front'])) {
            
            $front       = addslashes(trim($_POST['front']));
            $status      = addslashes(trim($_POST['status']));

            if (isset($_POST['id_user']) && !empty($_POST['id_user'])) {
                $user   = addslashes(trim($_POST['id_user']));
                $action = 'Cadastrou frente '.$front;
                $access = new Access();
                $access->saveActionFront($user, $action);
            }

            $f->saveFrente($front, $status);
            header('Location: '.BASE_URL.'frente');
            exit;
        }
    }

    public function timeline($id)
    {
        $f = new Frente();
        $data = array('user' => $this->user);
        $data['name'] = $this->user->getName();

        $data['titulo'] = 'Timeline da Viagem';

        $v = new Viagens();
        $data['travel'] = $v->getTravelId($id);
        $data['stepini'] = $v->stepini($id);
		$data['stepone'] = $v->stepone($id);
		$data['steptwo'] = $v->steptwo($id);
		$data['stepthree'] = $v->stepthree($id);
		$data['stepfour'] = $v->stepfour($id);
		$data['stepfive'] = $v->stepfive($id);

        $this->loadTemplate('viagens/timeline', $data);
    }

    public function edit_action()
    {
        $f = new Frente();
        if(isset($_POST['front']) && !empty($_POST['front'])) {
            
            $front     = addslashes(trim($_POST['front']));
            $status    = addslashes(trim($_POST['status']));
            $id        = addslashes(trim($_POST['id']));

            if (isset($_POST['id_user']) && !empty($_POST['id_user'])) {
                $user   = addslashes(trim($_POST['id_user']));
                $action = 'Editou frente '.$front;
                $access = new Access();
                $access->editActionFront($user, $action);
            }

            $f->editFront($front, $status, $id);
            header('Location: '.BASE_URL.'frente');
            exit;
        }
    }

    public function inativar($front)
    {
        $user = $this->user->getName();
        $id_user = $user['id_user'];
        $action = 'Inativou a frente '.$front;
        $access = new Access();
        $access->saveActionFrontInactive($id_user, $action);
        

        $f = new Frente();
        $f->toggleStatus($front);
        header('Location: '.BASE_URL.'frente');
        exit;
    }

    public function ativar($front)
    {        
        $user = $this->user->getName();
        $id_user = $user['id_user'];
        $action = 'Ativou a frente '.$fleet;
        $access = new Access();
        $access->saveActionFrontActive($id_user, $action);
        

        $f = new Frente();
        $f->toggleStatusActive($front);
        header('Location: '.BASE_URL.'frente');
        exit;
    }

    public function inativas()
    {
        $data = array('user' => $this->user);
    	$data['name'] = $this->user->getName();
    	$f = new Frente();
        $data['front'] = $f->getAllFrontInativas();
        // $u = new Usuarios();
        // $data['dark'] = $u->getMode();
    	$this->loadTemplate('frente/frente_inativa', $data);
    }

}