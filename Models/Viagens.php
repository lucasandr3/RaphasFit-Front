<?php
namespace Models;

use \Core\Model;

class Viagens extends Model {

	public function getAll()
	{
		$array = array();

		$data_atual = date('Y-m-d');

		$sql = "SELECT * FROM steps_travel WHERE finalized = 0 AND date_travel = '$data_atual'";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}

		return $array;
	}
	
	public function getTravelId($id)
	{
		$array = array();

		$sql = "SELECT id_travel_step, driver, frente, fleet, date_travel FROM steps_travel WHERE id_travel_step = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetch(\PDO::FETCH_ASSOC);
		}

		return $array;
	}
	
	public function stepini($id)
	{
        $array = array();
        $sql ="SELECT date_init FROM control_init WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetch(\PDO::FETCH_ASSOC);
        }

		return $array;
	}
	
	public function stepone($id)
	{
        $array = array();

        $sql ="SELECT * FROM control_init as ci LEFT JOIN front_arrival as fa ON ci.id = fa.id_travel_ar WHERE id_travel_ar = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetch(\PDO::FETCH_ASSOC);
        }

		return $array;
	}
	
	public function steptwo($id)
	{
        $array = array();

        $sql ="SELECT date_exit FROM front_exit WHERE id_travel_ex = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetch(\PDO::FETCH_ASSOC);
        }

		return $array;
	}
	
	public function stepthree($id)
	{
        $array = array();

        $sql ="SELECT * FROM front_exit as fe INNER JOIN balance_arrival as ba ON (fe.id_travel_ex = ba.id_travel_bal) WHERE id_travel_bal = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetch(\PDO::FETCH_ASSOC);
        }

		return $array;
	}
	
	public function stepfour($id)
	{
        $array = array();

        $sql ="SELECT * FROM balance_arrival as ba INNER JOIN discharge as di ON (ba.id_travel_bal = di.id_travel_dis) WHERE id_travel_bal = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetch(\PDO::FETCH_ASSOC);
        }

        return $array;
        
        
	}
	
	public function stepfive($id)
	{
        $array = array();

        $dataActual = date('Y-m-d').' 00:00:00';

        $sql ="SELECT * FROM control_init as ci INNER JOIN front_arrival as fa ON(ci.id = fa.id_travel_ar)
        INNER JOIN front_exit as fe ON (ci.id = fe.id_travel_ex)
        INNER JOIN balance_arrival as ba ON (ci.id = ba.id_travel_bal)
        INNER JOIN discharge as di ON (ci.id = di.id_travel_dis)
        INNER JOIN control_final as cf ON (ci.id = cf.id_travel_fi) WHERE id_travel_fi = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id', $id);
		$sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetch(\PDO::FETCH_ASSOC);
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

    // public function getFrontId($id)
	// {
	// 	$array = array();

	// 	$sql ="SELECT * FROM fronts WHERE id = :id";
	// 	$sql = $this->db->prepare($sql);
	// 	$sql->bindValue(':id', $id);
	// 	$sql->execute();
		
	// 	if($sql->rowCount() > 0) {
	// 	   $array = $sql->fetch(\PDO::FETCH_ASSOC);	
	// 	}

	// 	return $array;
	// }
    
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