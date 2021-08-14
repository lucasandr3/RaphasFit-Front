<?php
namespace Models;

use \Core\Model;

class Frota extends Model {

	public function getAll()
	{
		$array = array();

		$sql = "SELECT * FROM fleet WHERE status = 0";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}

		return $array;
    }

    public function getAllFleetInativas()
	{
		$array = array();

		$sql = "SELECT * FROM fleet WHERE status = 1";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}

		return $array;
	}

    public function saveFleet($fleet, $placa, $modelo, $equipamento, $marca, $status)
	{
		$sql ="INSERT INTO fleet SET fleet = :f, plaque = :p, model = :m, equipment = :e, mark = :ma, status = :s";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':f', $fleet);	
		$sql->bindValue(':p', $placa);	
		$sql->bindValue(':m', $modelo);	
		$sql->bindValue(':e', $equipamento);	
		$sql->bindValue(':ma', $marca);	
		$sql->bindValue(':s', $status);
		$sql->execute();
		
		if($sql->rowCount() > 0) {
			$_SESSION['alert'] = '<div class="alert alert-success mt-4" role="alert">
			            <strong><i class="fas fa-check"></i></strong> Frota Cadastrada Com Sucesso.
                        </div>';
		} else {
			$_SESSION['alert'] = '<div class="alert alert-danger mt-4" role="alert">
			            <strong><i class="fas fa-frown"></i></strong> Erro ao Cadastrar Frota.
                        </div>';
		}
    }

    public function editFleet($fleet, $plaque, $model, $equipment, $mark, $status, $id)
	{
		$sql ="UPDATE fleet SET fleet = :f, plaque = :p, model = :m, equipment = :e, mark = :ma, status = :s WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':f', $fleet);	
		$sql->bindValue(':p', $plaque);	
		$sql->bindValue(':m', $model);	
		$sql->bindValue(':e', $equipment);	
		$sql->bindValue(':ma', $mark);	
		$sql->bindValue(':s', $status);	
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$_SESSION['alert'] = '<div class="alert alert-success mt-4" role="alert">
			            <strong><i class="fas fa-check"></i></strong> Frota Editada Com Sucesso.
                        </div>';
		} else {
			$_SESSION['alert'] = '<div class="alert alert-danger mt-4" role="alert">
			            <strong><i class="fas fa-frown"></i></strong> Erro ao Editar Frota.
                        </div>';
		}
	}

    public function getFleetId($id)
	{
		$array = array();

		$sql ="SELECT * FROM fleet WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();
		
		if($sql->rowCount() > 0) {
		   $array = $sql->fetch(\PDO::FETCH_ASSOC);	
		}

		return $array;
	}
    
    public function toggleStatus($fleet)
	{
		$sql ="UPDATE fleet SET status = 1 - status WHERE fleet = '$fleet'";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$_SESSION['alert'] = '<div class="alert alert-success mt-4" role="alert">
			            <strong><i class="fas fa-check"></i></strong> Frota Inativada Com Sucesso.
                        </div>';
		} else {
			$_SESSION['alert'] = '<div class="alert alert-danger mt-4" role="alert">
			            <strong><i class="fas fa-frown"></i></strong> Erro ao Inativar Frota.
                        </div>';
		}
    }
    
    public function toggleStatusActive($fleet)
	{
		$sql ="UPDATE fleet SET status = 0 WHERE fleet = '$fleet'";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$_SESSION['alert'] = '<div class="alert alert-success mt-4" role="alert">
			            <strong><i class="fas fa-check"></i></strong> Frota Ativada Com Sucesso.
                        </div>';
		} else {
			$_SESSION['alert'] = '<div class="alert alert-danger mt-4" role="alert">
			            <strong><i class="fas fa-frown"></i></strong> Erro ao Ativar Frota.
                        </div>';
		}
	}

	public function getAllJoints()
	{
		$array = array();

		$sql = "SELECT * FROM equipaments WHERE status = 0";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}

		return $array;
	}
	
	public function getJointId($id)
	{
		$array = array();

		$sql ="SELECT * FROM equipaments WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();
		
		if($sql->rowCount() > 0) {
		   $array = $sql->fetch(\PDO::FETCH_ASSOC);	
		}

		return $array;
	}

	public function editJoint($numero, $placa, $tipo, $vinculo, $status, $id)
	{
		$sql ="UPDATE equipaments SET numero = :n, placa = :p, tipo = :t, vinculo = :v, status = :s WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':n', $numero);	
		$sql->bindValue(':p', $placa);	
		$sql->bindValue(':t', $tipo);	
		$sql->bindValue(':v', $vinculo);		
		$sql->bindValue(':s', $status);	
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$_SESSION['alert'] = '<div class="alert alert-success mt-4" role="alert">
			            <strong><i class="fas fa-check"></i></strong> Conjunto Editado Com Sucesso.
                        </div>';
		} else {
			$_SESSION['alert'] = '<div class="alert alert-danger mt-4" role="alert">
			            <strong><i class="fas fa-frown"></i></strong> Erro ao Editar Conjunto.
                        </div>';
		}
	}
}    