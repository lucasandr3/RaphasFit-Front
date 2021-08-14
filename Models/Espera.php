<?php
namespace Models;

use \Core\Model;

class Espera extends Model
{
	public function getCat()
	{
		$array = array();

		$sql ="SELECT * FROM cat_receita";
		$sql = $this->db->query($sql);

		if ($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function getCatDes()
	{
		$array = array();

		$sql ="SELECT * FROM cat_despesa";
		$sql = $this->db->query($sql);

		if ($sql->rowCount() > 0) {
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}

		return $array;
	}

	public function addReceita($descricao, $valor, $data_d, $conta, $id_cat, $id_user)
	{
		$sql ="INSERT INTO receita SET descricao = :descricao, valor = :valor, data_d = :data_d,
		conta = :conta, id_cat = :id_cat, id_user = :id_user";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':descricao', $descricao);
		$sql->bindValue(':valor', $valor);
		$sql->bindValue(':data_d', $data_d);
		$sql->bindValue(':conta', $conta);
		$sql->bindValue(':id_cat', $id_cat);
		$sql->bindValue(':id_user', $id_user);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$_SESSION['msg'] = "Swal.fire({
                                  position: 'center',
                                  type: 'success', 
                                  title: 'Receita Adicionada Com Sucesso!',
                                  showConfirmButton: false,
                                  timer: 2500
                                })";
		} else {
			$_SESSION['msg'] = "Swal.fire({
                                  position: 'center',
                                  type: 'error',
                                  title: 'Erro ao Adicionar Receita!',
                                  showConfirmButton: false,
                                  timer: 2500
                                })";
		}
	}

	public function getAll()
	{
		$array = array();
		
		$sql ="SELECT * FROM waiting ORDER BY final DESC";
		$sql = $this->db->query($sql);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$array = $sql->fetchAll();
		}

		return $array;
	}

	public function getTotal($id_user)
	{
		$array = array();

		$sql ="SELECT SUM(valor), moeda_res FROM receita WHERE id_user = :id_user";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$array = $sql->fetch();
		}

		return $array;
	}

	public function getTotalRecorrente($id_user)
	{
		$array = array();

		$sql ="SELECT SUM(valor) FROM rec_recorrente WHERE id_user = :id_user";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$array = $sql->fetch();
		}

		return $array;
	}

	public function addRecRecorrente($descricao, $valor, $ventrada, $juro, $qtd_parc, $data_parc, $conta, $id_cat, $id_user)
	{
		$sql ="INSERT INTO rec_recorrente SET descricao = :descricao, valor = :valor, ventrada = :ventrada, juro = :juro, qtd_parc = :qtd_parc, data_parc = :data_parc, conta = :conta, id_cat = :id_cat, id_user = :id_user";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':descricao', $descricao);
		$sql->bindValue(':valor', $valor);
		$sql->bindValue(':ventrada', $ventrada);
		$sql->bindValue(':juro', $juro);
		$sql->bindValue(':qtd_parc', $qtd_parc);
		$sql->bindValue(':data_parc', $data_parc);
		$sql->bindValue(':conta', $conta);
		$sql->bindValue(':id_cat', $id_cat);
		$sql->bindValue(':id_user', $id_user);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$_SESSION['msg'] = "Swal.fire({
                                  position: 'center',
                                  type: 'success', 
                                  title: 'Receita Adicionada Com Sucesso!',
                                  showConfirmButton: false,
                                  timer: 2500
                                })";
		} else {
			$_SESSION['msg'] = "Swal.fire({
                                  position: 'center',
                                  type: 'error',
                                  title: 'Erro ao Adicionar Receita!',
                                  showConfirmButton: false,
                                  timer: 2500
                                })";
		}
	}

	public function getAllReco()
	{
		$array = array();

		$sql ="SELECT * FROM rec_recorrente as rc INNER JOIN cat_despesa as cd ON(rc.id_cat = cd.id)";
		$sql = $this->db->query($sql);
		$sql->execute();

		if ($sql->rowCount() > 0) {
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}

		return $array;
	}

	public function getRevenueList($period1, $period2, $id_user) {
		$array = array();
		$currentDay = $period1;
		while($period2 != $currentDay) {
			$array[$currentDay] = 0;
			$currentDay = date('Y-m-d', strtotime('+1 day', strtotime($currentDay)));
		}

		$sql = "SELECT DATE_FORMAT(data_d, '%Y-%m-%d') as data_d, SUM(valor) as total FROM receita WHERE id_user = :id_user AND data_d BETWEEN :period1 AND :period2 GROUP BY DATE_FORMAT(data_d, '%Y-%m-%d')";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id_user', $id_user);
		$sql->bindValue(':period1', $period1);
		$sql->bindValue(':period2', $period2);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$rows = $sql->fetchAll();

			foreach($rows as $item) {
				$array[$item['data_d']] = $item['total'];
			}
		}


		return $array;
	}
}	 