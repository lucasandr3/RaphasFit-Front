<?php
namespace Models;

use \Core\Model;

class Motoristas extends Model {

	public function getAll()
	{
		$array = array();

		$sql = "SELECT * FROM drivers WHERE status = 0";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}

		return $array;
	}

	public function getAllPedidos()
	{
		$array = array();

		$sql = "SELECT * FROM pedidos";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}

		return $array;
	}

	public function getAllPedidosDia()
	{
		$array = array();

		$dataAtual = date('Y-m-d');

		$sql = "SELECT * FROM pedidos WHERE data_pedido LIKE '$dataAtual%'";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}

		return $array;
	}

	public function getAllPedidosProds($id_pedido)
	{
		$array = array();

		$sql = "SELECT * FROM pedidos as p INNER JOIN clientes as c ON(p.cliente = c.nome_cliente) WHERE id_pedido = :id_pedido";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_pedido', $id_pedido);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetch(\PDO::FETCH_ASSOC);
		}

		return $array;
	}

	public function getAllDriversInativos()
	{
		$array = array();

		$sql = "SELECT * FROM drivers WHERE status = 1";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}

		return $array;
	}

	public function getCategorias()
	{
		$array = array();

		$sql ="SELECT * FROM categoria";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
		   $array = $sql->fetchAll(\PDO::FETCH_ASSOC);	
		}
		return $array;
	}

	public function getCatId($id_cat)
	{
		$sql ="SELECT id_cat FROM categoria WHERE id_cat = '$id_cat'";
		$sql = $this->db->query($sql);
		return $cat_nome = $sql->fetch(\PDO::FETCH_ASSOC);
	}

	public function saveDriver($code, $name, $password, $function, $status)
	{
		$sql ="INSERT INTO drivers SET code_driver = :c, name_driver = :n, password = :p, function = :f, status = :s";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':c', $code);	
		$sql->bindValue(':n', $name);	
		$sql->bindValue(':p', md5($password));	
		$sql->bindValue(':f', $function);	
		$sql->bindValue(':s', $status);
		$sql->execute();
		
		if($sql->rowCount() > 0) {
			$_SESSION['alert'] = '<div class="alert alert-success mt-4" role="alert">
			            <strong><i class="fas fa-check"></i></strong> Motorista Cadastrado Com Sucesso.
                        </div>';
		} else {
			$_SESSION['alert'] = '<div class="alert alert-danger mt-4" role="alert">
			            <strong><i class="fas fa-frown"></i></strong> Erro ao Cadastrar Motorista.
                        </div>';
		}
	}

	public function getDriverId($id)
	{
		$array = array();

		$sql ="SELECT * FROM drivers WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();
		
		if($sql->rowCount() > 0) {
		   $array = $sql->fetch(\PDO::FETCH_ASSOC);	
		}

		return $array;
	}

	public function editDriver($code, $name, $function, $password, $status, $id)
	{
		$sql ="UPDATE drivers SET code_driver = :c, name_driver = :n, function = :f, password = :p, status = :s WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':c', $code);	
		$sql->bindValue(':n', $name);	
		$sql->bindValue(':f', $function);	
		$sql->bindValue(':p', md5($password));	
		$sql->bindValue(':s', $status);	
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$_SESSION['alert'] = '<div class="alert alert-success mt-4" role="alert">
			            <strong><i class="fas fa-check"></i></strong> Motorista Editado Com Sucesso.
                        </div>';
		} else {
			$_SESSION['alert'] = '<div class="alert alert-danger mt-4" role="alert">
			            <strong><i class="fas fa-frown"></i></strong> Erro ao Editar Motorista.
                        </div>';
		}
	}

	public function toggleStatus($name)
	{
		$sql ="UPDATE drivers SET status = 1 - status WHERE name_driver = '$name'";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$_SESSION['alert'] = '<div class="alert alert-success mt-4" role="alert">
			            <strong><i class="fas fa-check"></i></strong> Motorista Desligado Com Sucesso.
                        </div>';
		} else {
			$_SESSION['alert'] = '<div class="alert alert-danger mt-4" role="alert">
			            <strong><i class="fas fa-frown"></i></strong> Erro ao Desligar Motorista.
                        </div>';
		}
	}

	public function toggleStatusActive($name)
	{
		$sql ="UPDATE drivers SET status = 0 WHERE name_driver = '$name'";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$_SESSION['alert'] = '<div class="alert alert-success mt-4" role="alert">
			            <strong><i class="fas fa-check"></i></strong> Motorista Religado Com Sucesso.
                        </div>';
		} else {
			$_SESSION['alert'] = '<div class="alert alert-danger mt-4" role="alert">
			            <strong><i class="fas fa-frown"></i></strong> Erro ao Religar Motorista.
                        </div>';
		}
	}

	public function getNameId($id_produto)
	{
		echo "<pre>";
		print_r($id_produto);
		exit;
		$array = array();

		$sql = "SELECT * FROM pedidos";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}

		return $array;
	}

	public function novoPedido($lista, $vendor, $cliente, $nota, $pag, $total)
	{
		$sql ="INSERT INTO pedidos SET prods_json = :prods_json, vendor = :vendor, cliente = :cliente, obs = :obs, pagamento = :pagamento, data_pedido = NOW(), total = :total";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':prods_json', json_encode($lista));
		$sql->bindValue(':vendor', $vendor);
		$sql->bindValue(':cliente', $cliente);
		$sql->bindValue(':obs', $nota);
		$sql->bindValue(':pagamento', $pag);
		$sql->bindValue(':total', $total);
		$sql->execute();
	}
}