<?php
namespace Models;

use \Core\Model;

class Clientes extends Model
{
    public function getAll()
    {
        $array = array();
        $sql ="SELECT * FROM clientes";
        $sql = $this->db->query($sql);
        if($sql->rowCount() > 0) {
           $array = $sql->fetchAll(\PDO::FETCH_ASSOC);
        }
        return $array;
    }

    public function saveCliente($nome_cliente, $ie, $doc, $cep, $endereco, $numero, $bairro,
    $complemento, $cidade, $estado, $email, $tel, $status, $score)
	{
		echo "<pre>";
		print_r($nome_cliente);
		echo "<pre>";
		print_r($ie);
		echo "<pre>";
		print_r($doc);
		echo "<pre>";
		print_r($cep);
		echo "<pre>";
		print_r($endereco);
		echo "<pre>";
		print_r($numero);
		echo "<pre>";
		print_r($bairro);
		echo "<pre>";
		print_r($complemento);
		echo "<pre>";
		print_r($cidade);
		echo "<pre>";
		print_r($estado);
		echo "<pre>";
		print_r($email);
		echo "<pre>";
		print_r($tel);
		echo "<pre>";
		print_r($status);
		exit;
        $sql ="INSERT INTO clientes SET nome_cliente = :nc, ie = :ie, doc = :d, cep = :cep, endereco = :ende, numero = :nu,
        bairro = :b, complemento = :com, cidade = :cid, estado = :es, email = :em, tel = :t, status = :st,
        score = :sc, data_cadastro = NOW()";
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
		$sql->bindValue(':sc', $score);
		$sql->execute();
		
		if($sql->rowCount() > 0) {
			$_SESSION['alert'] = '<div class="alert alert-success mt-4" role="alert">
			            <strong><i class="fas fa-check"></i></strong> Cliente Cadastrado Com Sucesso.
                        </div>';
		} else {
			$_SESSION['alert'] = '<div class="alert alert-danger mt-4" role="alert">
			            <strong><i class="fas fa-frown"></i></strong> Erro ao cadastrar Cliente.
                        </div>';
		}
    }
    
    public function getClienteId($id_cliente)
	{
		$array = array();

		$sql ="SELECT * FROM clientes WHERE id_cliente = :id_cliente";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_cliente', $id_cliente);
		$sql->execute();
		
		if($sql->rowCount() > 0) {
		   $array = $sql->fetch(\PDO::FETCH_ASSOC);	
		}

		return $array;
    }
    
    public function editCliente($nome_cliente, $doc, $cep, $endereco, $numero, $bairro,
    $complemento, $cidade, $estado, $email, $tel, $status, $score, $id_cliente)
	{
        $sql ="UPDATE clientes SET nome_cliente = :nc, doc = :d, cep = :cep, endereco = :ende, numero = :nu,
        bairro = :b, complemento = :com, cidade = :cid, estado = :es, email = :em, tel = :t, status = :st,
        score = :sc WHERE id_cliente = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':nc', $nome_cliente);	
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
		$sql->bindValue(':sc', $score);
		$sql->bindValue(':id', $id_cliente);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$_SESSION['alert'] = '<div class="alert alert-success mt-4" role="alert">
			            <strong><i class="fas fa-check"></i></strong> Cliente Atualizado Com Sucesso.
                        </div>';
		} else {
			$_SESSION['alert'] = '<div class="alert alert-danger mt-4" role="alert">
			            <strong><i class="fas fa-frown"></i></strong> Erro ao Atualizar Cliente.
                        </div>';
		}
    }
    
    public function toggleStatus($id_cliente)
	{
		$sql ="UPDATE clientes SET status = 1 - status WHERE id_cliente = '$id_cliente'";
        $sql = $this->db->query($sql);
        
        if($sql->rowCount() > 0) {
			$_SESSION['alert'] = '<div class="alert alert-success mt-4" role="alert">
			            <strong><i class="fas fa-check"></i></strong> Cliente Atualizado Com Sucesso.
                        </div>';
		} else {
			$_SESSION['alert'] = '<div class="alert alert-danger mt-4" role="alert">
			            <strong><i class="fas fa-frown"></i></strong> Erro ao Atualizar Cliente.
                        </div>';
		}
	}

	public function getTotal()
	{	
		$array = array();
		$sql ="SELECT count(*) as total_c FROM clientes";
		$sql = $this->db->query($sql);
		if($sql->rowCount() > 0) {
		   $array = $sql->fetch(\PDO::FETCH_ASSOC);
		}
		return $array;
	}
}