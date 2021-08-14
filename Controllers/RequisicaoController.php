<?php
namespace Controllers;

use \Core\Controller;
use \Models\Requisicao;
use \Models\Usuarios;
use \Models\Clientes;

class RequisicaoController extends Controller
{
	// private $user;

    // public function __construct()
    // {
    //     $this->user = new Usuarios();

    //     if (!$this->user->verifyLogin()) {
	// 		header("Location: ".APP);
	// 		$resposta['msg'] = 'Não está logado';
    //         exit;
	// 	}
    // }

	public function signinMobile()
    {
      if (!empty($_POST['email_user']) && !empty($_POST['email_user'])) {

        $email_user = addslashes(trim($_POST['email_user']));
        $senha = addslashes(trim($_POST['senha']));
		echo "<pre>";
		print_r($_POST);
		echo "</pre>";
		exit;
        $uid = new Usuarios();
        if ($uid->validateUser($email_user, $senha)) {
		  $resposta['code'] = 0;	
		  $resposta['msg'] = 'Login efetuado com sucesso.';
		  echo json_encode($resposta);
          exit;

        } else {
			$resposta['code'] =  1; 
			$resposta['msg'] = 'E-mail e senha são obrigatórios';
			echo json_encode($resposta);		
          exit;
        }

      } else {
		$resposta['code'] =  2; 
		$resposta['msg'] = 'Campos estão vazios';
		echo json_encode($resposta);
        exit;
      }
    }

	public function add()
	{
		if(isset($_POST['name']) && !empty($_POST['name'])) {

			$name        = addslashes(trim($_POST['name']));
			$category	 = addslashes(trim($_POST['category']));
			$img		 = addslashes(trim($_POST['img']));
			$price		 = addslashes(trim($_POST['price']));
			$description = addslashes(trim($_POST['description']));

			$r = new Requisicao();
			$r->newProd($name, $category, $img, $price, $description);
		}
	}

	public function produtos($category=NULL)
	{
		$r = new Requisicao(); 

		if ($category) {

			$resposta = $r->listCatId($category);

			header("Content-Type: application/json");
			echo json_encode($resposta);

		} else {

			$resposta = $r->listAll();

			header("Content-Type: application/json");
			echo json_encode($resposta);

		}
	}

	public function produtoId($id_prod)
	{
		$r = new Requisicao();
		$id_comp = $r->prodId($id_prod);
		$id = array('id_prod' => $id_prod);

		$resposta = $r->getProductId($id_prod);

		if ($id == $id_comp) {

				header("Content-Type: application/json");
				echo json_encode($resposta);

		} else {
			
			$resposta['failed'] = 'Produto Não exite no banco de dados';
			$resposta['error']  = 10;
			echo json_encode($resposta);
		}
	}

	public function produtoPorNome($name)
	{
		$r = new Requisicao();

		$resposta = $r->getProductByName($name);
		header("Content-Type: application/json");
		echo json_encode($resposta);
		// if ($resposta) {

		// 		header("Content-Type: application/json");
		// 		echo json_encode($resposta);

		// } else {
			
		// 	$resposta['failed'] = 'Produto Não exite no banco de dados';
		// 	$resposta['error']  = 10;
		// 	echo json_encode($resposta);
		// }
	}

	public function del($id_prod)
	{
		$r = new Requisicao();
		$id_comp = $r->prodId($id_prod);
		$id = array('id_prod' => $id_prod);

		if ($id == $id_comp) {
			
			$r->delProduto($id_prod);
			$resposta['success'] = 'Produto Excluido com Sucesso';
			$resposta['error']   = 0;
			echo json_encode($resposta);
			exit;

		} else {
			
			$resposta['failed'] = 'Produto Não existe no banco de dados';
			$resposta['error']  = 10;
			echo json_encode($resposta);
			exit;
		}
		
	}

	public function Clientes()
	{
		$r = new Requisicao();
		$resposta = $r->listAllClientes();

		header("Content-Type: application/json");
		echo json_encode($resposta);
	}

	public function Categorias()
	{
		$r = new Requisicao();
		$resposta = $r->listAllCategorias();

		header("Content-Type: application/json");
		echo json_encode($resposta);
	}

	public function add_cliente()
    {
        $r = new Requisicao();
        if(isset($_POST['nome_cliente']) && !empty($_POST['nome_cliente'])) {
            
            $nome_cliente = addslashes(trim($_POST['nome_cliente']));
            $ie           = addslashes(trim($_POST['ie']));
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
			
            $r->saveCliente($nome_cliente, $ie, $doc, $cep, $endereco, $numero, $bairro,
            $complemento, $cidade, $estado, $email, $tel, $status);
        }
	}
	
	public function add_produto()
    {
		// echo "<pre>";
		// print_r($_POST);
		// echo "</pre>";
		// exit;
        $r = new Requisicao();
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
     
                   $r->saveProduct($codigo, $cod_final, $initials, $name, $category, $price, $description, $nome);
                }
            }
        }
    }

	public function notificacao() {

		echo json_encode("Atualizado com sucesso");
		exit;
	}
}    