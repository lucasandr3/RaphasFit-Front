<?php
namespace Controllers;

use \Core\Controller;
use \Models\Produtos;
use \Models\Usuarios;
use \Models\Configuracoes;

class ConfiguracoesController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = new Usuarios();

        if (!$this->user->verifyLogin()) {
            header("Location: ".BASE_URL."login");
            exit;
        }
    }

    public function index()
    {
        $data = array('user' => $this->user);
        $data['name'] = $this->user->getName();

        $u = new Usuarios();
        $data['dark'] = $u->getMode();

        $c = new Configuracoes();
        $data['config'] = $c->getDados();

        $this->loadTemplate('config/configuracoes', $data);
    }

    public function edit_empresa()
    {
        $c = new Configuracoes();
        if(isset($_POST['nome_empresa']) && !empty($_POST['nome_empresa'])) {
            
            $nome_empresa = addslashes(trim($_POST['nome_empresa']));
            $cep          = addslashes(trim($_POST['cep']));
            $endereco     = addslashes(trim($_POST['endereco']));
            $bairro       = addslashes(trim($_POST['bairro']));
            $complemento  = addslashes(trim($_POST['complemento']));
            $cidade       = addslashes(trim($_POST['cidade']));
            $estado       = addslashes(trim($_POST['estado']));
            $email        = addslashes(trim($_POST['email']));
            $tel          = addslashes(trim($_POST['tel']));

            $c->updateDados($nome_empresa, $cep, $endereco, $bairro, $complemento,
            $cidade, $estado, $email, $tel);
            header('Location: '.BASE_URL.'configuracoes');
            exit;
        }
    }
}