<?php
namespace Models;

use \Core\Model;

class Frente extends Model {

	public function getAll()
	{
		$array = array();

		$sql = "SELECT * FROM fronts WHERE status = 0";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}

		return $array;
    }

    public function getAllFrontInativas()
	{
		$array = array();

		$sql = "SELECT * FROM fronts WHERE status = 1";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}

		return $array;
	}

    public function saveFrente($front, $status)
	{
		$sql ="INSERT INTO fronts SET front = :f, status = :s";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':f', $front);	
		$sql->bindValue(':s', $status);
		$sql->execute();
		
		if($sql->rowCount() > 0) {
			$_SESSION['alert'] = '<div class="alert alert-success mt-4" role="alert">
			            <strong><i class="fas fa-check"></i></strong> Frente Cadastrada Com Sucesso.
                        </div>';
		} else {
			$_SESSION['alert'] = '<div class="alert alert-danger mt-4" role="alert">
			            <strong><i class="fas fa-frown"></i></strong> Erro ao Cadastrar Frente.
                        </div>';
		}
    }

    public function editFront($front, $status, $id)
	{
		$sql ="UPDATE fronts SET front = :f, status = :s WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':f', $front);		
		$sql->bindValue(':s', $status);	
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$_SESSION['alert'] = '<div class="alert alert-success mt-4" role="alert">
			            <strong><i class="fas fa-check"></i></strong> Frente Editada Com Sucesso.
                        </div>';
		} else {
			$_SESSION['alert'] = '<div class="alert alert-danger mt-4" role="alert">
			            <strong><i class="fas fa-frown"></i></strong> Erro ao Editar Frente.
                        </div>';
		}
	}

    public function getFrontId($id)
	{
		$array = array();

		$sql ="SELECT * FROM fronts WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();
		
		if($sql->rowCount() > 0) {
		   $array = $sql->fetch(\PDO::FETCH_ASSOC);	
		}

		return $array;
	}
    
    public function toggleStatus($front)
	{
		$sql ="UPDATE fronts SET status = 1 - status WHERE front = '$front'";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$_SESSION['alert'] = '<div class="alert alert-success mt-4" role="alert">
			            <strong><i class="fas fa-check"></i></strong> Frente Inativada Com Sucesso.
                        </div>';
		} else {
			$_SESSION['alert'] = '<div class="alert alert-danger mt-4" role="alert">
			            <strong><i class="fas fa-frown"></i></strong> Erro ao Inativar Frente.
                        </div>';
		}
    }
    
    public function toggleStatusActive($front)
	{
		$sql ="UPDATE fronts SET status = 0 WHERE front = '$front'";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$_SESSION['alert'] = '<div class="alert alert-success mt-4" role="alert">
			            <strong><i class="fas fa-check"></i></strong> Frente Ativada Com Sucesso.
                        </div>';
		} else {
			$_SESSION['alert'] = '<div class="alert alert-danger mt-4" role="alert">
			            <strong><i class="fas fa-frown"></i></strong> Erro ao Ativar Frente.
                        </div>';
		}
	}
}    