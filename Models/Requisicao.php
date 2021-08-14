<?php
namespace Models;

use \Core\Model;

class Requisicao extends Model
{
	// Função Adiciona um novo produto
	public function newProd($name, $category, $img, $price, $description)
	{
		$sql ="INSERT INTO produtos SET name = :n, category = :c, img = :i, price = :p, description = :d";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(":n", $name);
		$sql->bindValue(":c", $category);
		$sql->bindValue(":i", $img);
		$sql->bindValue(":p", $price);
		$sql->bindValue(":d", $description);
		$sql->execute();
	}

	// Função lista todos os produtos cadastrados no banco
	public function listAll()
	{
		$sql = "SELECT * FROM produtos";
		$sql = $this->db->query($sql);
		return $resposta = $sql->fetchAll(\PDO::FETCH_ASSOC);
	}

	// Função lista todos os produtos cadastrados no banco
	public function getProductId($id_prod)
	{
		$sql = "SELECT * FROM produtos WHERE id_prod = '$id_prod'";
		$sql = $this->db->query($sql);
		return $resposta = $sql->fetch(\PDO::FETCH_ASSOC);
	}

	public function getProductByName($name)
	{
		$sql = "SELECT * FROM produtos WHERE name LIKE :name";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':name', '%'.$name.'%');
		$sql->execute();
		return $resposta = $sql->fetchAll(\PDO::FETCH_ASSOC);
	}

	// Função lista todos os produtos da categoria
	public function listCatId($category)
	{
		$sql = "SELECT * FROM produtos WHERE category = '$category'";
		$sql = $this->db->query($sql);
		return $resposta = $sql->fetchAll(\PDO::FETCH_ASSOC);
	}

	// Função faz a busca por um Id para fazer comparação no controller para excluir produto
	public function prodId($id_prod)
	{
		$sql = "SELECT id_prod FROM produtos WHERE id_prod = '$id_prod'";
		$sql = $this->db->query($sql);
		return $id_comp = $sql->fetch(\PDO::FETCH_ASSOC);
	}

	// Função que excluir o produto
	public function delProduto($id_prod) {
		$this->db->query("DELETE FROM produtos WHERE id_prod = '$id_prod'");
	}

	// Função lista todos os clientes cadastrados no banco
	public function listAllClientes()
	{
		$sql = "SELECT nome_cliente FROM clientes";
		$sql = $this->db->query($sql);
		return $resposta = $sql->fetchAll(\PDO::FETCH_ASSOC);
	}

	// Função lista todos as categorias cadastrados no banco
	public function listAllCategorias()
	{
		$sql = "SELECT * FROM `categoria`";
		$sql = $this->db->query($sql);
		return $resposta = $sql->fetchAll(\PDO::FETCH_ASSOC);
	}

	// salva cliente
	public function saveCliente($nome_cliente, $ie, $doc, $cep, $endereco, $numero, $bairro,
    $complemento, $cidade, $estado, $email, $tel, $status)
	{
        $sql ="INSERT INTO clientes SET nome_cliente = :nc, ie = :ie, doc = :d, cep = :cep, endereco = :ende, numero = :nu,
        bairro = :b, complemento = :com, cidade = :cid, estado = :es, email = :em, tel = :t, status = :st, data_cadastro = NOW()";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':nc', $nome_cliente);	
		$sql->bindValue(':ie', $ie);	
		$sql->bindValue(':d', $doc);	
		$sql->bindValue(':cep', $cep);	
		$sql->bindValue(':ende', $endereco);	
		$sql->bindValue(':nu', $numero);	
		$sql->bindValue(':b', $bairro);
		$sql->bindValue(':com', $complemento);
		$sql->bindValue(':cid', $cidade);
		$sql->bindValue(':es', $estado);
		$sql->bindValue(':em', $email);
		$sql->bindValue(':t', $tel);
		$sql->bindValue(':st', $status);
		$sql->execute();
		
		if($sql->rowCount() > 0) {
			$resposta = 'Registro feito com sucesso.';
			echo json_encode($resposta);
		} else {
			return $resposta = 'Falha ao criar registro.';
			echo json_encode($resposta);
		}
	}
	
	public function saveProduct($codigo, $cod_final, $initials, $name, $category, $price, $description, $nome)
	{
		$sql ="INSERT INTO produtos SET codigo = :cd, cod_final = :cf, initials = :in, name = :n, category = :c, price = :p, description = :d, img = :u";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':cd', $codigo);	
		$sql->bindValue(':cf', $cod_final);	
		$sql->bindValue(':in', $initials);	
		$sql->bindValue(':n', $name);	
		$sql->bindValue(':c', $category);	
		$sql->bindValue(':p', $price);	
		$sql->bindValue(':d', $description);	
		$sql->bindValue(':u', $nome);
		$sql->execute();
	
		if($sql->rowCount() > 0) {
			$resposta = true;
			echo json_encode($resposta);
		} else {
			$resposta = false;
			echo json_encode($resposta);
		}
	}
}