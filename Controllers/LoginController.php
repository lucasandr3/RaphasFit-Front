<?php
namespace Controllers;

use \Core\Controller;
use \Models\Usuarios;

class LoginController extends Controller
{
	public function index()
	{
		$data = array('msg' => '');
		if (!empty($_GET['error'])) {
        	if ($_GET['error'] == '1') {
          	$data['msg'] = 'Usuário e/ou Senha Inválidos.';
        	}
      	}
		$this->loadView('login/login', $data);
	}

	public function signin()
    {
      if (!empty($_POST['email_user']) && !empty($_POST['email_user'])) {

        $email_user = addslashes(trim($_POST['email_user']));
        $senha = addslashes(trim($_POST['senha']));

        $uid = new Usuarios();
        if ($uid->validateUser($email_user, $senha)) {
          header("Location: ".BASE_URL);
          $uid->hora_entrada();
          exit;

        } else {

          header("Location: ".BASE_URL."login?error=1");
          exit;
        }

      } else {

        header("Location: ".BASE_URL."login");
        exit;
      }
    }

    public function signup()
    {
      $data = array();

      if (!empty($_POST['nome_user']) && !empty($_POST['nome_user'])) {
        
        $nome_user       = addslashes(trim($_POST['nome_user']));  
        $email_user      = addslashes(trim($_POST['email_user']));
        $senha      = addslashes(trim($_POST['senha']));

        echo "<pre>";
        print_r($_POST);
        echo "</pre>";
        exit;

        $uid = new Usuarios();

          if (!$uid->userExists($nome_user)) {
            $uid->registerUser($nome_user, $email_user, $senha);

            header("Location: ".BASE_URL."login");
            exit;
          } else {

            $data['msg'] = 'E-mail já está Cadastrado.';
          }
      }

      $this->loadView('cadastrar', $data);
    }

    public function logout()
    {
      $uid = new Usuarios();
      $uid->ultimoAcesso($_SESSION['idus']);
      unset($_SESSION['uLogin']);
      header("Location: ".BASE_URL."login");
      exit;
    }
}